<?php
namespace ChatCreeSoftware\ProjectManagementBundle\Controller;

use ChatCreeSoftware\ProjectManagementBundle\Entity\Invoice,
    ChatCreeSoftware\ProjectManagementBundle\Entity\InvoiceItem,
    ChatCreeSoftware\ProjectManagementBundle\Entity\Invoicing;
use ChatCreeSoftware\ProjectManagementBundle\Repository\InvoiceNumberingRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ChatCreeSoftware\CoreBundle\Entity\Project;

class InvoicingAjaxController extends Controller{

    /**
     * @Route( "/gestion/ajax_factures", name="_ajax_invoices" )
     */
    public function listInvoicesAction(){
        $em = $this->get('doctrine')->getManager();
        $repo = $em->getRepository('ProjectManagementBundle:Invoice');
        $invoices = $repo->findByState("O");
            
        $InvoiceArray = array();
        foreach ($invoices as $invoice ) {
            
            $invoiceTotal = 0;
            foreach( $invoice->getItems() as $item ){
                $invoiceTotal += $item->getItemPrice() * $item->getQuantity() * $item->getItemRebate();
            }
            
            $invoiceObject = array(
                "id" => $invoice->getId(),
                "projectId" => $invoice->getProject()->getId(),
                $invoice->getNumber(),
                $invoice->getDate()->format("d/m/Y"),
                $invoice->getProject()->getProjectName(),
                $invoiceTotal
            );

            $InvoiceArray[] = $invoiceObject;
        }
                
        $returnArray =array( "data" => $InvoiceArray );        
        $return = json_encode( $returnArray );
        return new Response( $return, 200);        
    }

    /**
     * @Route( "/gestion/ajax_quotes", name="_ajax_quotes" )
     */
    public function listQuotesAction(){
        $em = $this->get('doctrine')->getManager();
        $repo = $em->getRepository('ProjectManagementBundle:Invoice');
        $quotes = $repo->findByState("Q");
            
        $quoteArray = array();
        foreach ($quotes as $quote ) {
            
            $quoteTotal = 0;
            foreach( $quote->getItems() as $item ){
                $quoteTotal += $item->getItemPrice() * $item->getQuantity() * $item->getItemRebate();
            }
            
            $quoteObject = array(
                "id" => $quote->getId(),
                "projectId" => $quote->getProject()->getId(),
                $quote->getNumber(),
                $quote->getDate()->format("d/m/Y"),
                $quote->getProject()->getProjectName(),
                $quoteTotal
            );

            $quoteArray[] = $quoteObject;
        }
                
        $returnArray =array( "data" => $quoteArray );        
        $return = json_encode( $returnArray );
        return new Response( $return, 200);        
    }

    
    /**
     * @Route( "/gestion/project/ajax/facturation/list/{id}", name="_ajax_project_invoices" )
     */
    public function listProjectInvoicingAction( Project $project ){        
        $InvoiceArray = array();
        
        foreach ($project->getInvoices() as $invoice ) {
            $invoiceObject = array(
                $invoice->getEtape(),
                $invoice->getAmount(),
                $invoice->getInvoiced(),
                $invoice->getReminder(),
                $invoice->getPaid() );

            $InvoiceArray[] = $invoiceObject;
        }
                
        $returnArray =array( "data" => $InvoiceArray );
        $return = json_encode( $returnArray );
        return new Response( $return, 200);        
    }

    /**
     * @Route( "/gestion/project/ajax/facturation/new", name="_new_invoice" )
     */
    public function newInvoiceAction( Request $request ){    
        $em = $this->get('doctrine')->getManager();
        $invoicingRepo = $em->getRepository('ProjectManagementBundle:Invoicing');
        $numberingRepo = $em->getRepository('ProjectManagementBundle:InvoiceNumbering');
        
        $repo = $em->getRepository('ProjectManagementBundle:InvoicingData');
        $invoicingData=$repo->find( InvoiceNumberingRepository::INVOICING_INVOICE_DATA );
        
        $itemIds = json_decode( $request->get('itemIds'),true );        

        
        if( $itemIds ) {
            $invoice = new Invoice();
            $invoiceId = $numberingRepo->getNewInvoiceNumber();
            
            if( $invoicingData->getNumberingType() == InvoiceNumberingRepository::INVOICING_MODE_YEARLY ) {
                $today = new \DateTime();
                $year = $today->format('Y');
                $invoiceNumber = sprintf( $invoicingData->getNumberingFormat(), $year, $invoiceId );
            } else {
                $invoiceNumber = sprintf( $invoicingData->getNumberingFormat(), $invoiceId );
            }
            
            $invoice->setState("O");
            
            $invoice->setFooter( $invoicingData->getFooterFormat());
            $invoice->setTermsConditions( $invoicingData->getConditions());
            
            $invoice->setVatExemption( false );
            
            $invoice->setNumber($invoiceNumber);
            $invoice->setDate( new \DateTime() );
            
            $project = null;
            foreach( $itemIds as $itemId ){
                $invoicing = $invoicingRepo->find( $itemId );
                
                if(is_null($project)){
                    $project = $invoicing->getProject();
                }
                
                $item = new InvoiceItem();
                $item->setInvoicing($invoicing);                
                $item->setItemDescription( $invoicing->getEtape() );
                $item->setItemPrice( $invoicing->getAmount() );
                $item->setQuantity( 1 );
                $item->setItemRebate( 1 ); // 100% of price
                $item->setInvoice( $invoice );
                $em->persist( $item );

                // Set the invoicing item as invoiced
                $invoicing->setInvoiced( new \DateTime() );
            }
            
            $invoice->setProject($project); 
            
            $em->persist( $invoice );          
            $em->flush();
            
            $numberingRepo->setNewInvoiceNumber( $invoiceId+1 );
            
            $returnArray = array( "response" => 200,
                    "id" => $invoice->getId(),
                    "url" => $this->generateUrl('_invoice_invoice',array("id" => $invoiceNumber)),
                    "invoiceNumber" => $invoiceNumber,
                    "invoiceDate" => $invoice->getDate()->format("d/m/Y"));
        } else {
            $returnArray = array( "response" => 500 );            
        }
        
        $return = json_encode( $returnArray );
        return new Response( $return, 200);          
    }

    /**
     * @Route( "/gestion/project/ajax/devis/new", name="_new_quote" )
     */
    public function newQuoteAction( Request $request ){    
        $em = $this->get('doctrine')->getManager();
        $invoicingRepo = $em->getRepository('ProjectManagementBundle:Invoicing');
        $numberingRepo = $em->getRepository('ProjectManagementBundle:InvoiceNumbering');
        $repo = $em->getRepository('ProjectManagementBundle:InvoicingData');
        $invoicingData=$repo->find( InvoiceNumberingRepository::INVOICING_QUOTE_DATA );
        
        $itemIds = json_decode( $request->get('itemIds'),true );        

        if( $itemIds ) {
            $invoice = new Invoice();
            $invoiceId = $numberingRepo->getNewInvoiceNumber( InvoiceNumberingRepository::INVOICING_QUOTE_DATA );
            
            if( $invoicingData->getNumberingType() == InvoiceNumberingRepository::INVOICING_MODE_YEARLY ) {
                $today = new \DateTime();
                $year = $today->format('Y');
                $invoiceNumber = sprintf( $invoicingData->getNumberingFormat(), $year, $invoiceId );
            } else {
                $invoiceNumber = sprintf( $invoicingData->getNumberingFormat(), $invoiceId );
            }
            
            $invoice->setState("Q");
            
            $invoice->setFooter( $invoicingData->getFooterFormat());
            $invoice->setTermsConditions( $invoicingData->getConditions());
            
            $invoice->setVatExemption( false );
            
            $invoice->setNumber($invoiceNumber);
            $invoice->setDate( new \DateTime() );
            
            $project = null;
            foreach( $itemIds as $itemId ){
                $invoicing = $invoicingRepo->find( $itemId );
                
                if(is_null($project)){
                    $project = $invoicing->getProject();
                }
                
                $item = new InvoiceItem();
                $item->setInvoicing($invoicing);                
                $item->setItemDescription( $invoicing->getEtape() );
                $item->setItemPrice( $invoicing->getAmount() );
                $item->setQuantity( 1 );
                $item->setItemRebate( 1 ); // 100% of price
                $item->setInvoice( $invoice );
                $em->persist( $item );

                // Set the invoicing item as invoiced
                $invoicing->setInvoiced( new \DateTime() );
            }
            
            $invoice->setProject($project); 
            
            $em->persist( $invoice );          
            $em->flush();
            
            $numberingRepo->setNewInvoiceNumber( $invoiceId+1, InvoiceNumberingRepository::INVOICING_QUOTE_DATA );
            
            $returnArray = array( "response" => 200,
                    "id" => $invoice->getId(),
                    "url" => $this->generateUrl('_invoice_quote',array("id" => $invoiceNumber)),
                    "invoiceNumber" => $invoiceNumber,
                    "invoiceDate" => $invoice->getDate()->format("d/m/Y"));
        } else {
            $returnArray = array( "response" => 500 );            
        }
        
        $return = json_encode( $returnArray );
        return new Response( $return, 200);          
    }
    
    /**
     * @Route( "/gestion/project/ajax/facturation/delete", name="_project_invoice_ajax_delete" )
     */
    public function deleteProjectInvoicingAction( Request $request ){
        $iId = $request->get('id');
        
        if( $iId ) {
            $em = $this->get('doctrine')->getManager();
            $repo = $em->getRepository('ProjectManagementBundle:Invoicing');
            
            $invoice = $repo->find( $iId );
            
            $em->remove( $invoice );
            $em->flush();
            
            $returnArray = array( "response" => 200 );
        } else {
            $returnArray = array( "response" => 500 );            
        }
        
        $return = json_encode( $returnArray );
        return new Response( $return, 200);          
    }
    
    /**
     * @Route( "/gestion/project/ajax/facturation/update", name="_project_invoicing_ajax_update" )
     */
    public function updateProjectInvoicingAction( Request $request ){
        $id = $request->get('id');
        $type = $request->get('type');
        $pid = $request->get('pid');
        $action = $request->get('action');
        $etape = $request->get('etape');
        $montant = $request->get('montant');
        $relance = $request->get('relance');
        $paye = $request->get('paye');
        
        $em = $this->get('doctrine')->getManager();

        if( $action=="U" && $id ) {
            $iRepo = $em->getRepository('ProjectManagementBundle:Invoicing');
            $invoice = $iRepo->find( $id );
        } else if( $action=="C" ) {
            if( $pid ) {
                $pRepo = $em->getRepository('CoreBundle:Project');
                $project = $pRepo->find( $pid );
                
                $invoice = new Invoicing();
                $invoice->setProject( $project );
                $invoice->setType( $type );
                $em->persist( $invoice );
            }
        }
        
        $invoice->setEtape( $etape );
        $invoice->setAmount( $montant );
            
        if( $paye ){
            $dPaye = \DateTime::createFromFormat("d/m/Y", $paye);
            $invoice->setPaid( $dPaye );
        } else {
            $invoice->setPaid( NULL );            
        }
        
        if( $relance ){
            $dRelance = \DateTime::createFromFormat("d/m/Y", $relance);
            $invoice->SetReminder( $dRelance );
        } else {
            $invoice->setReminder(NULL);
        }
        $em->flush();
        
        $returnArray = array( "response" => 200,
                              "id" => $invoice->getId() );
        
        $return = json_encode( $returnArray );
        return new Response( $return, 200);        
    }
}
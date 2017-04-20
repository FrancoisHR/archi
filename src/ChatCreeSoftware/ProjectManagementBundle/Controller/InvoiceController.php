<?php

namespace ChatCreeSoftware\ProjectManagementBundle\Controller;

use ChatCreeSoftware\ProjectManagementBundle\Entity\Address,
    ChatCreeSoftware\ProjectManagementBundle\Entity\InvoiceItem,
    ChatCreeSoftware\ProjectManagementBundle\Entity\Invoicing;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

class InvoiceController  extends Controller{
    
    /**
     * @Route("/gestion/project/ajax/facturation/invoice/{id}", name="_invoice_invoice")
     * @Template
     */
    public function invoiceAction( $id=0 )
    {
        $em = $this->get('doctrine')->getManager();
        $repo = $em->getRepository('ProjectManagementBundle:Invoice');
        $invoice=$repo->findOneByNumber( $id );

        $vatQuery = $em->createQuery( "select c from CoreBundle:ConfigData c where c.name='TVA' and c.date in (select MAX(d.date) from CoreBundle:ConfigData d where d.name='TVA' and d.date <= ?1)" );
        $vatQuery->setParameter(1,$invoice->getDate());
        $vatData =  $vatQuery->getResult();        
        $vat = floatval($vatData[0]->getValue());
        
        $dueDate = clone $invoice->getDate();
        $dueDate->modify("+30 days");
        
        if( is_null( $invoice->getAddress() ) ) {
            $addresses = $invoice->getProject()->getAddresses();
                foreach( $addresses as $address ){
                if( $address->getType() == "Facturation") {
                    $invoice->setAddress( $address );
                    $em->persist( $invoice );
                    $em->flush();
                }
            }
        }
        
        return array( "invoice" => $invoice,
                "vat" => $vat,
                "dueDate" => $dueDate );
    }
    
    /**
     * @Route("/gestion/project/ajax/facturation/quote/{id}", name="_invoice_quote")
     * @Template
     */
    public function quoteAction( $id=0 )
    {
        $em = $this->get('doctrine')->getManager();
        $repo = $em->getRepository('ProjectManagementBundle:Invoice');
        $invoice=$repo->findOneByNumber( $id );

        $vatQuery = $em->createQuery( "select c from CoreBundle:ConfigData c where c.name='TVA' and c.date in (select MAX(d.date) from CoreBundle:ConfigData d where d.name='TVA' and d.date <= ?1)" );
        $vatQuery->setParameter(1,$invoice->getDate());
        $vatData =  $vatQuery->getResult();        
        $vat = floatval($vatData[0]->getValue());
        
        $dueDate = clone $invoice->getDate();
        $dueDate->modify("+30 days");
        
        if( is_null( $invoice->getAddress() ) ) {
            $addresses = $invoice->getProject()->getAddresses();
                foreach( $addresses as $address ){
                if( $address->getType() == "Facturation") {
                    $invoice->setAddress( $address );
                    $em->persist( $invoice );
                    $em->flush();
                }
            }
        }
        
        return array( "invoice" => $invoice,
                "vat" => $vat,
                "dueDate" => $dueDate );
    }
    
    
    /**
     * @Route( "/gestion/project/ajax/facturation/updateDescription", name="_project_invoice_ajax_update_desc")
     */
    public function updateDescriptionAction( Request $request ){
        $id = $request->get('id');
        $desc = $request->get('description');

        if( $id ) {
            $em = $this->get('doctrine')->getManager();
            $repo = $em->getRepository('ProjectManagementBundle:InvoiceItem');
            $invoiceItem=$repo->findOneById( $id );
            
            $invoiceItem->setItemDescription( $desc);
            $em->flush();
            
            $returnArray = array( "response" => 200 );
        } else {
            $returnArray = array( "response" => 500 );            
        }
        
        $return = json_encode( $returnArray );
        return new Response( $return, 200);          
        
    }

}
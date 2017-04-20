<?php

namespace ChatCreeSoftware\ProjectManagementBundle\Controller;

use ChatCreeSoftware\CoreBundle\Entity\Flags,
    ChatCreeSoftware\ProjectManagementBundle\Repository\InvoiceNumberingRepository,
    ChatCreeSoftware\ProjectManagementBundle\Entity\InvoicingData;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

class ConfigurationController extends Controller
{
    
    /**
     * @Route("/gestion/configuration/invoicing", name="_configuration_invoicing")
     * @Template
     */
    public function configurationInvoicingAction( Request $request)
    {
        $em = $this->get('doctrine')->getManager();    
        $numberingRepo = $em->getRepository("ProjectManagementBundle:InvoiceNumbering");
        $repo = $em->getRepository('ProjectManagementBundle:InvoicingData');
        $invoicingData=$repo->find( 1 );
        
        if( is_null($invoicingData) ){
            $invoicingData = new InvoicingData();
            $invoicingData->setNumberingType(InvoiceNumberingRepository::INVOICING_MODE_CONTINUOUS);
            $invoicingData->setNumberingFormat( "%06d" );
            $invoicingData->setFooterFormat( "%%id%% - TVA : %%vatNumber%% - CB : %%IBAN%% %%BIC%%");
            $invoicingData->setInvoiceLogo( "default-logo.png");
            $invoicingData->setConditions("Blablablah");
            $invoicingData->setSpecialConditions("Bloubliblou");
            $invoicingData->setReminderText("Rappel");
        }
        
        
        $data = array( 'numberingType' => $invoicingData->getNumberingType(),
                'numberingFormat' => $invoicingData->getNumberingFormat(),
                'invoiceNumber' => $numberingRepo->getNewInvoiceNumber(),
                'footerFormat' => $invoicingData->getFooterFormat(),
                'invoiceLogo' => $invoicingData->getInvoiceLogo(),
                'conditions' => $invoicingData->getConditions(),
                'specialConditions' => $invoicingData->getSpecialConditions(),
                'reminderText' => $invoicingData->getReminderText() 
            );
        
        $form = $this->get('form.factory')
            ->createBuilder('Symfony\Component\Form\Extension\Core\Type\FormType', $data )
            ->add('numberingType','Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'choices'   => array(
                        InvoiceNumberingRepository::INVOICING_MODE_CONTINUOUS => "Continue",
                        InvoiceNumberingRepository::INVOICING_MODE_YEARLY => "Annuelle"
                ),))
            ->add('numberingFormat','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('invoiceNumber','Symfony\Component\Form\Extension\Core\Type\IntegerType')
            ->add('footerFormat','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('invoiceLogo', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('conditions','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('specialConditions','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('reminderText','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->getForm(); 

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $invoicingData->setNumberingType($form->get('numberingType')->getData());
                $invoicingData->setNumberingFormat( $form->get('numberingFormat')->getData() );
                $invoicingData->setFooterFormat( $form->get('footerFormat')->getData());
                $invoicingData->setInvoiceLogo( $form->get('invoiceLogo')->getData());
                $invoicingData->setConditions($form->get('conditions')->getData());
                $invoicingData->setSpecialConditions($form->get('specialConditions')->getData());
                $invoicingData->setReminderText($form->get('reminderText')->getData());                
                
                $em->persist( $invoicingData );
                $em->flush();
                
                $numberingRepo->setNewInvoiceNumber( $form->get('invoiceNumber')->getData());
                
            }
        }
                
        return array( 'form' => $form->createView() );        
    }

    /**
     * @Route("gestion/configuration/addressType", name="_configuration_addressType")
     * @Template
     */
    public function configurationAddressTypeAction()
    {
        return array();
    }

    /**
     * @Route("gestion/configuration/listAddressType", name="_configuration_list_addressType")
     */
    public function ajaxListAddressTypeAction(){
        $em = $this->get('doctrine')->getManager();    
        
        $query = $em->createQuery( "select f from CoreBundle:Flags f where f.flagType='AT'");
        $results = $query->getResult();
        
        $ajaxResult = array(
            'data' => array()
        );
        
        foreach( $results as $result ){
            $row = array( $result->getId(), $result->getFlagLabel() );
            
            $ajaxResult['data'][] = $row;
        }
        
        $return = json_encode( $ajaxResult );
        
        return new Response( $return, 200);
    }

    /**
     * @Route("gestion/configuration/addAddressType", name="_configuration_add_addressType")
     */
    public function ajaxAddAddressTypeAction( Request $request){
        $addressType = $hRequest->get('addressType');

        $em = $this->get('doctrine')->getManager();    
        
        $type = new Flags();
        $type->setFlagType( "AT" );
        $type->setFlagLabel( $addressType );
        
        $em->persist( $type );
        $em->flush();
        
        $returnArray = array(
            "response" => 200);

        $return = json_encode($returnArray);
        return new Response($return, 200);
    }

    /**
     * @Route("gestion/configuration/modifyAddressType", name="_configuration_modify_addressType")
     */
    public function ajaxModifyAddressTypeAction( Request $request){
        $addressTypeId = $hRequest->get('addressTypeId');
        $addressType = $hRequest->get('addressType');

        $em = $this->get('doctrine')->getManager();   
        $repo = $em->getRepository('CoreBundle:Flags');
        $type = $repo->find( $addressTypeId );
        
        $type->setFlagLabel( $addressType );
        
        $em->persist( $type );
        $em->flush();
        
        $returnArray = array(
            "response" => 200);

        $return = json_encode($returnArray);
        return new Response($return, 200);
    }

    
}

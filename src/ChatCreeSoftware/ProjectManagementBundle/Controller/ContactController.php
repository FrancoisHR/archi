<?php

namespace ChatCreeSoftware\ProjectManagementBundle\Controller;

use ChatCreeSoftware\CoreBundle\Entity\Project,
    ChatCreeSoftware\ProjectManagementBundle\Entity\Address;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller {

    /**
     * @Route( "/gestion/project/contacts/{id}", name="_gestion_project_contacts" )
     * @Template
     */
    public function projectContactAction( Request $request, Project $project ) {
        $em = $this->get('doctrine')->getManager();    
        
        $addresses = $project->getAddresses();
        if(! is_null($addresses) && count($addresses)>0){
            $address = $addresses[0];
        } else {
            $address = new Address();
        }        
        
        $form = $this->get('form.factory')
            ->createBuilder('Symfony\Component\Form\Extension\Core\Type\FormType', $address)
            ->add('addressType','Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                  'class' => 'CoreBundle:Flags',
                  'placeholder' => '-',
                  'query_builder' => function( EntityRepository $er ) {
                    return $er->createQueryBuilder('f')->where('f.flagType=\'AT\'')->orderBy('f.flagLabel','ASC');
                  },
                  'choice_label' => 'flagLabel' ))
            ->add('company','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('firstname','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('lastname','Symfony\Component\Form\Extension\Core\Type\TextType')                
            ->add('street1','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('street2','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('street3','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('zipCode','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('city','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('country','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->getForm();

        
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $address->setProject($project);
                $em->persist( $address );
                $em->flush();

            }
        }
        
        return array(
            'form' => $form->createView(),
            'project' => $project,
        );
    }

        /**
     *  @Route( "/gestion/project/contacts/contactList/{id}", name="_gestion_project_contactList" )
     */
    public function projectContactListAction( Project $project ){
        $em = $this->get('doctrine')->getManager();    
        
        $contactArray = array();
        foreach ($project->getAddresses() as $contact ) {
            $type ="";
            if( $contact->getAddressType() )
                $type= $contact->getAddressType()->getFlagLabel();
            
            $contactObject = array(
                "id" => $contact->getId(),
                $type,
                $contact->getCompany(),
                $contact->getVatNumber(),
                $contact->getTitle(),
                $contact->getFirstname(),
                $contact->getLastname(),
                $contact->getStreet1(),
                $contact->getStreet2(),
                $contact->getStreet3(),
                $contact->getZipCode(),
                $contact->getCity(),
                $contact->getCountry() );

            $contactArray[] = $contactObject;
        }
        
        $return =array( "data" => $contactArray );
        $return = json_encode( $return );
        return new Response( $return, 200);            
    }

    
    /**
     * @Route("/gestion/contacts/add_contact", name="_project_contact_ajax_add")
     */
    public function projectAddContactAction( Request $request ) {
        $pId = $request->get('project');
        $typeId = $request->get('type');
        $company = $request->get('company');
        $vatNumber = $request->get('vatNumber');
       
        $title = $request->get('title');
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $street1 = $request->get('street1');
        $street2 = $request->get('street2');
        $street3 = $request->get('street3');
        $zipCode = $request->get('zipCode');
        $city = $request->get('city');
        $country = $request->get('country');

        $em = $this->get('doctrine')->getManager();
        $pRepo = $em->getRepository('CoreBundle:Project'); 
        $fRepo = $em->getRepository('CoreBundle:Flags');
        
        
        $address = new Address();
        if( $typeId ) {
            $type = $fRepo->find( $typeId );        
            $address->setAddressType($type);
        }
        $address->setCompany($company);
        $address->setVatNumber($vatNumber);
        $address->setTitle($title);
        $address->setFirstname($firstname);
        $address->setLastname($lastname);
        $address->setStreet1($street1);
        $address->setStreet2($street2);
        $address->setStreet3($street3);
        $address->setZipCode($zipCode);
        $address->setCity($city);
        $address->setCountry($country);
        

        $project = $pRepo->find( $pId );
        
        $address->setProject($project);
        $em->persist( $address );
        $em->flush();
        
        $returnArray = array(
            "project" => $pId,
            "response" => 200);

        $return = json_encode($returnArray);
        return new Response($return, 200);
    }

    /**
     * @Route("/gestion/contacts/delete_contact", name="_project_contact_ajax_delete")
     */
    public function projectDeleteContactAction( Request $request ) {
        $addressId = $request->get('id');
        
        // Get the contact
        $em = $this->get('doctrine')->getManager();    
        $repo = $em->getRepository('ProjectManagementBundle:Address');
        $log=$repo->find( $addressId );        
        
        $em->remove( $log );
        $em->flush();
        
        $return = array("response"=>200);
        $return = json_encode( $return );
        return new Response( $return, 200);
    }    
    
    
    /**
     * @Route("/gestion/contacts/modify_contact", name="_project_contact_ajax_modify")
     */
    public function projectModifyContactAction( Request $request ) {
        $addressId = $request->get('addressId');
        $typeId = $request->get('type');
        $company = $request->get('company');
        $vatNumber = $request->get('vatNumber');
       
        $title = $request->get('title');
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $street1 = $request->get('street1');
        $street2 = $request->get('street2');
        $street3 = $request->get('street3');
        $zipCode = $request->get('zipCode');
        $city = $request->get('city');
        $country = $request->get('country');

        $em = $this->get('doctrine')->getManager();
        $aRepo = $em->getRepository('ProjectManagementBundle:Address');
        $fRepo = $em->getRepository('CoreBundle:Flags'); 
        
        $address = $aRepo->find( $addressId );
                
        if( $typeId ) {
            $type = $fRepo->find( $typeId );        
            $address->setAddressType($type);
        }
        $address->setCompany($company);
        $address->setVatNumber($vatNumber);
        $address->setTitle($title);
        $address->setFirstname($firstname);
        $address->setLastname($lastname);
        $address->setStreet1($street1);
        $address->setStreet2($street2);
        $address->setStreet3($street3);
        $address->setZipCode($zipCode);
        $address->setCity($city);
        $address->setCountry($country);
        
        $em->persist( $address );
        $em->flush();
        
        $returnArray = array(
            "response" => 200);

        $return = json_encode($returnArray);
        return new Response($return, 200);
    }
    
    /**
     * @Route( "/gestion/contacts/get_contact", name="_project_contact_ajax_get")
     */
    public function projectGetAddressAction( Request $request ) {
        $addressId = $request->get('addressId');

        $em = $this->get('doctrine')->getManager();
        $aRepo = $em->getRepository('ProjectManagementBundle:Address');

        $address = $aRepo->find( $addressId );
        
        $addressTypeId = "";
        if( $address->getAddressType() ) {
            $addressTypeId = $address->getAddressType()->getId();
        }
        
        $contact = array(
            "addressType" => $addressTypeId,
            "company" => $address->getCompany(),
            "vatNumber" => $address->getVatNumber(),
            "title" => $address->getTitle(),
            "firstname" => $address->getFirstname(),
            "lastname" => $address->getLastname(),
            "street1" => $address->getStreet1(),
            "street2" => $address->getStreet2(),
            "street3" => $address->getStreet3(),
            "zipCode" => $address->getZipCode(),
            "city" => $address->getCity(),
            "country" => $address->getCountry() );
        
        $returnArray = array(
            "address" => $contact,
            "response" => 200);

        $return = json_encode($returnArray);
        return new Response($return, 200);        
    }
    
    
    /**
     * @Route( "/gestion/project/invoice/update_address", name="_project_invoice_ajax_update_address")
     */
    public function projectUpdateInvoiceAddressAction( Request $request ) {
        $invoiceId = $request->get('invoiceId');
        $addressId = $request->get('addressId');

        $em = $this->get('doctrine')->getManager();
        $iRepo = $em->getRepository('ProjectManagementBundle:Invoice');
        $aRepo = $em->getRepository('ProjectManagementBundle:Address');

        $invoice = $iRepo->find( $invoiceId );
        $address = $aRepo->find( $addressId );
        
        $invoice->setAddress( $address );
        $em->persist( $invoice );
        $em->flush();
        
        $contact = array(
            "addressType" => $address->getAddressType()->getFlagLabel(),
            "company" => $address->getCompany(),
            "vatNumber" => $address->getVatNumber(),
            "title" => $address->getTitle(),
            "firstname" => $address->getFirstname(),
            "lastname" => $address->getLastname(),
            "street1" => $address->getStreet1(),
            "street2" => $address->getStreet2(),
            "street3" => $address->getStreet3(),
            "zipCode" => $address->getZipCode(),
            "city" => $address->getCity(),
            "country" => $address->getCountry() );
        
        $returnArray = array(
            "address" => $contact,
            "response" => 200);

        $return = json_encode($returnArray);
        return new Response($return, 200);        
    }
}

<?php
namespace ChatCreeSoftware\ProjectManagementBundle\Repository;

use ChatCreeSoftware\ProjectManagementBundle\Entity\InvoiceNumbering;
use Doctrine\ORM\EntityRepository;

class InvoiceNumberingRepository  extends EntityRepository
{
    const INVOICING_MODE_CONTINUOUS = 0;
    const INVOICING_MODE_YEARLY = 1;
    
    const INVOICING_INVOICE_DATA = 1;
    const INVOICING_QUOTE_DATA = 2;
    
    function getNewInvoiceNumber( $type=1 )
    {
        $em = $this->getEntityManager();
        $repo = $em->getRepository('ProjectManagementBundle:InvoicingData');
        $invoicingData=$repo->find( $type );
        
        $invRepo = $em->getRepository('ProjectManagementBundle:InvoiceNumbering');
        $year='CONT';
        if( is_null($invoicingData) || $invoicingData->getNumberingType() == InvoiceNumberingRepository::INVOICING_MODE_YEARLY ) {
            $today = new \DateTime();
            $year = $today->format('Y');
        }
        
        $query = $invRepo->createQueryBuilder('i')
                ->where('i.year = :year and i.type = :type')
                ->setParameter('year',$year)
                ->setParameter('type',$type)
                ->setMaxResults(1)->getQuery();
        
        $invoiceNumbering = $query->getOneOrNullResult();     
        if( is_null($invoiceNumbering) || is_null($invoiceNumbering->getNumber()) ){
            return 1;
        } else {
            return $invoiceNumbering->getNumber();
        }
    }
    
    function setNewInvoiceNumber( $number, $type=1 )
    {
        $em = $this->getEntityManager();
        $repo = $em->getRepository('ProjectManagementBundle:InvoicingData');
        $invoicingData=$repo->find( $type );

        $invRepo = $em->getRepository('ProjectManagementBundle:InvoiceNumbering');
        $year='CONT';
        if( $invoicingData->getNumberingType() == InvoiceNumberingRepository::INVOICING_MODE_YEARLY ) {
            $today = new \DateTime();
            $year = $today->format('Y');
        }
        
        $query = $invRepo->createQueryBuilder('i')
                ->where('i.year = :year and i.type = :type')
                ->setParameter('year',$year)
                ->setParameter('type',$type)
                ->setMaxResults(1)->getQuery();
        
        $invoiceNumbering = $query->getOneOrNullResult();        
        if( is_null($invoiceNumbering) ){
            $invoiceNumbering = new InvoiceNumbering();
            $invoiceNumbering->setYear($year);
            $invoiceNumbering->setType($type);
            $em->persist( $invoiceNumbering );
        }
        
        $invoiceNumbering->setNumber($number);
        
        $em->flush();
    }
}
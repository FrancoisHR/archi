<?php

namespace ChatCreeSoftware\BordereauxBundle\Services;

use ChatCreeSoftware\BordereauxBundle\Entity\Bordereau;
use ChatCreeSoftware\BordereauxBundle\Pdf\BordereauPdf;  

use Doctrine\ORM\EntityManager;

class PdfGenerator {
    
    protected $entityManager;
    
    public function __construct( EntityManager $entityManager ){
        $this->entityManager = $entityManager;
    }

    public function renderBordereau( Bordereau $bordereau ){

        $pdf = new BordereauPdf('P','mm','A4');
        $pdf->AliasNbPages();
        $pdf->AddFont('HelveticaNeue','','HelveticaNeue.php');
        $pdf->AddFont('HelveticaNeueBd','','HelveticaNeue-Bold.php');
        $pdf->SetAutoPageBreak( true, 20 );

        $pdf->SetFont('HelveticaNeue','',10);
        $pdf->setWidths( "NORMAL", array(15,100,17,18,20,20));
        $pdf->setAligns( "NORMAL", array("L","J","C","C","",""));
        $pdf->setHeadings( "NORMAL", array("Position","Description","Unité","Quantité","Prix/U", "Total"));
        
        $pdf->setWidths( "RESUME", array(15,155,20));
        $pdf->setAligns( "RESUME", array("Position","Description","Total"));
        $pdf->setAligns( "RESUME",  array("L","J","R"));
        $pdf->setHeadings( "RESUME", array("Position","Description","Total"));

        
        $pdf->setLogo( 'bundles/ChatCreeSoftware/ProjectManagement/images/logo_print.jpg' );
        $pdf->setDescription( $bordereau->getDescription() );
        $pdf->setProjet( $bordereau->getProject()->getProjectName() );
        $pdf->setlot($bordereau->getReferenceLot());
        $pdf->setTitre( $bordereau->getTitre() );
        
        $pdf->setAdresseChantier( array(
            "adresse1" => $bordereau->getProject()->getAddressStreet1(),
            "adresse2" => $bordereau->getProject()->getAddressStreet2(),
            "ville" => $bordereau->getProject()->getAddressCity(),
            "cp" => $bordereau->getProject()->getAddressCP(),
            "cadastre" => $bordereau->getProject()->getCadastre(),
            "section" => $bordereau->getProject()->getSection(),
            "commune" => $bordereau->getProject()->getCommune(),
        ));
        
        $addressRepo = $this->entityManager->getRepository( 'ProjectManagementBundle:Address' );
        $query = $addressRepo->createQueryBuilder( 'a' )
                ->join( 'a.project', 'p')
                ->join( 'a.addressType', 't')
                ->where( "p.id = :pid and t.flagType = :flag and t.flagLabel = :value")
                ->setParameter('pid', $bordereau->getProject()->getId() )
                ->setParameter('flag','AT')
                ->setParameter('value','Domicile')
                ->getQuery();
        $result = $query->getResult();
        
        if( ! $result ) {
            $query->setParameter('value','Facturation');
            $result = $query->getResult();
        }
        
        if( $result ){
            $adresse= $result[0];
            $titre="";
            if( $adresse->getTitle() ){
                $titre = $adresse->getTitle() . " ";
            }
            $pdf->setAdresseClient( array(
                "nom" => $titre . $adresse->getFirstname() . " " . $adresse->getLastname(),
                "adresse1" => $adresse->getStreet1(),
                "adresse2" => $adresse->getStreet2(),
                "ville" => $adresse->getCity(),
                "cp" => $adresse->getZipCode(),            
            ));
            
        }
        
        if( $bordereau->getDate() ) {
            $pdf->setDate( $bordereau->getDate()->format("d/m/Y") );
        }
        
        $pdf->pageGarde();
        
        $pdf->setType("NORMAL");
        $pdf->AddPage();
        foreach( $bordereau->getLignes() as $ligne) {
            $pdf->printLigne( $bordereau, $ligne );            
        }
        
        $pdf->pageResume();
        foreach( $bordereau->getLignes() as $ligne) {
            $pdf->printLigne( $bordereau,$ligne );            
        }
        $pdf->totalResume();
        
        
        // Add files at the end...
        $files = array();
        foreach( $bordereau->getFichiers() as $fichier ){
            $files[] = "library/" . $fichier->getLibrairie()->getPrefixe() . "/" . $fichier->getFichier();
        }
        
        if( $files ){
            $pdf->setFiles( $files );
            $pdf->concat();
        }

        return( $pdf );
    }
}
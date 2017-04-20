<?php
namespace ChatCreeSoftware\BordereauxBundle\Controller;

use ChatCreeSoftware\CoreBundle\Entity\Project;
use ChatCreeSoftware\FileserverBundle\Forms\FileUploadCollection;
use ChatCreeSoftware\BordereauxBundle\Entity\Bordereau,
    ChatCreeSoftware\BordereauxBundle\Entity\Ligne,    
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\UploadedFile,
    Symfony\Component\Security\Core\User\UserInterface;
use ChatCreeSoftware\BordereauxBundle\Pdf\BordereauPdf,
    ChatCreeSoftware\BordereauxBundle\Pdf\ComparatifPdf;      

class PdfController extends Controller {
    
    /**
     * 
     * @Route("/bordereaux/pdf/{id}", name="_ajax_bordereau_pdf", defaults={ "id"=0 })
     */
    public function indexAction( Request $request, UserInterface $user, Bordereau $bordereau )
    {
        $em = $this->get('doctrine')->getManager();
        
        $pdf = $this->get("bordereaux.services.pdfGenerator")->renderBordereau( $bordereau );
        
        if( $request->isMethod("POST")) {
            $filename = $request->get('filename');
            $path = $request->get("path");
            
            $projectPath = $bordereau->getProject()->getProjectPath();
            
            if( $path =="/" ){
                $filepath = "$projectPath/$filename";
                $folderpath="";
            } else {
                $filepath = "$projectPath/$path/$filename";
                $folderpath = '/' . $path;
            }
            
            $pdf->Output( "F", $filepath );
            
            $files = new FileUploadCollection();
            $files->setFiles( [ new \Symfony\Component\HttpFoundation\File\UploadedFile( $filepath, $filename ) ] );
            
            $this->get("ChatCreeSoftware.Core.fileNotification")->mailFileNotifications( $user, $bordereau->getProject(), $folderpath, $files, [] );
            
            $returnArray = array("response" => 200);
            $return = json_encode($returnArray);
            return new Response($return, 200);
            
        }
        
        return new Response( $pdf->Output(), 200, array(
            "Content-Type" => "application/pdf"));
        
    }

    /**
     * 
     * @Route("/bordereaux/pdf/comparatif/{id}/{devisId}", name="_ajax_bordereaux_comparatif_pdf", defaults={ "id"=0, "devisId"="" })
     */
    public function comparatifAction( Request $request, UserInterface $user, Bordereau $bordereau, $devisId )
    {
        $em = $this->get('doctrine')->getManager();
        
        $pdf = new ComparatifPdf('L','mm','A3');
        $pdf->AliasNbPages();
        $pdf->AddFont('HelveticaNeue','','HelveticaNeue.php');
        $pdf->AddFont('HelveticaNeueBd','','HelveticaNeue-Bold.php');
        $pdf->SetAutoPageBreak( true, 20 );

        $devisArray = [];
        if( $devisId ){
            $devisArray= explode("-",$devisId );
        } else {
            foreach( $bordereau->getDevis() as $devis ) {
                $devisArray[] = $devis->getId();
            }
        }
        $nb = count( $devisArray );
        $pdf->setDevis( $devisArray );
        
        $pdf->SetFont('HelveticaNeue','',10);
        $widths = array(15,140,17,18);
        $aligns = array("L","J","C","C");
        $headings = array("Position","Description","Unité","Quantité");
        for($n=0; $n<$nb; $n++){
            $widths[] = 20;
            $aligns[] = "R";
            $headings[] = "Prix/U";
            $widths[] = 20;
            $aligns[] = "R";
            $headings[] = "Total";
        }
        $pdf->setWidths( "NORMAL", $widths );
        $pdf->setAligns( "NORMAL", $aligns );
        $pdf->setHeadings( "NORMAL", $headings );
        
        $widths = array(15,175);
        $aligns = array("L","J");
        $headings = array("Position","Description");
        for($n=0; $n<$nb; $n++){
            $widths[] = 40;
            $aligns[] = "R";
            $headings[] = "Total";
        }
        $pdf->setWidths( "RESUME", $widths );
        $pdf->setAligns( "RESUME",  $aligns );
        $pdf->setHeadings( "RESUME", $headings );

        $companies = [];
        foreach( $bordereau->getDevis() as $devis ){
            if( in_array($devis->getId(), $devisArray) ){
                $companies[] = $devis->getSoumissionnaire()->getCompany();
            }
        }
        $pdf->setCompanies($companies);
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
        
        $addressRepo = $em->getRepository( 'ProjectManagementBundle:Address' );
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
        $pdf->totalResume( $bordereau );
        
        
        // Add files at the end...
        $files = array();
        foreach( $bordereau->getFichiers() as $fichier ){
            $files[] = "library/" . $fichier->getLibrairie()->getPrefixe() . "/" . $fichier->getFichier();
        }
        
        if( $files ){
            $pdf->setFiles( $files );
            $pdf->concat();
        }
        
        if( $request->isMethod("POST")) {
            $filename = $request->get('filename');
            $path = $request->get("path");
            
            $projectPath = $bordereau->getProject()->getProjectPath();
            
            if( $path =="/" ){
                $filepath = "$projectPath/$filename";
                $folderpath="";
            } else {
                $filepath = "$projectPath/$path/$filename";
                $folderpath = '/' . $path;
            }
            
            $pdf->Output( "F", $filepath );
            
            $files = new FileUploadCollection();
            $files->setFiles( [ new \Symfony\Component\HttpFoundation\File\UploadedFile( $filepath, $filename ) ] );
            
            $this->get("ChatCreeSoftware.Core.fileNotification")->mailFileNotifications( $user, $bordereau->getProject(), $folderpath, $files, [] );
            
            $returnArray = array("response" => 200);
            $return = json_encode($returnArray);
            return new Response($return, 200);
            
        }
        
        return new Response($pdf->Output(), 200, array(
            "Content-Type" => "application/pdf"));
        
    }    
    
}
<?php

namespace ChatCreeSoftware\BordereauxBundle\Controller;

use ChatCreeSoftware\CoreBundle\Entity\LogBook,
    ChatCreeSoftware\FileserverBundle\Entity\FileLink;
use ChatCreeSoftware\BordereauxBundle\Entity\Devis,
    ChatCreeSoftware\BordereauxBundle\Entity\LigneDevis,
    ChatCreeSoftware\BordereauxBundle\Entity\Bordereau,
    ChatCreeSoftware\BordereauxBundle\Entity\Ligne,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\Security\Core\User\UserInterface;

class QuotesController extends Controller {

    /**
     * @Route("/bordereaux/edit/devis/{id}", name="_bordereaux_edit_devis", defaults={ "id"=0 })
     * @Template
     */
    public function devisAction(Devis $devis) {

        $project = $devis->getBordereau()->getProject();

        return array("project" => $project,
            "devis" => $devis);
    }

    /**
     * 
     * @Route( "/bordereaux/ajax/bordereau/quotes/{id}", name="_ajax_list_bordereau_quotes", defaults={ "id"=0 })
     */
    public function projectBordereauAction(Bordereau $bordereau) {

        $arrayDevis = [];
        foreach ($bordereau->getDevis() as $devis) {
            $ouverture = "";
            $envoi = "";
            $depot = "";
            $cloture = "";

            if ($devis->getOuverture()) {
                $ouverture = $devis->getOuverture()->format("d/m/Y");
            }
            if ($devis->getEnvoi()) {
                $envoi = $devis->getEnvoi()->format("d/m/Y");
            }
            if ($devis->getDepot()) {
                $depot = $devis->getDepot()->format("d/m/Y");
            }
            if ($devis->getCloture()) {
                $cloture = $devis->getCloture()->format("d/m/Y");
            }
            if ($devis->getCommentaire()) {
                $commentaire = $devis->getCommentaire();
            } else {
                $commentaire = "";
            }
            
            $mails = [];
            foreach( $devis->getSoumissionnaire()->getEmails() as $email ){
                $mails[] = $email->getMail();
            }
            $mail = join("<br>", $mails );
            
            $devisObject = [
                "id" => $devis->getId(),
                "userId" => $devis->getSoumissionnaire()->getId(),
                "user" => $devis->getSoumissionnaire()->getLastname(),
                "version" => $devis->getVersion(),
                "ouverture" => $ouverture,
                "envoi" => $envoi,
                "depot" => $depot,
                "cloture" => $cloture,
                "commentaire" => $commentaire,
                "etat" => $devis->getEtat()->getFlagLabel(),
                "mail" => $mail
            ];
            $arrayDevis[] = $devisObject;
        }

        $ajaxResult["data"] = $arrayDevis;
        $return = json_encode($ajaxResult);
        return new Response($return, 200);
    }

    /**
     * @Route( "/bordereaux/ajax/bordereau/quote/save/{id}", name="_ajax_lignes_devis_save", defaults={ "id"=0 })
     */
    public function bordereauQuoteSaveAction(Request $request, UserInterface $user, Devis $devis) {
        $ip = $request->getClientIp();
        $em = $this->get('doctrine')->getManager();
        $ligneRepo = $em->getRepository("BordereauxBundle:LigneDevis");

        $action = $request->get("action");
        $flagRepo = $em->getRepository("CoreBundle:Flags");
        $flag = $flagRepo->findOneByFlagExtra($action);

        if ($devis->getSoumissionnaire() == $user) {
            if ($flag) {
                $devis->setEtat($flag);
                if ($flag->getFlagExtra() == "QUOTE_SUBMIT") {
                    $devis->setDepot(new \DateTime('NOW'));
                }
            }
        }
        $params = $request->request->all();
        foreach ($params as $key => $value) {
            $keySplit = explode("_", $key);
            if (count($keySplit) == 2) {
                $ligne = $ligneRepo->findOneById($keySplit[1]);
                switch ($keySplit[0]) {
                    case "prixUnitaire":
                        $ligne->setPrixUnitaire($value);
                        break;
                    case "commentaire":
                        $ligne->setCommentaire($value);
                        break;
                }
            }
        }

        $bordereau = $devis->getBordereau();

        $log = new LogBook($bordereau->getProject(), $flag, $user, true);
        $log->setIp($ip);
        if ($devis->getSoumissionnaire() == $user) {
            $texte = "Devis pour bordereau '" . $bordereau->getTitre() . "' Lot : " . $bordereau->getReferenceLot() . " Indice : " . $bordereau->getIndice();
        } else {
            $texte = "Edition du devis pour bordereau '" . $bordereau->getTitre() . "' Lot : " . $bordereau->getReferenceLot() . " Indice : " . $bordereau->getIndice();
        }
        $log->setTexte($texte);

        $em->persist($log);
        $em->flush();

        $ajaxResult["data"] = ["statut" => $flag->getFlagLabel(), "response" => 200];
        $return = json_encode($ajaxResult);
        return new Response($return, 200);
    }

    /**
     * @Route( "/bordereaux/ajax/devis/update/{id}", name="_ajax_devis_update", defaults={ "id"=0 } )
     */
    public function ajaxDevisUpdateAction(Request $request, Devis $devis = null) {
        $em = $this->get('doctrine')->getManager();

        $bordereauId = $request->get('bid');
        $providerId = $request->get('providerId');
        $version = $request->get('version');
        $statusId = $request->get('statusId');
        $envoi = $request->get('envoi');
        $depot = $request->get('depot');
        $cloture = $request->get('cloture');
        $commentaire = $request->get('commentaire');

        if ($devis === null) {
            $devis = new Devis();
            $devis->setOuverture(new \DateTime('NOW'));

            $em->persist($devis);

            $projectRepo = $em->getRepository('BordereauxBundle:Bordereau');
            $bordereau = $projectRepo->findOneById($bordereauId);
            if ($bordereau) {
                $devis->setBordereau($bordereau);
            }
        }
        if ($providerId) {
            $userRepo = $em->getRepository("CoreBundle:User");
            $provider = $userRepo->findOneById($providerId);
            $devis->setSoumissionnaire($provider);
        }
        if ($statusId) {
            $flagRepository = $em->getRepository("CoreBundle:Flags");
            $status = $flagRepository->findOneById($statusId);
            $devis->setEtat($status);
        }
        if ($envoi) {
            $date = \DateTime::createFromFormat("d/m/Y", $envoi);
            $devis->setEnvoi($date);
        } else {
            $devis->setEnvoi(NULL);
        }
        if ($cloture) {
            $date = \DateTime::createFromFormat('d/m/Y', $cloture);
            $devis->setCloture($date);
        } else {
            $devis->setCloture(NULL);
        }
        if ($depot) {
            $date = \DateTime::createFromFormat('d/m/Y', $depot);
            $devis->setDepot($date);
        } else {
            $devis->setDepot(NULL);
        }

        $devis->setVersion($version);
        $devis->setCommentaire($commentaire);
        $em->flush();

        $returnArray = array("response" => 200, "id" => $devis->getId());
        $return = json_encode($returnArray);
        return new Response($return, 200);
    }

    /**
     * @Route( "/bordereaux/ajax/devis/notify/{id}", name="_ajax_devis_notify", defaults={ "id"=0 } )
     */
    public function ajaxDevisNotifyAction( Request $request, UserInterface $user, Devis $devis ){
        $em = $this->get('doctrine')->getManager();

        $flagRepo = $em->getRepository('CoreBundle:Flags');
        $flag = $flagRepo->findOneBy(array('flagExtra' => "QUOTE_REQUEST"));        
        
        $bordereau = $devis->getBordereau();
        $project = $bordereau->getProject();
        $destinataire = $devis->getSoumissionnaire();
        
        $commentaire = $request->get("commentaire");

        $files = [];
        $fileNumber=0;
        while( $request->get("file_$fileNumber") ){
            $fileLink = new FileLink( $destinataire, $project, $request->get("file_" . $fileNumber++) );
            $em->persist($fileLink);
            $files[] = $fileLink;
        }
        
        $texte = "Demande d'offre de prix " . $project->getProjectName() . " - " . $bordereau->getTitre() . " - Lot " . $bordereau->getReferenceLot();
        
        $pdf = $this->get("bordereaux.services.pdfGenerator")->renderBordereau( $bordereau );
        $filename = str_replace(' ', '_', $project->getProjectName() . "_" . $bordereau->getTitre() . "_lot_" . $bordereau->getReferenceLot() . ".pdf" );
        $attachment = \Swift_Attachment::newInstance( $pdf->Output("S") , $filename, 'application/pdf');

        $devis->setEnvoi( new \DateTime('NOW') );
        if( ! $devis->getCloture() ){
            $cloture = new \DateTime('NOW');
            $cloture->modify('+2 week');
            $toFriday = 5 - $cloture->format('N');
            if( $toFriday ){
                $cloture->modify( sprintf( '%+d day', $toFriday) );
            }
            $devis->setCloture($cloture);
        }
        
        foreach ( $destinataire->getEmails() as $mail) {
            $message = \Swift_Message::newInstance()
                        ->setSubject( $texte )
                        ->setFrom('info@rl-architecture.lu')
                        ->setTo($mail->getMail())
                        ->setContentType('text/html')
                        ->setBody($this->renderView('BordereauxBundle:Mails:demandeOffre.html.twig', array(
                            'devis' => $devis,
                            'files' => $files,
                            'commentaire' => $commentaire )))
                        ->attach( $attachment );

            $this->get('mailer')->send($message);
            $logEntry = new LogBook($project, $flag, $user, true);
            $logEntry->setTexte($texte . " envoyée à " . $destinataire->getFirstname() . " " . $destinataire->getLastname() . " sur l'adresse " . $mail->getMail());
            $em->persist( $logEntry );
        }
        
        $em->flush();
        
        $ajaxResult["data"] = ["response" => 200];
        $return = json_encode($ajaxResult);
        return new Response($return, 200);
    }
}

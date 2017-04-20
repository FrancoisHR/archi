<?php

namespace ChatCreeSoftware\CoreBundle\Services;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use ChatCreeSoftware\CoreBundle\Entity\LogBook,
    ChatCreeSoftware\CoreBundle\Entity\Project,
    ChatCreeSoftware\CoreBundle\Entity\User,
    ChatCreeSoftware\FileserverBundle\Entity\FileLink;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Acl\Dbal\MutableAclProvider;

class FileNotification {
    
    protected $entityManager;
    protected $aclProvider;
    protected $mailer;
    protected $twig;
    
    public function __construct( EntityManager $entityManager, \Swift_Mailer $mailer, MutableAclProvider $aclProvider, \Twig_Environment $twig ){
        $this->entityManager = $entityManager;
        $this->aclProvider = $aclProvider;
        $this->mailer = $mailer;
        $this->twig = $twig;
    }


    public function calculateProjectUsers(Project $project) {
        // get the project acl
        $objectIdentity = ObjectIdentity::fromDomainObject($project);
        $acl = $this->aclProvider->findAcl($objectIdentity);

        $projectUsers = array();
        foreach ($acl->getObjectAces() as $aceEntry) {
            $identity = $aceEntry->getSecurityIdentity();
            $repository = $this->entityManager->getRepository($identity->getClass());
            $user = $repository->findOneByLogin($identity->getUsername());

            if ($user && $user->getEnabled()) {
                $projectUsers[] = $user;
            }
        }
        return $projectUsers;
    }
    
    public function mailFileNotifications(User $user, Project $project, $folderpath, $files, $attachments ) {
        // Find share document Flag
        $flagRepo = $this->entityManager->getRepository('CoreBundle:Flags');
        $flag = $flagRepo->findOneBy(array('flagExtra' => "DOCSHARE"));

        // Send mail to other users that have access to this project
        foreach ($this->calculateProjectUsers($project) as $sendUser) {
            if ($user->getLogin() == $sendUser->getLogin()) {
                continue;
            }
            $fileLinks = [];
            $fichiers = "";
            foreach ($files->getFiles() as $file) {
                $fileLink = new FileLink($sendUser, $project, $folderpath . "/" . $file->getClientOriginalName());
                $this->entityManager->persist($fileLink);
                $fileLinks[] = $fileLink;
                if ($fichiers) {
                    $fichiers .= ", " . $file->getClientOriginalName();
                } else {
                    $fichiers = $file->getClientOriginalName();
                }
            }

            foreach ($sendUser->getEmails() as $mail) {
                $message = \Swift_Message::newInstance()
                        ->setSubject('Modification du projet ' . $project->getProjectName())
                        ->setFrom('info@rl-architecture.lu')
                        ->setTo($mail->getMail())
                        ->setContentType('text/html')
                        ->setBody($this->twig->render('FileserverBundle:Mails:emailUploadSuccess.html.twig', array(
                            'projectName' => $project->getProjectName(),
                            'foldername' => $folderpath,
                            'comment' => $files->getComment(),
                            'files' => $fileLinks,
                            'user' => $sendUser,
                            'logonUser' => $user)));
                foreach ($attachments as $attachment) {
                    $message->attach(\Swift_Attachment::fromPath($attachment));
                }

                $this->mailer->send($message);

                if (count($files) == 1) {
                    $texte = "Fichier $fichiers envoyé à ";
                } else {
                    $texte = "Fichiers $fichiers envoyés à ";
                }
                $logEntry = new LogBook($project, $flag, $user, true);
                $logEntry->setTexte($texte . $sendUser->getFirstname() . " " . $sendUser->getLastname() . " sur l'adresse " . $mail->getMail());

                $this->entityManager->persist($logEntry);
            }
        }
        $this->entityManager->flush();
    }
}
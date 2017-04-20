<?php

namespace ChatCreeSoftware\CoreBundle\Controller;

use ChatCreeSoftware\CoreBundle\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

class fileUploadController extends Controller {

    private $entity;

    public function initialize( $request ){
        $em = $this->get('doctrine')->getManager();
        $directory = $this->getParameter('web_dir');

        $this->entity = $request->get("uploadEntity");
        $projectId = $request->get("projectId");
        $foldername = $request->get("foldername");
        $bordereauId = $request->get("bordereauId");  

        $projectRepo = $em->getRepository("CoreBundle:Project");
        $project = $projectRepo->findOneById( $projectId );
        
        $path = $project->calculatePath( $directory, $this->entity, $foldername, $bordereauId );
        
        return $path;
    }
    
    /**
     * @Route( "/fileUpload/upload", name="_core_file_upload" )
     */
    public function uploadAction( Request $request ){       
        $path = $this->initialize($request);
        
        if( $this->entity == "Bordereau" ){
            $uploadedFile = $request->files->get("file_data");
        } else {
            $uploadedFile = $request->files->get("form")["files"][0];
        }
        
        if (!\file_exists( $path )) {
            mkdir( $path , 0705, true );
        }

        $ajaxResult = [];
        try {
            $uploadedFile->move( $path, $uploadedFile->getClientOriginalName());
        } catch (FileException $e) {
            $ajaxResult["error"] = $e->getMessage();
        }

        $return = json_encode($ajaxResult);
        return new Response($return, 200);
    }
    
    /**
     * @Route( "/fileUpload/delete", name="_core_file_delete" )
     */
    public function deleteAction( Request $request ){
        $path = $this->initialize($request);
        $filename = $request->get('key');
        
        $ajaxResult = [];
        if( \file_exists( "$path/$filename" ) ){
            $deleted = unlink( "$path/$filename" );
            if( ! $deleted ) {
                $ajaxResult['error'] = "impossible de supprimer le fichier";
            }
        } else {
            $ajaxResult['error'] = "Fichier inexistant";
        }
        
        $return = json_encode($ajaxResult);
        return new Response($return, 200);
    }
    
}
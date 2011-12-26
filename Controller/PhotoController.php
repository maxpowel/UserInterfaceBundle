<?php

namespace Wixet\UserInterfaceBundle\Controller;

use Symfony\Component\BrowserKit\Response;

use Wixet\WixetBundle\Entity\MediaItem;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
* @Route("/photo", name="_photo_controller")
*/

class PhotoController extends Controller
{
     
     /**
     * @Route("/upload", name="_upload_post")
      * @Method({"POST"})
     */
     public function postUploadAction()
     {
     
     //Create the mediaItem
     	$mediaItem = new MediaItem();
     	$mimeType =$this->getDoctrine()->getRepository('Wixet\WixetBundle\Entity\MimeType')->findOneByName($_FILES['file']['type']);
     	$album = $this->getDoctrine()->getRepository('Wixet\WixetBundle\Entity\Album')->find($_POST['albumId']);
         	$uploader = $this->get('security.context')->getToken()->getUser()->getProfile(); 
     	if($album->getProfile()->getId() == $uploader->getId() ){
     
     	$mediaItem->setAlbum($album);
     	$mediaItem->setMimeType($mimeType);
     	$mediaItem->setViews(0);
     	$mediaItem->setDisabled(false);
     	$mediaItem->setPublic(false);
     	$mediaItem->setProfile($uploader);
     
     	$mediaItem->setFileSize($_FILES['file']['size']);
     
     	$em = $this->get('doctrine')->getEntityManager();
     	$em->persist($mediaItem);
     	    	$em->flush();
     	//
     	//Add permissions
     	$ws = $this->get('wixet.permission_manager');
     	$ws->setPermission($mediaItem,$this->get('security.context')->getToken()->getUser()->getProfile(),true,true,false,false);
     	//Save file
     	$mim = $this->get('wixet.media_item_manager');
     	    	$mim->saveFile($_FILES['file']['tmp_name'], $mediaItem);
     	}
     	 
     	 
     	$data = array("id"=>$mediaItem->getId());
      
     
         	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
     }
     
     /**
     * @Route("/profile", name="_profile_get")
     */
     public function getThumbnailProfileAction()
     {
     
	     $fetcher = $this->get('wixet.fetcher');
	     $profile = $uploader = $this->get('security.context')->getToken()->getUser()->getProfile();
	     $mediaItem = $fetcher->get('Wixet\WixetBundle\Entity\MediaItem',$_GET['id'],$profile);
	     if($mediaItem != null){
     		$mim = $this->get('wixet.media_item_manager');
     		$mim->printProfileThumbnail($mediaItem);
     	}
      
      
     
     
     	return new \Symfony\Component\HttpFoundation\Response();
     }
     
     /**
     * @Route("/thumbnail", name="_thumbnail_get")
     */
     public function getThumbnailAction()
     {
     	 
     	$fetcher = $this->get('wixet.fetcher');
     	$profile = $uploader = $this->get('security.context')->getToken()->getUser()->getProfile();
     	$mediaItem = $fetcher->get('Wixet\WixetBundle\Entity\MediaItem',$_GET['id'],$profile);
     	if($mediaItem != null){
     		$mim = $this->get('wixet.media_item_manager');
     		$mim->printMediaItemThumbnail($mediaItem);
     	}
     
     
     	 
     	 
     	return new \Symfony\Component\HttpFoundation\Response();
     }
     
     /**
     * @Route("/original", name="_original_get")
     */
     public function getOriginalPhotoAction()
     {
     	 
     	$fetcher = $this->get('wixet.fetcher');
     	$profile = $uploader = $this->get('security.context')->getToken()->getUser()->getProfile();
     	$mediaItem = $fetcher->get('Wixet\WixetBundle\Entity\MediaItem',$_GET['id'],$profile);
     	if($mediaItem != null){
     		$mim = $this->get('wixet.media_item_manager');
     		$mim->printMediaItemOriginal($mediaItem);
     	}
     	 
     	 
     	 
     	 
     	return new \Symfony\Component\HttpFoundation\Response();
     }
     
     /**
     * @Route("/", name="_photo_index")
     */
     public function getPhotoAction()
     {
     	 
     	$fetcher = $this->get('wixet.fetcher');
     	$profile = $uploader = $this->get('security.context')->getToken()->getUser()->getProfile();
     	$mediaItem = $fetcher->get('Wixet\WixetBundle\Entity\MediaItem',$_GET['id'],$profile);
     	if($mediaItem != null){
     		$mim = $this->get('wixet.media_item_manager');
     		$mim->printMediaItem($mediaItem);
     	}
     	 
     	 
     	 
     	 
     	return new \Symfony\Component\HttpFoundation\Response();
     }
     
}

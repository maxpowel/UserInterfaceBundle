<?php

namespace Wixet\UserInterfaceBundle\Controller;

use Wixet\WixetBundle\Entity\MediaItemComment;

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
	* @Route("/comment", name="_photo_comment_get")
	* @Method({"GET"})
	*/
	public function getCommentAction()
	{
		$pageSize = 10;
		$offset = ($_GET['page']-1)*$pageSize;
		$photoId = $_GET['photo'];
		
		$data = array();
		
		$fetcher = $this->get('wixet.fetcher');
		$profile = $uploader = $this->get('security.context')->getToken()->getUser()->getProfile();
		$mediaItem = $fetcher->get('Wixet\WixetBundle\Entity\MediaItem',$photoId,$profile);
		if($mediaItem != null){
			$comments = $mediaItem->getComments();
			$models = array();
			
			foreach($comments->slice($offset, $pageSize) as $comment){
				$profile = $comment->getProfile();
				$models[] = array("id"=>$comment->getId(),"firstName"=>$profile->getFirstName(), "lastName"=>$profile->getLastName(), "date"=>$comment->getCreated()->format('Y-m-d H:i:s'), "body"=>$comment->getBody());
			}
			
			$data = array("total"=> $comments->count(),
								  "psize"=> $pageSize,
								  "models"=> $models);
			
		
		}else{
			$data['error'] = "Access denied";
		}
		
		
		

		
		
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
	
	/**
	* @Route("/comment", name="_photo_comment_post")
	* @Method({"POST"})
	*/
	public function postCommentAction()
	{
		$data = json_decode(file_get_contents('php://input'),true);
		
		$photoId = $data['photoId'];
		$body = trim($data['body']);
		
		$data = array();
		
		$fetcher = $this->get('wixet.fetcher');
		$profile = $uploader = $this->get('security.context')->getToken()->getUser()->getProfile();
		$mediaItem = $fetcher->get('Wixet\WixetBundle\Entity\MediaItem',$photoId,$profile);
		if($mediaItem != null && strlen($body) > 0){
			$comment = new MediaItemComment();
			$comment->setProfile($profile);
			$comment->setBody($body);
			$comment->setMediaItem($mediaItem);
			
			$em = $this->get('doctrine')->getEntityManager();
			$em->persist($comment);
			$em->flush();
				
		
		}else{
			$data['error'] = "Access denied";
		}
		
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
	
	/**
	* @Route("/tag", name="_photo_tag_post")
	* @Method({"POST"})
	*/
	public function postTagAction()
	{
		
		$data = json_decode(file_get_contents('php://input'),true);
		$data['id'] = rand(0, 100);
	
	
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}	
	
	/**
	* @Route("/tag/{id}", name="_photo_tag_delete")
	* @Method({"DELETE"})
	*/
	public function deleteTagAction($id)
	{
		$data = array();
	
	
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
	
		
     /**
     * @Route("/upload", name="_upload_post")
     * @Method({"POST"})
     */
     public function postUploadAction()
     {
     
     //Create the mediaItem
     	$mediaItem = new MediaItem();
     	$em = $this->get('doctrine')->getEntityManager();
     	$data = array();
     	
     	$mimeType =$this->getDoctrine()->getRepository('Wixet\WixetBundle\Entity\MimeType')->findOneByName($_FILES['file']['type']);
     	if($mimeType == null){
     		//Mimetype does not exist. Here we create it, but we can abort the upload
     		$mimeType = new \Wixet\WixetBundle\Entity\MimeType();
     		$mimeType->setName($_FILES['file']['type']);
     		$em->persist($mimeType);
     		$em->flush();
     	}
     	
     	
     	$album = $this->getDoctrine()->getRepository('Wixet\WixetBundle\Entity\ItemContainer')->find($_POST['albumId']);
        $uploader = $this->get('security.context')->getToken()->getUser()->getProfile();
         
     	if($album->getProfile()->getId() == $uploader->getId() ){
     
	     	$mediaItem->setMimeType($mimeType);
	     	$mediaItem->setViews(0);
	     	$mediaItem->setDisabled(false);
	     	$mediaItem->setPublic(false);
	     	$mediaItem->setProfile($uploader);
	     
	     	$mediaItem->setFileSize($_FILES['file']['size']);
	     
	     	
	     	$em->persist($mediaItem);
	     	$em->flush();
	     	//
	     	//Add permissions
	     	$ws = $this->get('wixet.permission_manager');
	     	$ws->setItemContainer($mediaItem, $album);
	     	//Not necesary, inherited from itemContainer $ws->setPermissionProfileItem($profile,$mediaItem, array("readGranted"=>true, "readDenied"=>false, "writeGranted"=> true, "writeDenied"=> false));
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
     * @Route("/thumbnail/{id}", name="_thumbnail_get")
     */
     public function getThumbnailAction($id)
     {
     	 
     	$fetcher = $this->get('wixet.fetcher');
     	$profile = $uploader = $this->get('security.context')->getToken()->getUser()->getProfile();
     	$mediaItem = $fetcher->get('Wixet\WixetBundle\Entity\MediaItem',$id,$profile);
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
     * @Route("/normal/{id}", name="_photo_index")
     */
     public function getPhotoAction($id)
     {
     	 
     	$fetcher = $this->get('wixet.fetcher');
     	$profile = $uploader = $this->get('security.context')->getToken()->getUser()->getProfile();
     	$mediaItem = $fetcher->get('Wixet\WixetBundle\Entity\MediaItem',$id,$profile);
     	if($mediaItem != null){
     		$mim = $this->get('wixet.media_item_manager');
     		$mim->printMediaItem($mediaItem);
     	}
     	 
     	 
     	 
     	 
     	return new \Symfony\Component\HttpFoundation\Response();
     }
     
     /**
     * @Route("/{id}", name="_photo_data")
     */
     public function getPhotoDataAction($id)
     {
     
     	$data = array();
     	$fetcher = $this->get('wixet.fetcher');
     	$profile = $uploader = $this->get('security.context')->getToken()->getUser()->getProfile();
     	$mediaItem = $fetcher->get('Wixet\WixetBundle\Entity\MediaItem',$id,$profile);
     	if($mediaItem != null){
     		
     		$album = $fetcher->getItemContainer($mediaItem);
     		$data['album']= array("id"=>$album->getId(), "name"=>$album->getName());
     		
     		
     		$data['id']=$mediaItem->getId();
     		$data['description'] = $mediaItem->getDescription();
     		$data['name'] = $mediaItem->getTitle();
     		$data['next']= $fetcher->getNext($mediaItem, $album, $profile);
     		$data['prev']= $fetcher->getPrevious($mediaItem, $album, $profile);
     		     		
     		$owner = $mediaItem->getProfile();
     		$data['owner'] = array("id"=> $owner->getId(), "name"=>$owner->getFirstName()." ".$owner->getLastName());
     		
     		$tags = array();
     		$tags[] = array("id"=>45, "value"=>"Alvaro", "left"=>50, "top"=>100);
     		$tags[] = array("id"=>60, "value"=>"Powel", "left"=>0, "top"=>130);
     		$data['tags'] = $tags;
     
     	}else{
     		$data['error'] = "Access denied";
     	}
     		
     
     		
     		
     	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
     }
     
}

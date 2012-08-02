<?php

namespace Wixet\UserInterfaceBundle\Controller;

use Wixet\WixetBundle\Entity\MediaItemComment;
use Wixet\WixetBundle\Entity\MediaItemTag;

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
		
		$viewer = $this->get('security.context')->getToken()->getUser()->getProfile();
		$fetcher = $this->get('wixet.fetcher');
		$photo = $fetcher->getWritable("Wixet\WixetBundle\Entity\MediaItem",$data['mediaItemId'],$viewer);
		$taggedPerson = $fetcher->getPassive("Wixet\WixetBundle\Entity\UserProfile",$data['profileId'],$viewer);
		
		if($photo && $taggedPerson){
			$tag = new MediaItemTag();
			$tag->setPosition(array("left"=> $data['left'] ,"top"=> $data['top']));
			$tag->setProfile($taggedPerson);
			$tag->setOwner($viewer);
			$tag->setMediaItem($photo);
			
			$em = $this->get('doctrine')->getEntityManager();
			$em->persist($tag);
			$em->flush();
			
			$data['id'] = $tag->getId();
		}else
			$data= array("error"=>"Denied");
		
		
	
	
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}	
	
	/**
	* @Route("/tag/{id}", name="_photo_tag_delete")
	* @Method({"DELETE"})
	*/
	public function deleteTagAction($id)
	{
		
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$em = $this->get('doctrine')->getEntityManager();
		$tag = $em->getRepository('Wixet\WixetBundle\Entity\MediaItemTag')->find($id); 

		$data = array("error"=>"false");
		if($tag->getProfile()->getId() == $profile->getId() || $tag->getOwner()->getId() == $profile->getId()){
			$em->remove($tag);
			$em->flush();

		}else
			$data= array("error"=>"Denied");
		
	
	
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
     * @Route("/profile/{id}", name="_profile_get")
     */
     public function getThumbnailProfileAction($id)
     {
     
	     //$fetcher = $this->get('wixet.fetcher');
	     //$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
	     //$mediaItem = $fetcher->get('Wixet\WixetBundle\Entity\MediaItem',$_GET['id'],$profile);
	     //$mediaItem = $this->get('security.context')->getToken()->getUser()->getProfile()->getMainMediaItem();
	     
     	//Profile photo is public
     	$em = $this->get('doctrine')->getEntityManager();
     	 $mediaItem = $em->getRepository('Wixet\WixetBundle\Entity\UserProfile')->find($id)->getMainMediaItem();
     	 $mim = $this->get('wixet.media_item_manager');
	     if($mediaItem != null){
     		$mim->printProfileThumbnail($mediaItem);
     	}else{
     		$mim->printDefaultPublicProfileThumbnail();
     	}
     
     	return new \Symfony\Component\HttpFoundation\Response();
     }
     
     /**
     * @Route("/public/{id}", name="_public_get")
     */
     public function getThumbnailPublicProfileAction($id)
     {
     	 
     	//$fetcher = $this->get('wixet.fetcher');
     	//$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
     	//$mediaItem = $fetcher->get('Wixet\WixetBundle\Entity\MediaItem',$_GET['id'],$profile);
     	//$mediaItem = $this->get('security.context')->getToken()->getUser()->getProfile()->getMainMediaItem();
     
     	//Profile photo is public
     	$em = $this->get('doctrine')->getEntityManager();
     	$mediaItem = $em->getRepository('Wixet\WixetBundle\Entity\UserProfile')->find($id)->getMainMediaItem();
     	$mim = $this->get('wixet.media_item_manager');
     	if($mediaItem != null){
     		$mim->printPublicProfileThumbnail($mediaItem);
     	}else{
     		$mim->printDefaultProfileThumbnail();
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
     * @Route("/original/{id}", name="_original_get")
     */
     public function getOriginalPhotoAction($id)
     {
     	 
     	$fetcher = $this->get('wixet.fetcher');
     	$profile = $uploader = $this->get('security.context')->getToken()->getUser()->getProfile();
     	$mediaItem = $fetcher->get('Wixet\WixetBundle\Entity\MediaItem',$id,$profile);
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
     * @Method({"GET"})
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
     		foreach($mediaItem->getTags() as $tag){
     			$pf = $tag->getProfile();
     			$position = $tag->getPosition();
	     		$tags[] = array("id"=>$tag->getId(), "value"=>$pf->getFirstName()." ".$pf->getLastName(), "left"=>$position['left'], "top"=>$position['top']);
     		}
     		
     		$data['tags'] = $tags;
     
     	}else{
     		$data['error'] = "Access denied";
     	}
     		
     
     		
     		
     	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
     }
     
     /**
     * @Route("/", name="_photo_data_update")
     * @Method({"PUT"})
     */
     public function putPhotoDataAction()
     {
     	 
     	$data = array();
     	$data = json_decode(file_get_contents('php://input'),true);
     	$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
     	$em = $this->get('doctrine')->getEntityManager();
     	$photo = $em->getRepository('Wixet\WixetBundle\Entity\MediaItem')->find($data['id']);
     	
     	
     	if($photo->getProfile()->getId() == $profile->getId()){
     		 $photo->setTitle($data['name']);
     		 $photo->setDescription($data['description']);
     		 $em->flush();
     	}else{
     		$data['error'] = "Access denied";
     	}
     	 
     	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
     }
     
}


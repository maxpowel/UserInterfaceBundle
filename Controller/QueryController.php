<?php

namespace Wixet\UserInterfaceBundle\Controller;

use Wixet\WixetBundle\Entity\ProfileUpdate;

use Symfony\Component\BrowserKit\Response;

use Wixet\WixetBundle\Entity\MediaItem;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
* @Route("/query")
*/
class QueryController extends Controller
{   
	/**
    * @Route("/people", name="_query_autocomplete_people")
    */
    public function getGroupAction()
    {
    	$data = array();
    	


    	$models = array();
    		$models[] = array("name"=>"Amigos","id"=>1);
    		$models[] = array("name"=>"Feos","id"=>2);
    		$models[] = array("name"=>"Otros","id"=>3);
    		
    	
    	$data = $models;
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
    }
    


}

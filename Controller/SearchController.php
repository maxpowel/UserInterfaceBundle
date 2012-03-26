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
* @Route("/search")
*/
class SearchController extends Controller
{   
	/**
    * @Route("/", name="_search_all")
    */
    public function getSearchAllAction()
    {
    	$qm = $this->get('wixet.query_manager');
    	
    	$data = array();
    	
    	$res = $qm->fullSearch($_GET['q']);
    	
		

    	$data['models'] = $res['results'];
    	
    	$data['psize'] = 10;
    	$data['total'] = $res['total'];
    	
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
    }
    


}

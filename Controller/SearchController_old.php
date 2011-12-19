<?php

namespace Wixet\UserInterfaceBundle\Controller;

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
     * @Route("/", name="_index")
     */
    public function indexAction()
    {
        return $this->forward('OpenSocialBundle:Section:start');
    }
    
    /**
     * @Route("/start", name="_start")
     * @Template()
     */
    public function startAction()
    {

        return array();
    }

    /**
     * @Route("/profile/{id}", name="_profile")
     * @Template()
     */
    public function profileAction($id)
    {
        return array();
    }
     
    /**
     * @Route("/search", name="_search")
     * @Template()
     */
    public function searchAction($id)
    {
        return array();
    }

}

<?php

namespace Fbeen\SimpleCmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Fbeen\SimpleCmsBundle\Entity\Content;

class ContentController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('FbeenSimpleCmsBundle:Content:index.html.twig', array(
            'content' => $this->get('fbeen.simple_cms.content_helper')->getContent()
        ));
    }
}

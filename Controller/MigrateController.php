<?php

namespace Fbeen\SimpleCmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Fbeen\SimpleCmsBundle\Entity\Content;
use Fbeen\SimpleCmsBundle\Entity\Block;

class MigrateController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $conn = $em->getConnection();
        
        $oldBlocks = $conn->fetchAll('SELECT * FROM block b LEFT JOIN block_container c ON b.blockcontainer_id = c.id');
        
        foreach($oldBlocks as $oldBlock)
        {
            $content = $em->getRepository('FbeenSimpleCmsBundle:Content')->find($oldBlock['content_id']);
            
            $block = new Block();
            $block->setContent($content);
            $block->setIdentifier($oldBlock['identifier']);
            $block->setSection($oldBlock['name']);
            $block->setSort($oldBlock['sort']);
            $block->setType($oldBlock['type']);
            
            $em->persist($block);
        }
        
        $em->flush();
    }
}

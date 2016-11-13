<?php

namespace Fbeen\SimpleCmsBundle\Admin;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
 
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
 
class ClearCacheBlockService extends BaseBlockService
{
    protected $container;
    
    /**
     * @param string          $name
     * @param EngineInterface $templating
     * @param EntityManager   $em
     */
    public function __construct($name, $templating, $container)
    {
        parent::__construct($name, $templating);
 
        $this->templating = $templating;
        $this->container = $container;
    }
 
    public function getName()
    {
        return 'Admin Clear Cache Block';
    }
 
    /**
     * Define valid options for a block of this type.
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'title'    => 'Clear Cache',
            'template' => 'block/help.html.twig',
        ));
    }
 
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();
        
        return $this->renderResponse('FbeenSimpleCmsBundle:Admin:clear_cache_block.html.twig', array(
            'block'    => $blockContext->getBlock(),
            'settings' => $settings,
        ), $response);
    }
}
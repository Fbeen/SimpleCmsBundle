<?php

namespace Fbeen\SimpleCmsBundle\Blocks;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Fbeen\SimpleCmsBundle\Model\BlockInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of NewsBlock
 *
 * @author Frank Beentjes <frankbeen@gmail.com>
 */

class NewsBlock extends AbstractBlock
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'template'  => 'FbeenSimpleCmsBundle:Blocks:news_block.html.twig',
            'homepage'  => false,
            'title'     => 'news',
        ));
    }

    public function renderBlock($identifier)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        
        if($this->options['homepage'])
        {
            $items = $em->getRepository('FbeenSimpleCmsBundle:Newsitem')->findFrontpageNews()->getResult();
        } else {
            $items = $em->getRepository('FbeenSimpleCmsBundle:Newsitem')->findAllActive()->getResult();
        }
        
        return $this->container->get('twig')->render($this->options['template'], array('newsitems' => $items));
    }
}

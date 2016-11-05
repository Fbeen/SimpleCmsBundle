<?php

namespace Fbeen\SimpleCmsBundle\Blocks;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Fbeen\SimpleCmsBundle\Model\BlockInterface;

/**
 * Description of SimpleBlock
 *
 * @author Frank Beentjes <frankbeen@gmail.com>
 */

class MenuBlock implements BlockInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function renderBlock($identifier)
    {
        return $identifier . ' menu';
    }
}

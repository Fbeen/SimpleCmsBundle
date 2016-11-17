<?php

namespace Fbeen\SimpleCmsBundle\Model;

/**
 *
 * @author Frank Beentjes <frankbeen@gmail.com>
 */
interface BlockInterface
{
    public function setOptions($options);
    public function renderBlock($identifier);
}

<?php

/**
 * This class enables the IsSimpleCmsAction annotation.
 *
 * @author Frank Beentjes <frankbeen@gmail.com>
 */
namespace Fbeen\SimpleCmsBundle\Annotation;

use Doctrine\Common\Annotations\AnnotationException;

/**
 * @Annotation
 */
class IsSimpleCmsAction 
{
    private $name;
    
    public function __construct($options)
    {        
        if(!isset($options['value']))
        {
            throw new AnnotationException("The @Slug annotation must have at least one parameter. e.g. @IsSimpleCmsAction(\"MyCustomName\")");
        }

        $this->name = $options['value'];
    }
    
    public function getName()
    {
        return $this->name;
    }
}
<?php

namespace Fbeen\SimpleCmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SliderAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('identifier')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('identifier')
            ->add('timeout', null, array('label' => 'slider.timeout'))
            ->add('pause', null, array('label' => 'slider.pause'))
            ->add('wrap', null, array('label' => 'slider.wrap'))
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('identifier')
            ->add('timeout', null, array('label' => 'slider.timeout'))
            ->add('pause', null, array('label' => 'slider.pause'))
            ->add('wrap', null, array('label' => 'slider.wrap'))
            ->add('images')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('identifier')
            ->add('timeout', null, array('label' => 'slider.timeout'))
            ->add('pause', null, array('label' => 'slider.pause'))
            ->add('wrap', null, array('label' => 'slider.wrap'))
            ->add('images')
        ;
    }
}

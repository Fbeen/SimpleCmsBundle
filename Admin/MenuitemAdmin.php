<?php

namespace Fbeen\SimpleCmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class MenuitemAdmin extends AbstractAdmin
{
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'sort',
    );

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('route')
            ->add('url')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('route')
            ->add('url')
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
            ->add('name')
            ->add('translations', TranslationsType::class, [
                'label' => 'Label',
                'required' => TRUE,
                'fields' => [
                    'label' => [
                        'field_type' => null,
                        'label' => false,
                     ]
                ]
            ])
            ->add('type', 'sonata_type_choice_field_mask', array(
                'choices' => array(
                    'url' => 'url',
                    'route' => 'route',
                ),
                'map' => array(
                    'route' => array('route'),
                    'url' => array('url'),
                ),
                'placeholder' => 'Choose an option',
                'required' => true
            ))
            ->add('route')
            ->add('url')
            ->add('aClass')
            ->add('liClass')
            ->add('sort', 'hidden', array(
                'label' => FALSE,
                'attr' => array('class' => 'sortable')
            ))
/*            ->add('menu', null, array(
                'required' => true
            )) */
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('route')
            ->add('url')
            ->add('menu')
        ;
    }
}

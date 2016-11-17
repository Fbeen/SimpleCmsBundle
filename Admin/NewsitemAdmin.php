<?php

namespace Fbeen\SimpleCmsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class NewsitemAdmin extends Admin
{
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'created',
    );

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('translations', TranslationsType::class, [
                'label' => FALSE,
                'required' => FALSE,
                'fields' => [
                    'title' => [
                        'field_type' => null,
                        'label' => 'Title',
                     ],
                    'body' => [
                        'field_type' => CKEditorType::class,
                        'label' => 'Body',
                     ]
                ]
            ])
            ->add('publishAble', NULL, array('label' => 'Publiceren'))
            ->add('showOnFrontpage', NULL, array('label' => 'Toon op de Homepage'))
            ->add('publishFrom', NULL, array('label' => 'Publiceren vanaf'))
            ->add('publishUntil', NULL, array('label' => 'Publiceren tot en met'))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title',  NULL, array('label' => 'Titel'))
            ->add('publishAble', NULL, array('label' => 'Publiceren', 'editable' => TRUE))
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }
    
    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title', NULL, array('label' => 'Titel'))
            ->add('body', 'html', array('label' => 'Bericht'))
        ;
    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        // to remove a single route
        //$collection->remove('create');
    }
    
    public function prePersist($newsitem)
    {
        $newsitem->mergeNewTranslations();
    }

    public function preUpdate($newsitem)
    {
        $this->prePersist($newsitem);
    }
}
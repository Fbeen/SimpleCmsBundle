<?php

namespace Fbeen\SimpleCmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Fbeen\SimpleCmsBundle\Entity\Content;

class ContentAdmin extends AbstractAdmin
{
    public function configure() {
        $this->setTemplate('edit', 'FbeenSimpleCmsBundle:Admin:edit_menu.html.twig');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
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
            ->tab('Global')
                ->with('Global')
                    ->add('name')
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
                ->end()
            ->end()
            ->tab('Blocks')
                ->with('Container blocks')
                    ->add('blockContainers', 'sonata_type_collection', array(
                        'by_reference' => false,
                        'label' => 'Block containers',
                        'type_options' => array('delete' => true),
                        'btn_add' => 'Add Container',
                        'required' => false,
                        'help' => 'container_help'

                    )
                    , array(
                        'edit' => 'inline',
                        'inline' => 'table'
                    ))
                ->end()
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('created')
        ;
    }
    
    public function prePersist($content)
    {
        $this->persistBlockContainers($content);
        
        $content->mergeNewTranslations();
    }

    public function preUpdate($content)
    {
        $this->prePersist($content);
    }
    
    private function persistBlocks($blockContainer)
    {
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');

        foreach($blockContainer->getBlocks() as $block)
        {
            $block->setBlockContainer($blockContainer);
            $em->persist($block); 
        }
    }
    
    private function persistBlockContainers($content)
    {
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');

        foreach($content->getBlockContainers() as $blockContainer)
        {
            $this->persistBlocks($blockContainer);
            
            $blockContainer->setContent($content);
            $em->persist($blockContainer); 
        }
    }
}

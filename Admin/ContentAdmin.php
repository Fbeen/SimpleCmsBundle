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
use Fbeen\SimpleCmsBundle\Entity\BlockContainer;

class ContentAdmin extends AbstractAdmin
{
    public function getNewInstance()
    {
        $content = parent::getNewInstance();
        $instance->setName('my default value');

        return $instance;
    }

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
        ;
        
            $formMapper
                ->with('Blocks')
                    ->add('blocks', 'sonata_type_collection', array(
                        'label' => 'Blocks',
                        'type_options' => array('delete' => true),
                        'btn_add' => 'Add Block',
                        'required' => false,
                        'help' => 'container_help'

                    )
                    , array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'dummy'
                    ))
                ->end()
            ;
        
        $formMapper->end();
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
        $this->persistBlocks($content);
        
        $content->mergeNewTranslations();
    }

    public function preUpdate($content)
    {
        $this->prePersist($content);
    }
    
    private function persistBlocks($content)
    {
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');

        foreach($content->getBlocks() as $block)
        {
            $block->setContent($content);
            $em->persist($block); 
        }
    }
}

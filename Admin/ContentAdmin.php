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
            ->add('enabled')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('enabled')
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
            ->tab('Algemeen')
                ->with('Algemeen')
                    ->add('name')
                    ->add('translations', TranslationsType::class, [
                        'label' => FALSE,
                        'required' => FALSE,
                        'fields' => [
                            'title' => [
                                'field_type' => null,
                                'label' => 'Titel',
                             ],
                            'body' => [
                                'field_type' => CKEditorType::class,
                                'label' => 'Body',
                             ]
                        ]
                    ])
                    ->add('enabled')
                ->end()
            ->end()
            ->tab('Blocks')
                ->with('Container blocks')
                    ->add('blockContainers', 'sonata_type_collection', array(
                        'by_reference' => false,
                        'label' => 'Block containers',
                        'type_options' => array('delete' => true),
                        'btn_add' => ' Container toevoegen',
                        'required' => false,
                        'help' => '<br><i class="fa fa-info-circle" aria-hidden="true"></i> Blocks worden in een containerblok geplaatst. Hierdoor is het mogelijk om meerdere blokken onder of naast elkaar te plaatsen en tevens kunt u de volgorde van de blokken in de container bepalen.'

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
            ->add('enabled')
        ;
    }
    
    public function prePersist($content)
    {
        $this->persistBlockContainers($content);
        
        //$menu->mergeNewTranslations();
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
            
            $blockContainer->addContent($content);
            $em->persist($blockContainer); 
        }
    }
}

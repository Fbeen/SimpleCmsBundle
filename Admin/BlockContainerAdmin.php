<?php

namespace Fbeen\SimpleCmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class BlockContainerAdmin extends AbstractAdmin
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
            ->add('name')
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
            //->add('contents')
            ->add('blocks', 'sonata_type_collection', array(
                'by_reference' => false,
                'label' => 'Blocks',
                'type_options' => array('delete' => true),
                'btn_add' => ' Blok toevoegen',
                'required' => false,
                'help' => '<br><i class="fa fa-info-circle" aria-hidden="true"></i> Blocks worden in een containerblok geplaatst. Hierdoor is het mogelijk om meerdere blokken onder of naast elkaar te plaatsen en tevens kunt u de volgorde van de blokken in de container bepalen.'

            )
            , array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'dummy'
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
        ;
    }
    
    public function prePersist($blockContainer)
    {
        $this->persistBlocks($blockContainer);
        
        //$menu->mergeNewTranslations();
    }

    public function preUpdate($blockContainer)
    {
        $this->prePersist($blockContainer);
    }
    
    private function persistBlocks($blockContainer)
    {
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');

        foreach($blockContainer->getBlocks() as $block)
        {
            $block->addBlockContainer($blockContainer);
            $em->persist($block); 
        }
    }
}

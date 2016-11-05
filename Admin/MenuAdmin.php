<?php

namespace Fbeen\SimpleCmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Fbeen\SimpleCmsBundle\Entity\Menu;
use Fbeen\SimpleCmsBundle\Entity\Menuitem;


class MenuAdmin extends AbstractAdmin
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
            ->add('name')
            ->add('menuitems', 'sonata_type_collection', array(
                'by_reference' => false,
                'label' => 'Menuitems',
                'type_options' => array('delete' => true),
                'btn_add' => 'Menuitem toevoegen',
                "required" => TRUE )
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
    
    public function prePersist($menu)
    {
        $this->persistMenuitems($menu);
        
        //$menu->mergeNewTranslations();
    }

    public function preUpdate($accommodation)
    {
        $this->prePersist($accommodation);
    }
    
    private function persistMenuitems($menu)
    {
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');

        foreach($menu->getMenuitems() as $menuitem)
        {
            $menuitem->setMenu($menu);
            $em->persist($menuitem); 
        }
    }
}

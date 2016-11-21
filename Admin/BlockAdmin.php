<?php

namespace Fbeen\SimpleCmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BlockAdmin extends AbstractAdmin
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
            ->add('type')
            ->add('identifier')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('section')
            ->add('type')
            ->add('identifier')
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
        $container = $this->getConfigurationPool()->getContainer();
        
        $blocks = $container->getParameter('fbeen_simple_cms.block_types');
        
        $blockChoices = array();
        
        foreach($blocks as $block)
        {
            $blockChoices[$block['name']] = $block['name'];
        }
        
        $names = $this->getConfigurationPool()->getContainer()->getParameter('fbeen_simple_cms.block_container_names');
        
        $sectionChoices = array();

        foreach($names as $name)
        {
            $sectionChoices[$name] = $name;
        }

        $formMapper
            ->add('section', ChoiceType::class, array(
                'label' => 'Positie in de template',
                'choices' => $sectionChoices
            ))
            ->add('type', ChoiceType::class, array(
                'choices' => $blockChoices
            ))
            ->add('identifier')
            ->add('sort', 'hidden', array(
                'label' => FALSE,
                'attr' => array('class' => 'sortable')
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('type')
            ->add('identifier')
        ;
    }
}

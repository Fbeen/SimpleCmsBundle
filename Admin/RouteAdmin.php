<?php

namespace Fbeen\SimpleCmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class RouteAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('path')
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
            ->add('route')
            ->add('enabled')
            ->add('content')
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
            ->add('path')
        ;

        if($this->isMultilingual()) {
            $formMapper->add('useLocale');
        }
        
        $formMapper
            ->add('enabled')
            ->add('controller', null, array(
                'required' => false
            ))
            ->add('content')
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
        ;
        if($this->isMultilingual()) {
            $showMapper->add('useLocale');
        }
        $showMapper
            ->add('enabled')
            ->add('controller')
            ->add('content')
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('clear_cache', 'clearcache');
    }
    
    private function isMultilingual()
    {
        $locales = array();
        if($this->getConfigurationPool()->getContainer()->hasParameter('locales'))
            $locales = $this->getConfigurationPool()->getContainer()->getParameter('locales');
        
        return count($locales) > 1;
    }
    
    public function getNewInstance()
    {
        $instance = parent::getNewInstance();
        
        if($this->isMultilingual())
            $instance->setUseLocale(true);

        return $instance;
    }
}

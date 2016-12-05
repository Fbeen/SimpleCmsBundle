<?php

namespace Fbeen\SimpleCmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Sonata\CoreBundle\Validator\ErrorElement;

class ImageAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('tags', null, array('show_filter' => true, 'label' => 'image.filter.label', 'advanced_filter' => false))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('filename')
            ->add('image', 'html', array('label' => 'Afbeelding'))
            ->add('path', null, array('label' => 'Pad'))
            ->add('_action', null, array(
                'actions' => array(
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
        $required = true;
        
        if(null !== $this->getSubject()->getFilename())
        {
            $required = false;
        }
        
        $formMapper
            ->add('file', FileType::class, array(
                'required' => $required
            ))
            ->add('tags', 'sonata_type_model', array('by_reference' => false, 'multiple' => true, 'btn_add' => 'Nieuw label'))
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        if(null === $file = $object->getFile()) {
            return;
        }
        
        $em  = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');
        $other = $em->getRepository('FbeenSimpleCmsBundle:Image')->findOneBy(array('filename' => strtolower($object->getFile()->getClientOriginalName())));

        if (null !== $other && $other->getId() != $object->getId()) {
            $errorElement
                ->with('file')
                ->addViolation('Bestand bestaat al.')
                ->end();
        }
    }

    public function prePersist($image)
    {
        $file = $image->getFile();
        $path = $this->getConfigurationPool()->getContainer()->getParameter('fbeen_simple_cms.image_path');
        
        $filename = strtolower($file->getClientOriginalName());
        
        @mkdir($path, 0777, true);

        // Move the file to the directory where images are stored
        $file->move($path, $filename);

        $image->setFilename($filename);
    }
    
    public function preRemove($image) {
        $path = $this->getConfigurationPool()->getContainer()->getParameter('fbeen_simple_cms.image_path');
        @unlink($path . '/' . $image->getFilename());
    }
}

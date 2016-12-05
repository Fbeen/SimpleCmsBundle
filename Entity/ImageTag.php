<?php

namespace Fbeen\SimpleCmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ImageTag
 *
 * @ORM\Table(name="image_tag")
 * @ORM\Entity(repositoryClass="Fbeen\SimpleCmsBundle\Repository\ImageTagRepository")
 */
class ImageTag
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, unique=true)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Image", mappedBy="tags")
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ImageTag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add image
     *
     * @param \Fbeen\SimpleCmsBundle\Entity\Image $image
     *
     * @return ImageTag
     */
    public function addImage(\Fbeen\SimpleCmsBundle\Entity\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \Fbeen\SimpleCmsBundle\Entity\Image $image
     */
    public function removeImage(\Fbeen\SimpleCmsBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
}

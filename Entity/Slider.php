<?php

namespace Fbeen\SimpleCmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Slider
 *
 * @ORM\Table(name="slider")
 * @ORM\Entity(repositoryClass="Fbeen\SimpleCmsBundle\Repository\SliderRepository")
 */
class Slider
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
     * @ORM\Column(name="identifier", type="string", length=64)
     */
    private $identifier;

    /**
     * @var integer
     *
     * @ORM\Column(name="timeout", type="integer")
     */
    private $timeout = 10000;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pause", type="boolean")
     */
    private $pause = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="wrap", type="boolean")
     */
    private $wrap = true;

    /**
     * @ORM\ManyToMany(targetEntity="Image")
     * @ORM\JoinTable(name="sliders_images",
     *      joinColumns={@ORM\JoinColumn(name="slider_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="image_id", referencedColumnName="id")}
     *      )
     */
    private $images;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
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
     * Set identifier
     *
     * @param string $identifier
     *
     * @return Slider
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Add image
     *
     * @param \Fbeen\SimpleCmsBundle\Entity\Image $image
     *
     * @return Slider
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

    /**
     * Set timeout
     *
     * @param integer $timeout
     *
     * @return Slider
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Get timeout
     *
     * @return integer
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Set pause
     *
     * @param boolean $pause
     *
     * @return Slider
     */
    public function setPause($pause)
    {
        $this->pause = $pause;

        return $this;
    }

    /**
     * Get pause
     *
     * @return boolean
     */
    public function getPause()
    {
        return $this->pause;
    }

    /**
     * Set wrap
     *
     * @param boolean $wrap
     *
     * @return Slider
     */
    public function setWrap($wrap)
    {
        $this->wrap = $wrap;

        return $this;
    }

    /**
     * Get wrap
     *
     * @return boolean
     */
    public function getWrap()
    {
        return $this->wrap;
    }
}

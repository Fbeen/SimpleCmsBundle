<?php

namespace Fbeen\SimpleCmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Content
 *
 * @ORM\Table(name="content")
 * @ORM\Entity(repositoryClass="Fbeen\SimpleCmsBundle\Repository\ContentRepository")
 */
class Content
{
   use ORMBehaviors\Translatable\Translatable;

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
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @ORM\OneToMany(targetEntity="BlockContainer", mappedBy="content")
     */
    private $blockContainers;

    public function __construct()
    {
        $this->blockContainers = new ArrayCollection();
        $this->created = new \DateTime();
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
     * @return Menu
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
     * Set title
     *
     * @param string $title
     *
     * @return Content
     */
    public function setTitle($title, $locale = null)
    {
        $this->translate($locale)->setTitle($title);

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle($locale = null)
    {
        return $this->translate($locale)->getTitle();
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Content
     */
    public function setBody($body, $locale = null)
    {
        $this->translate($locale)->setBody($body);

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody($locale = null)
    {
        return $this->translate($locale)->getBody();
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Content
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Add block
     *
     * @param \Fbeen\SimpleCmsBundle\Entity\Block $block
     *
     * @return Content
     */
    public function addBlock(\Fbeen\SimpleCmsBundle\Entity\Block $block)
    {
        $this->blocks[] = $block;

        return $this;
    }

    /**
     * Remove block
     *
     * @param \Fbeen\SimpleCmsBundle\Entity\Block $block
     */
    public function removeBlock(\Fbeen\SimpleCmsBundle\Entity\Block $block)
    {
        $this->blocks->removeElement($block);
    }

    /**
     * Get blocks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

    /**
     * Add blockContainer
     *
     * @param \Fbeen\SimpleCmsBundle\Entity\BlockContainer $blockContainer
     *
     * @return Content
     */
    public function addBlockContainer(\Fbeen\SimpleCmsBundle\Entity\BlockContainer $blockContainer)
    {
        $this->blockContainers[] = $blockContainer;

        return $this;
    }

    /**
     * Remove blockContainer
     *
     * @param \Fbeen\SimpleCmsBundle\Entity\BlockContainer $blockContainer
     */
    public function removeBlockContainer(\Fbeen\SimpleCmsBundle\Entity\BlockContainer $blockContainer)
    {
        $this->blockContainers->removeElement($blockContainer);
    }

    /**
     * Get blockContainers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlockContainers()
    {
        return $this->blockContainers;
    }
}

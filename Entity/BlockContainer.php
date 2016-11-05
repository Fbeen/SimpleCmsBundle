<?php

namespace Fbeen\SimpleCmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * BlockContainer
 *
 * @ORM\Table(name="block_container")
 * @ORM\Entity(repositoryClass="Fbeen\SimpleCmsBundle\Repository\BlockContainerRepository")
 */
class BlockContainer
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
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Content", mappedBy="blockContainers")
     */
    private $contents;

    /**
     * @ORM\ManyToMany(targetEntity="Block", inversedBy="blockContainers", cascade={"persist"})
     * @ORM\JoinTable(name="blockcontainers_blocks")
     */
    private $blocks;

    public function __construct()
    {
        $this->contents = new ArrayCollection();
        $this->blocks = new ArrayCollection();
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
     * @return BlockContainer
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
     * Add content
     *
     * @param \Fbeen\SimpleCmsBundle\Entity\Content $content
     *
     * @return BlockContainer
     */
    public function addContent(\Fbeen\SimpleCmsBundle\Entity\Content $content)
    {
        $this->contents[] = $content;

        return $this;
    }

    /**
     * Remove content
     *
     * @param \Fbeen\SimpleCmsBundle\Entity\Content $content
     */
    public function removeContent(\Fbeen\SimpleCmsBundle\Entity\Content $content)
    {
        $this->contents->removeElement($content);
    }

    /**
     * Get contents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * Add block
     *
     * @param \Fbeen\SimpleCmsBundle\Entity\Block $block
     *
     * @return BlockContainer
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
}

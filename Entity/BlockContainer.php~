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
     * @ORM\ManyToOne(targetEntity="Content", inversedBy="blockContainers")
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity="Block", mappedBy="blockContainer", cascade={"persist", "remove"})
     * 
     * @ORM\OrderBy({"sort" = "ASC"})
    */
    private $blocks;

    public function __construct()
    {
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

    /**
     * Set content
     *
     * @param \Fbeen\SimpleCmsBundle\Entity\Content $content
     *
     * @return BlockContainer
     */
    public function setContent(\Fbeen\SimpleCmsBundle\Entity\Content $content = null)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return \Fbeen\SimpleCmsBundle\Entity\Content
     */
    public function getContent()
    {
        return $this->content;
    }
}

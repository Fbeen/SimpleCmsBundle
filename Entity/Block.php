<?php

namespace Fbeen\SimpleCmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Block
 *
 * @ORM\Table(name="blocks")
 * @ORM\Entity
 */
class Block
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
     * @ORM\Column(name="type", type="string", length=64)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="section", type="string", length=64)
     */
    private $section;

    /**
     * @var string
     *
     * @ORM\Column(name="identifier", type="string", length=64, nullable=true)
     */
    private $identifier;

    /**
     * @var integer
     *
     * @ORM\Column(name="sort", type="integer")
     */
    private $sort = 999;

    /**
     * @ORM\ManyToOne(targetEntity="Content", inversedBy="blocks")
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $content;


    public function __toString()
    {
        return $this->getName();
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
     * Set type
     *
     * @param string $type
     *
     * @return Block
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return Menuitem
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return integer
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     *
     * @return Block
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
     * Set content
     *
     * @param \Fbeen\SimpleCmsBundle\Entity\Content $content
     *
     * @return Block
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

    /**
     * Set section
     *
     * @param string $section
     *
     * @return Block
     */
    public function setSection($section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }
}

<?php

namespace Fbeen\SimpleCmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Newsitem
 *
 * @ORM\Table(name="newsitem")
 * @ORM\Entity(repositoryClass="Fbeen\SimpleCmsBundle\Repository\NewsitemRepository")
 */
class Newsitem
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
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publish_from", type="date", nullable=true)
     */
    private $publishFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publish_until", type="date", nullable=true)
     */
    private $publishUntil;

    /**
     * @var boolean
     *
     * @ORM\Column(name="publish_able", type="boolean")
     */
    private $publishAble = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="show_on_frontpage", type="boolean")
     */
    private $showOnFrontpage = false;


    function __construct() {
        $this->created = new \DateTime();
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
     * Set title
     *
     * @param string $title
     *
     * @return Newsitem
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
     * @return Newsitem
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
     * @return Newsitem
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
     * Set publishFrom
     *
     * @param \DateTime $publishFrom
     *
     * @return Newsitem
     */
    public function setPublishFrom($publishFrom)
    {
        $this->publishFrom = $publishFrom;

        return $this;
    }

    /**
     * Get publishFrom
     *
     * @return \DateTime
     */
    public function getPublishFrom()
    {
        return $this->publishFrom;
    }

    /**
     * Set publishUntil
     *
     * @param \DateTime $publishUntil
     *
     * @return Newsitem
     */
    public function setPublishUntil($publishUntil)
    {
        $this->publishUntil = $publishUntil;

        return $this;
    }

    /**
     * Get publishUntil
     *
     * @return \DateTime
     */
    public function getPublishUntil()
    {
        return $this->publishUntil;
    }

    /**
     * Set publishAble
     *
     * @param boolean $publishAble
     *
     * @return Newsitem
     */
    public function setPublishAble($publishAble)
    {
        $this->publishAble = $publishAble;

        return $this;
    }

    /**
     * Get publishAble
     *
     * @return boolean
     */
    public function getPublishAble()
    {
        return $this->publishAble;
    }

    /**
     * Set showOnFrontpage
     *
     * @param boolean $showOnFrontpage
     *
     * @return Newsitem
     */
    public function setShowOnFrontpage($showOnFrontpage)
    {
        $this->showOnFrontpage = $showOnFrontpage;

        return $this;
    }

    /**
     * Get showOnFrontpage
     *
     * @return boolean
     */
    public function getShowOnFrontpage()
    {
        return $this->showOnFrontpage;
    }
}

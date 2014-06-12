<?php

namespace dv\SSW2014Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Topic
 */
class Topic
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $isPrimaryTopicOf;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Topic
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
     * Set isPrimaryTopicOf
     *
     * @param string $isPrimaryTopicOf
     * @return Topic
     */
    public function setIsPrimaryTopicOf($isPrimaryTopicOf)
    {
        $this->isPrimaryTopicOf = $isPrimaryTopicOf;

        return $this;
    }

    /**
     * Get isPrimaryTopicOf
     *
     * @return string 
     */
    public function getIsPrimaryTopicOf()
    {
        return $this->isPrimaryTopicOf;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Topic
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Topic
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        // Add your code here
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        // Add your code here
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $categories;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add categories
     *
     * @param \dv\SSW2014Bundle\Entity\CategoryTopic $categories
     * @return Topic
     */
    public function addCategory(\dv\SSW2014Bundle\Entity\CategoryTopic $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \dv\SSW2014Bundle\Entity\CategoryTopic $categories
     */
    public function removeCategory(\dv\SSW2014Bundle\Entity\CategoryTopic $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }
}

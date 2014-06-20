<?php

namespace dv\SSW2014Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity
 */
class Entity
{
  public function toString()
  {
    return $this->getArticle();
  }

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $resource;

    /**
     * @var string
     */
    private $article;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $entity_categories;

    /**
     * @var \dv\SSW2014Bundle\Entity\Type
     */
    private $type;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->entity_categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set resource
     *
     * @param string $resource
     * @return Entity
     */
    public function setResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return string 
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Set article
     *
     * @param string $article
     * @return Entity
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return string 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Entity
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
     * @return Entity
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
     * Add entity_categories
     *
     * @param \dv\SSW2014Bundle\Entity\EntityCategory $entityCategories
     * @return Entity
     */
    public function addEntityCategory(\dv\SSW2014Bundle\Entity\EntityCategory $entityCategories)
    {
        $this->entity_categories[] = $entityCategories;

        return $this;
    }

    /**
     * Remove entity_categories
     *
     * @param \dv\SSW2014Bundle\Entity\EntityCategory $entityCategories
     */
    public function removeEntityCategory(\dv\SSW2014Bundle\Entity\EntityCategory $entityCategories)
    {
        $this->entity_categories->removeElement($entityCategories);
    }

    /**
     * Get entity_categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEntityCategories()
    {
        return $this->entity_categories;
    }

    /**
     * Set type
     *
     * @param \dv\SSW2014Bundle\Entity\Type $type
     * @return Entity
     */
    public function setType(\dv\SSW2014Bundle\Entity\Type $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \dv\SSW2014Bundle\Entity\Type 
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        // Add your code here
      if(!$this->getCreatedAt())
      {
        $this->created_at = new \DateTime();
      }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        // Add your code here
      $this->updated_at = new \DateTime();
    }
}

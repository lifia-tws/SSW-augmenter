<?php

namespace dv\SSW2014Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntityCategory
 */
class EntityCategory
{
  public function toJSON()
  {
    return array
    (
      'entity' => $this->getEntity()->toString(),
      'category' => $this->getCategory()->toString(),
      'rating' => $this->getRating()
    );
  }

  public function addLike()
  {
    $this->setRating($this->getRating() + 1);    
  }

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $rating;

    /**
     * @var \dv\SSW2014Bundle\Entity\Entity
     */
    private $entity;

    /**
     * @var \dv\SSW2014Bundle\Entity\Category
     */
    private $category;


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
     * Set rating
     *
     * @param integer $rating
     * @return EntityCategory
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set entity
     *
     * @param \dv\SSW2014Bundle\Entity\Entity $entity
     * @return EntityCategory
     */
    public function setEntity(\dv\SSW2014Bundle\Entity\Entity $entity = null)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return \dv\SSW2014Bundle\Entity\Entity 
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set category
     *
     * @param \dv\SSW2014Bundle\Entity\Category $category
     * @return EntityCategory
     */
    public function setCategory(\dv\SSW2014Bundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \dv\SSW2014Bundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}

<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ProductRepository")
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="prevDescription", type="text")
     */
    private $prevDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isDelete", type="boolean", nullable=true, options={"default" = false})
     */
    private $isDelete;

    /**
     * @var float
     *
     * @ORM\Column(name="cost", type="float")
     */
    private $cost;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @Assert\NotBlank()
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProductHasMedia", mappedBy="product",cascade={"persist","remove"})
     * @ORM\JoinTable(name="product_galleries")
     */
    private $productMedia;

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
     * Set title
     *
     * @param string $title
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set prevDescription
     *
     * @param string $prevDescription
     * @return Product
     */
    public function setPrevDescription($prevDescription)
    {
        $this->prevDescription = $prevDescription;

        return $this;
    }

    /**
     * Get prevDescription
     *
     * @return string 
     */
    public function getPrevDescription()
    {
        return $this->prevDescription;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     * @return Product
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete
     *
     * @return boolean 
     */
    public function getIsDelete()
    {
        return $this->isDelete;
    }

    /**
     * Set cost
     *
     * @param float $cost
     * @return Product
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return float 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Product
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productMedia = new ArrayCollection();
    }

    /**
     * Add productMedia
     *
     * @param \AppBundle\Entity\ProductHasMedia $productMedia
     * @return Product
     */
    public function addProductMedia(ProductHasMedia $productMedia)
    {
        $this->productMedia[] = $productMedia;

        return $this;
    }

    /**
     * Remove productMedia
     *
     * @param \AppBundle\Entity\ProductHasMedia $productMedia
     */
    public function removeProductMedia(ProductHasMedia $productMedia)
    {
        $this->productMedia->removeElement($productMedia);
    }

    /**
     * Get productMedia
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductMedia()
    {
        return $this->productMedia;
    }

    /**
     * Set productMedia
     *
     * @param array
     * @return Product
     */
    public function setProductMedia($media)
    {
        $this->productMedia = new ArrayCollection();
        foreach ($media as $m) {
            $m->setProduct($this);
            $this->addProductMedia($m);
        }
        return $this;
    }
}

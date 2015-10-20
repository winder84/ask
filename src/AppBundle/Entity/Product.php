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
     * @ORM\Column(name="enabled", type="boolean", nullable=true, options={"default" = true})
     */
    private $enabled = true;

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
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     **/
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="Mark", inversedBy="products")
     * @ORM\JoinColumn(name="mark_id", referencedColumnName="id")
     **/
    private $mark;

    public function __toString()
    {
        if (!empty($this->title)) {
            return $this->title;
        } else {
            return 'Создать';
        }
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productMedia = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add productMedia
     *
     * @param \AppBundle\Entity\ProductHasMedia $productMedia
     * @return Product
     */
    public function addProductMedia(\AppBundle\Entity\ProductHasMedia $productMedia)
    {
        $this->productMedia[] = $productMedia;

        return $this;
    }

    /**
     * Remove productMedia
     *
     * @param \AppBundle\Entity\ProductHasMedia $productMedia
     */
    public function removeProductMedia(\AppBundle\Entity\ProductHasMedia $productMedia)
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

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set mark
     *
     * @param \AppBundle\Entity\Mark $mark
     * @return Product
     */
    public function setMark(\AppBundle\Entity\Mark $mark = null)
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * Get mark
     *
     * @return \AppBundle\Entity\Mark 
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Product
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }
}

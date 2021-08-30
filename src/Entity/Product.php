<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     */
    private $Category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(type="integer")
     */
    private $Quantity;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ProductDesc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Image;

    /**
     * @ORM\Column(type="datetime",  nullable=true, length=255 )
     */
    private $date;

    /**
     * @ORM\Column(type="float")
     */
    private $Price;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->date = new \DateTime("now"); //done
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->Quantity;
    }

    public function setQuantity(int $Quantity): self
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    public function getProductDesc(): ?string
    {
        return $this->ProductDesc;
    }

    public function setProductDesc(string $ProductDesc): self
    {
        $this->ProductDesc = $ProductDesc;

        return $this;
    }

    public function getImage()
    {
        return $this->Image;
    }

    public function setImage($Image)
    {
        if ($Image != null) {
            $this->Image = $Image;
        }
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(float $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

}

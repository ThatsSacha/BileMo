<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'date')]
    private $dateReleased;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductImage::class, orphanRemoval: true)]
    private $productImage;

    public function __construct()
    {
        $this->productImage = new ArrayCollection();
    }

    public function jsonSerialize(): array {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'dateReleased' => $this->getDateReleased(),
            'productImage' => $this->getProductImageSerialized()
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateReleased(): ?\DateTimeInterface
    {
        return $this->dateReleased;
    }

    public function setDateReleased(\DateTimeInterface $dateReleased): self
    {
        $this->dateReleased = $dateReleased;

        return $this;
    }

    /**
     * @return Collection|ProductImage[]
     */
    public function getProductImage(): Collection
    {
        return $this->productImage;
    }

    public function getProductImageSerialized(): array
    {
        $resp = [];
        foreach($this->productImage as $productImage) {
            $resp[] = $productImage->jsonSerialize();
        }

        return $resp;
    }

    public function addProductImage(ProductImage $productImage): self
    {
        if (!$this->productImage->contains($productImage)) {
            $this->productImage[] = $productImage;
            $productImage->setProduct($this);
        }

        return $this;
    }

    public function removeProductImage(ProductImage $productImage): self
    {
        if ($this->productImage->removeElement($productImage)) {
            // set the owning side to null (unless already changed)
            if ($productImage->getProduct() === $this) {
                $productImage->setProduct(null);
            }
        }

        return $this;
    }
}

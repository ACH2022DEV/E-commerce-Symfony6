<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(type: Types::BINARY)]
    private $image = null;

    #[ORM\Column]
    private ?int $remise = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Panier::class)]
    private Collection $article_panier;

    public function __construct()
    {
        $this->article_panier = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getRemise(): ?int
    {
        return $this->remise;
    }

    public function setRemise(int $remise): static
    {
        $this->remise = $remise;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getArticlePanier(): Collection
    {
        return $this->article_panier;
    }

    public function addArticlePanier(Panier $articlePanier): static
    {
        if (!$this->article_panier->contains($articlePanier)) {
            $this->article_panier->add($articlePanier);
            $articlePanier->setArticle($this);
        }

        return $this;
    }

    public function removeArticlePanier(Panier $articlePanier): static
    {
        if ($this->article_panier->removeElement($articlePanier)) {
            // set the owning side to null (unless already changed)
            if ($articlePanier->getArticle() === $this) {
                $articlePanier->setArticle(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        return $this->Name;
    }
}

<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $firstname = null;

    #[ORM\Column(length: 128)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $paragon = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: false)]
    private ?DateTimeInterface $birth = null;

    #[ORM\Column(length: 9)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $product = null;

    #[ORM\Column]
    private ?bool $legal_a = null;

    #[ORM\Column]
    private ?bool $legal_b = null;

    #[ORM\Column]
    private ?bool $legal_c = null;

    #[ORM\Column]
    private ?bool $legal_d = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Shop $shop = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Where $from_where = null;

    #[ORM\Column(length: 255)]
    private ?string $img_receipt = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getParagon(): ?string
    {
        return $this->paragon;
    }

    public function setParagon(string $paragon): static
    {
        $this->paragon = $paragon;

        return $this;
    }

    public function getBirth(): ?DateTimeInterface
    {
        return $this->birth;
    }

    public function setBirth(DateTimeInterface $birth): static
    {
        $this->birth = $birth;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function setProduct(string $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function isLegalA(): ?bool
    {
        return $this->legal_a;
    }

    public function setLegalA(bool $legal_a): static
    {
        $this->legal_a = $legal_a;

        return $this;
    }

    public function isLegalB(): ?bool
    {
        return $this->legal_b;
    }

    public function setLegalB(bool $legal_b): static
    {
        $this->legal_b = $legal_b;

        return $this;
    }

    public function isLegalC(): ?bool
    {
        return $this->legal_c;
    }

    public function setLegalC(bool $legal_c): static
    {
        $this->legal_c = $legal_c;

        return $this;
    }

    public function isLegalD(): ?bool
    {
        return $this->legal_d;
    }

    public function setLegalD(bool $legal_d): static
    {
        $this->legal_d = $legal_d;

        return $this;
    }

    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function setShop(?Shop $shop): static
    {
        $this->shop = $shop;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getFromWhere(): ?Where
    {
        return $this->from_where;
    }

    public function setFromWhere(?Where $from_where): static
    {
        $this->from_where = $from_where;

        return $this;
    }

    public function getImgReceipt(): ?string
    {
        return $this->img_receipt;
    }

    public function setImgReceipt(string $img_receipt): static
    {
        $this->img_receipt = $img_receipt;

        return $this;
    }

}

<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DescriptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=DescriptionRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="commentaires")
     */
    private $formateurs;

    /**
     * @ORM\ManyToOne(targetEntity=FilDeDiscussion::class, inversedBy="commentaires")
     */
    private $filDeDiscussion;

    /**
     * @ORM\ManyToOne(targetEntity=FildeDiscussion::class, inversedBy="commentaire")
     */
    private $fildeDiscussion;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getFormateurs(): ?Formateur
    {
        return $this->formateurs;
    }

    public function setFormateurs(?Formateur $formateurs): self
    {
        $this->formateurs = $formateurs;

        return $this;
    }

    public function getFilDeDiscussion(): ?FilDeDiscussion
    {
        return $this->filDeDiscussion;
    }

    public function setFilDeDiscussion(?FilDeDiscussion $filDeDiscussion): self
    {
        $this->filDeDiscussion = $filDeDiscussion;

        return $this;
    }
}

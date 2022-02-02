<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $showcaseImage;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $projectDate;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $applicationUrl;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $githubUrl;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updatedAt;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    #[ORM\ManyToMany(targetEntity: CodeLanguage::class, inversedBy: 'projects')]
    private $codeLanguage;

    public function __construct()
    {
        $this->codeLanguage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getShowcaseImage(): ?string
    {
        return $this->showcaseImage;
    }

    public function setShowcaseImage(string $showcaseImage): self
    {
        $this->showcaseImage = $showcaseImage;

        return $this;
    }

    public function getProjectDate(): ?\DateTimeInterface
    {
        return $this->projectDate;
    }

    public function setProjectDate(?\DateTimeInterface $projectDate): self
    {
        $this->projectDate = $projectDate;

        return $this;
    }

    public function getApplicationUrl(): ?string
    {
        return $this->applicationUrl;
    }

    public function setApplicationUrl(?string $applicationUrl): self
    {
        $this->applicationUrl = $applicationUrl;

        return $this;
    }

    public function getGithubUrl(): ?string
    {
        return $this->githubUrl;
    }

    public function setGithubUrl(?string $githubUrl): self
    {
        $this->githubUrl = $githubUrl;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|CodeLanguage[]
     */
    public function getCodeLanguage(): Collection
    {
        return $this->codeLanguage;
    }

    public function addCodeLanguage(CodeLanguage $codeLanguage): self
    {
        if (!$this->codeLanguage->contains($codeLanguage)) {
            $this->codeLanguage[] = $codeLanguage;
        }

        return $this;
    }

    public function removeCodeLanguage(CodeLanguage $codeLanguage): self
    {
        $this->codeLanguage->removeElement($codeLanguage);

        return $this;
    }
}

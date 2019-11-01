<?php

namespace App\Entity;

use App\Entity\Traits\EntityOrderTrait;
use App\Entity\Traits\EntityTimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ThemeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Theme
{
    /* Include TimeStampable Trait */
    use EntityTimestampableTrait;
    use EntityOrderTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title = '';

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lesson", mappedBy="theme")
     */
    private $lessons;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="themes")
     */
    private $category;

    public function __construct()
    {
        $this->lessons = new ArrayCollection();
    }

    /**
     * @return null|int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}

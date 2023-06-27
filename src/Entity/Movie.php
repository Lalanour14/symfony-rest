<?php
namespace
App\Entity;

use DateTime;

class Movie
{
    private array $genre;
    public function __construct(
        private string $Title,
        private string $Resume,
        private DateTime $Date,
        private int $duration,
        private ?int $id = null

    ) {
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->Title;
    }

    /**
     * @param string $Title 
     * @return self
     */
    public function setTitle(string $Title): self
    {
        $this->Title = $Title;
        return $this;
    }

    /**
     * @return string
     */
    public function getResume(): string
    {
        return $this->Resume;
    }

    /**
     * @param string $Resume 
     * @return self
     */
    public function setResume(string $Resume): self
    {
        $this->Resume = $Resume;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->Date;
    }

    /**
     * @param DateTime $Date 
     * @return self
     */
    public function setDate(DateTime $Date): self
    {
        $this->Date = $Date;
        return $this;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration 
     * @return self
     */
    public function setLengh(int $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return 
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param  $id 
     * @return self
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return array
     */
    public function getGenre(): array
    {
        return $this->genre;
    }

    /**
     * @param array $genre 
     * @return self
     */
    public function setGenre(array $genre): self
    {
        $this->genre = $genre;
        return $this;
    }
    public function addGenre(Genre $genre)
    {
        $this->genre[] = $genre;
        return $this;

    }
}
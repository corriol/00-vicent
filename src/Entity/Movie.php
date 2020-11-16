<?php declare( strict_types=1);
require_once __DIR__ . '/../Core/Entity.php';

class Movie implements Entity
{
    const POSTER_PATH = 'posters/';
    private ?int $id = null;
    private string $title;
    private string $overview;
    // private string $release_date;
    private DateTime $releaseDate;
    private ?string $tagline;
    private string $poster;
    private int $genre_id;

    /**
     * @return int
     */
    public function getGenreId(): int
    {
        return $this->genre_id;
    }

    /**
     * @param int $genre_id
     * @return Movie
     */
    public function setGenreId(int $genre_id): Movie
    {
        $this->genre_id = $genre_id;
        return $this;
    }

    public function __set(string $name, $value){
        switch ($name) {
            case "release_date":
                $this->releaseDate = DateTime::createFromFormat("Y-m-d", $value ?? date("Y-m-d"));
                break;
        }
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Movie
     */
    public function setId(int $id): Movie
    {
        $this->id = $id;
        return $this;
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
     * @return Movie
     */
    public function setTitle(string $title): Movie
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * @param string $overview
     * @return Movie
     */
    public function setOverview(string $overview): Movie
    {
        $this->overview = $overview;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getReleaseDate(): DateTime
    {
        return $this->releaseDate;
    }

    /**
     * @param DateTime $releaseDate
     * @return Movie
     */
    public function setReleaseDate(DateTime $releaseDate): Movie
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getMovieStatus(): string
    {
        return $this->movie_status;
    }

    /**
     * @param string $movie_status
     * @return Movie
     */
    public function setMovieStatus(string $movie_status): Movie
    {
        $this->movie_status = $movie_status;
        return $this;
    }

    /**
     * @return string
     */
    public function getTagline(): ?string
    {
        return $this->tagline;
    }

    /**
     * @param string $tagline
     * @return Movie
     */
    public function setTagline(?string $tagline): Movie
    {
        $this->tagline = $tagline;
        return $this;
    }

    /**
     * @return float
     */
    public function getVoteAverage(): float
    {
        return $this->vote_average;
    }

    /**
     * @param float $vote_average
     * @return Movie
     */
    public function setVoteAverage(float $vote_average): Movie
    {
        $this->vote_average = $vote_average;
        return $this;
    }

    /**
     * @return float
     */
    public function getVoteCount(): float
    {
        return $this->vote_count;
    }

    /**
     * @param float $vote_count
     * @return Movie
     */
    public function setVoteCount(float $vote_count): Movie
    {
        $this->vote_count = $vote_count;
        return $this;
    }

    /**
     * @return string
     */
    public function getPoster(): string
    {
        return $this->poster;
    }

    /**
     * @param string $poster
     * @return Movie
     */
    public function setPoster(string $poster): Movie
    {
        $this->poster = $poster;
        return $this;
    }

    /**
     * @return mixed
     */
    public function toArray(): array
    {
        return [
            "id"=>$this->getId(),
            "tagline"=>$this->getTagline(),
            "overview"=>$this->getOverview(),
            "poster"=>$this->getPoster(),
            "release_date"=>$this->getReleaseDate()->format("Y-m-d")
        ];
    }
}
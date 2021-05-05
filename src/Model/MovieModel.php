<?php declare(strict_types=1);

namespace App\Model;

use App\Core\Entity;
use App\Core\Exception\ModelException;
use App\Core\Exception\NotFoundException;
use App\Core\Model;
use App\Entity\Genre;
use App\Entity\Movie;
use DateTime;
use Exception;
use PDO;

/**
 * Class MovieModel
 * @package App\Model
 */
class MovieModel extends Model
{
    /**
     * MovieModel constructor.
     * @param PDO $pdo
     * @param string $tableName
     * @param string $className
     */
    public function __construct(PDO $pdo, string $tableName = "movie", string $className = Movie::class)
    {
        parent::__construct($pdo, $tableName, $className);
    }


    /**
     * @param int $id
     * @return Genre
     * @throws ModelException
     */
    public function getGenre(int $id): Genre {
        $genreModel = new GenreModel($this->pdo);
        try {
            $genre = $genreModel->find($id);
        } catch (NotFoundException $e) {
            throw new ModelException($e->getMessage());
        }
        return $genre;
    }


    /**
     * Find all instances of className ordered by release date
     * @return array
     * @throws Exception
     */
    public function findAllOrderedByReleaseDate(): array {
        try {
            $stmt = $this->pdo->query("SELECT * FROM {$this->tableName} ORDER BY release_date DESC");
            return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
        }catch (Exception $exception) {
            throw new Exception("Model error". $exception->getMessage());
        }
    }

    /**
     * @param Movie $movie
     * @throws ModelException
     */
    public function saveTransaction(Movie $movie)
    {
        $fnSaveTransaction = function () use ($movie) {
            $this->save($movie);
            $genre = $this->getGenre($movie->getGenreId());
            $genre->setNumberOfMovies($genre->getNumberOfMovies() + 1);
            $genreModel = new GenreModel($this->pdo);
            $genreModel->update($genre);
        };
        $this->executeTransaction($fnSaveTransaction);
    }

    /**
     * @param int $id
     * @return Movie
     * @throws NotFoundException
     */
    public function find(int $id): Movie
    {
        return parent::find($id); // TODO: Change the autogenerated stub
    }


    public function validate(Entity $entity): array
    {
        $errors = [];
        // TODO: Implement validate() method.
        if (empty($entity->getTitle())) {
            $errors[] = "The title is mandatory";
        }
        if (empty($entity->getOverview())) {
            $errors[] = "The overview is mandatory";
        }

        $releaseDateChecker = DateTime::createFromFormat("Y-m-d", $entity->getReleaseDate());
        if (empty($releaseDateChecker)) {
            $errors[] = "The release date is mandatory";
        }
        return $errors;
    }
}
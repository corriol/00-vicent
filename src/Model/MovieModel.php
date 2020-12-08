<?php declare(strict_types=1); ?>
<?php

namespace App\Model;

use App\Core\Entity;
use App\Core\Exception\ModelException;
use App\Core\Exception\NotFoundException;
use App\Core\Model;
use App\Entity\Movie;
use Exception;
use PDO;

class MovieModel extends Model
{
    public function __construct(PDO $pdo, string $tableName = "movie", string $className = Movie::class)
    {
        parent::__construct($pdo, $tableName, $className);
    }

    public function getGenre(int $id):Entity {
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

}
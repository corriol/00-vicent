<?php declare(strict_types=1); ?>
<?php
require_once __DIR__ . '/../Core/Model.php';

class MovieModel extends Model
{
    public function __construct(PDO $pdo, string $tableName = "movie", string $className = "Movie")
    {
        parent::__construct($pdo, $tableName, $className);
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
}
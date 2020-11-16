<?php declare(strict_types=1);
require_once __DIR__ . '/../Core/Model.php';

class GenreModel extends Model
{
    public function __construct(PDO $pdo, string $tableName = "genre", string $className = "Genre")
    {
        parent::__construct($pdo, $tableName, $className);
    }
}
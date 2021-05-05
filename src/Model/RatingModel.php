<?php


namespace App\Model;


use App\Core\Entity;
use App\Core\Model;
use App\Entity\Rating;
use PDO;

class RatingModel extends Model
{
    public function __construct(PDO $pdo, string $tableName="rating", string $className=Rating::class)
    {
        parent::__construct($pdo, $tableName, $className);
    }

    /**
     * @param Entity $entity
     * @return array
     */
    public function validate(Entity $entity): array
    {
        // TODO: Implement validate() method.
    }
}
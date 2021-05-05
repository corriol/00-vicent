<?php
declare(strict_types=1);

namespace App\Model;

use App\Core\Entity;
use App\Core\Model;
use App\Entity\Partner;
use PDO;

class PartnerModel extends Model
{
    public function __construct(PDO $pdo, string $tableName = "partner", string $className = Partner::class)
    {
        parent::__construct($pdo, $tableName, $className);
    }

    public function validate(Entity $partner): array
    {
        $errors = [];
        if (empty($partner->getName()))
            $errors[] = "The name is mandatory";

        return $errors;
    }
}
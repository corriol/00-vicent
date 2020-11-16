<?php declare(strict_types=1); ?>
<?php
require_once __DIR__ . '/../Core/Model.php';

class PartnerModel extends Model
{
    public function __construct(PDO $pdo, string $tableName = "partner", string $className ="Partner")
    {
        parent::__construct($pdo, $tableName, $className);
    }
}
<?php

require_once __DIR__ . '/./Exception/NotFoundException.php';
require_once __DIR__ . '/./Exception/NotFoundException.php';
require_once __DIR__ . '/./Entity.php';

abstract class Model
{
    protected string $tableName;
    protected string $className;
    protected PDO $pdo;

    /**
     * Model constructor.
     * @param PDO $pdo
     * @param string $tableName
     * @param string $className
     */
    public function __construct(PDO $pdo, string $tableName, string $className)
    {
        $this->pdo = $pdo;
        $this->tableName = $tableName;
        $this->className = $className;
    }

    /**
     * Find all instances of className
     * @return array
     * @throws Exception
     */
    public function findAll(array $order = []): array {
        try {
            if (empty($order))
                $stmt = $this->pdo->query("SELECT * FROM {$this->tableName}");
            else {
                $orderByClause = array_map(function ($v, $k) {
                    return "$k $v";
                }, $order, array_keys($order));
                $orderBy = implode(",", $orderByClause);
                $stmt = $this->pdo->query("SELECT * FROM {$this->tableName} ORDER BY $orderBy");
                //var_dump($stmt);
            }
            return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
        }catch (Exception $exception) {
            throw new Exception("Model error". $exception->getMessage());
        }
    }

    /** Find an instance by its id
     * @param int $id
     * @return Entity
     * @throws NotFoundException
     */
    public function find(int $id): Entity {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE id = :id");
        $stmt->bindValue("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
        $e = $stmt->fetch();
        if (empty($e)) {
            throw new NotFoundException("Cannot found a {$this->className} entity with id=$id");
        }
        return $e;
    }

    /**
     * @param array $data
     * @param string $operator
     * @return array
     */
    public function findBy(array $data = [], $operator = "AND"): array
    {

        $sql = "SELECT * FROM $this->table WHERE %s";

        // data = [username => proves]

        $whereClause = implode(" $operator ",
            array_map(
                function ($k) {
                    return sprintf("%s = :%s", $k, $k);
                },
                array_keys($data) // [0 => username]
            )
        );

        //$whereClause = implode(', ', [0 => username = :username]);


        $selectSQL = sprintf($sql, $whereClause);

        $stmt = $this->pdo->prepare($selectSQL);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->className);

        $stmt->execute($data);

        return $stmt->fetchAll();
    }

    /**
     * @param array $data
     * @return Entity|null
     */
    public function findOneBy(array $data = []): ?Entity
    {

        $entities = $this->findBy($data);

        return $entities[0];
    }

    /**
     * @param string $nomTaula
     * @param array $arrayCamps
     * @return string
     */
    private function generateSQLInsert(string $nomTaula, array $arrayCamps): string
    {
        $sql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $nomTaula,
            implode(", ", array_keys($arrayCamps)), ":"
            . implode(", :", array_keys($arrayCamps)));

        return $sql;
    }

    /** Persists a entity to the database
     * @param Entity $entity
     * @return bool
     * @throws Exception
     */
    public function save(Entity $entity): bool{
        $parameters = $entity->toArray();
        try {
            $SQLInsert = $this->generateSQLInsert($this->tableName, $parameters);

            $stmt = $this->pdo->prepare($SQLInsert);
            $stmt->execute($parameters);
            if ($stmt->rowCount() !== 1) {
                return false;
            }
            // Com que en l'id no el sabem ja que és autonumèric l'obtenim amb lastInsertId() i li'l
            // passem a l'objecte que acabem d'inserir.
            $entity->setId($this->pdo->lastInsertId());
            return true;
        }
        catch (Exception $e) {
            throw new ModelException("Model error: " . $e->getMessage());
        }

    }


    /**
     * @param string $tableName
     * @param array $fields
     * @return string
     */
    private function generateSQLUpdate(string $tableName, array $fields): string
    {

        $setClause = implode(', ', array_map(
            function ($k) {
                if ($k !== 'id')
                    return sprintf("%s = :%s", $k, $k);
            },
            array_keys($fields)
        ));

        // prepare la consulta preparada SQL d'insercio en la BB.DD.
        $sql = "UPDATE %s SET %s WHERE id = :id";
        sprintf($sql, $this->tableName, $setClause);


        return $sql;
    }
    /**
     * @param Entity $entity
     * @return bool
     * @throws ModelException
     */
    public function update(Entity $entity): bool
    {
        try {
            $data = $entity->toArray();

            $updateSQL = $this->generateSQLUpdate($this->tableName, $data);

            $stmt = $this->pdo->prepare($updateSQL);

            $stmt->execute($data);

            if ($stmt->rowCount() == 1) {
                return true;
            } else
                return false;

        } catch (Exception $e) {
            throw new ModelException("Error: " . $e->getMessage());

        }// tanque catch
    }

    /**
     * @param Entity $entity
     * @return bool
     * @throws ModelException
     */
    public function delete(Entity $entity): bool
    {
        // prepare la consulta preparada SQL d'insercio en la BB.DD.
        try {


            $sql = "DELETE FROM $this->tableName WHERE  id = :id";
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindValue(':id', $entity->getId(), PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                return true;
            } else
                return false;
        } catch (Exception $exception) {
            throw new ModelException("Model exception: {$exception->getMessage()}");
        }

    }

    /**
     * @param string $sql
     * @param array $parameters
     * @return array
     * @throws ModelException
     */
    public function executeQuery(string $sql, array $parameters = []): array
    {
        try {
            $pdoStatement = $this->pdo->prepare($sql);

            if ($pdoStatement->execute($parameters) === false) {
                throw new ModelException("No se ha podido ejecutar la consulta solicitada");
            }
            return $pdoStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);

        } catch (Exception $exception) {
            throw new ModelException("Model exception: {$exception->getMessage()}");
        }
    }

    /**
     * @param callable $fnExecuteQuerys
     */
    public function executeTransaction(callable $fnExecuteQuerys) {
        try {
            $this->pdo->beginTransaction();

            $fnExecuteQuerys();

            $this->pdo->commit();

        } catch (PDOException $PDOException) {
            $this->pdo->rollBack();
        }
    }
}
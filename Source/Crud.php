<?php

namespace DBUtil\Crud;

use PDOException;
use PDOStatement;
use Exception;
use PDO;

class Crud
{
    private PDO $connectionDatabase;

    public function __construct(PDO $connection)
    {        
        $this->connectionDatabase = $connection;
        define('DATABASE_CONNECTION_STATUS', true);
    }

    public function selectData(string $select): array
    {
        $data = [];
        try {
            $result = $this->connectionDatabase->query($select);

            foreach ($result->fetchAll() as $columnName => $value) {
                $data[$columnName] = $value;
            }
        } catch (PDOException $exception) {
            CrudException::throwExceptionCrudPdo($exception);
        }

        return $data ? $data : array();
    }

    public function saveData(array $data, string $table, array $columns = []): bool
    {
        try {
            $insert = $this->prepareInsert($data, $table, $columns);
            $pdoStatement = $this->connectionDatabase->prepare($insert);
            $dataReadyToBeSaved = $this->mountBindValue($data, $pdoStatement);
            return $dataReadyToBeSaved->execute();
        } catch (PDOException $exception) {
            CrudException::throwExceptionCrudPdo($exception);
        }
    }

    private function prepareInsert(array $data, string $table, array $columns): string
    {
        $commaSeparatedColumns = '';
        if (!empty($columns)) {
            $commaSeparatedColumns = '(' . implode(', ', $columns) . ')';
        }

        $parameters = $this->returnsParametersThatWillBeFilled($data);

        return <<<SQL
            INSERT INTO {$table} {$commaSeparatedColumns}
            VALUES ({$parameters});
SQL;
    }

    private function returnsParametersThatWillBeFilled(array $data): string
    {
        $columns = [];
        $columnsThatWillBeFilled = array_keys($data);

        foreach ($columnsThatWillBeFilled as $columnName) {
            $columns[] = ':' . $columnName;
        }

        return implode(', ', $columns);
    }

    public function updateData(array $data, string $table, string $where): bool
    {
        try {
            $update = $this->prepareUpdate($data, $table, $where);
            $pdoStatement = $this->connectionDatabase->prepare($update);
            $dataReadyToBeUpdated = $this->mountBindValue($data, $pdoStatement);
            return $dataReadyToBeUpdated->execute();
        } catch (PDOException $exception) {
            CrudException::throwExceptionCrudPdo($exception);
        }
    }

    private function prepareUpdate(array $data, string $table, string $where)
    {
        $parameters = $this->returnParametersForUpdate($data);
        return  <<<SQL
            UPDATE {$table}
            SET {$parameters}
            {$where}
SQL;
    }

    private function returnParametersForUpdate(array $data): string
    {
        $setUpdate = [];
        $columnsThatWillBeFilled = array_keys($data);

        foreach ($columnsThatWillBeFilled as $column) {
            $setUpdate[] = "{$column} = :{$column}";
        }

        return implode(', ', $setUpdate);
    }

    public function deleteData(string $table, string $where): bool
    {
        if (empty($where)) {
            throw new Exception("You cannot delete the data without informing the where");
        }

        try {
            $delete = $this->prepareDelete($table, $where);
            $pdoStatement = $this->connectionDatabase->prepare($delete);
            return $pdoStatement->execute();
        } catch (PDOException $exception) {
            CrudException::throwExceptionCrudPdo($exception);
        }
    }

    private function prepareDelete(string $table, string $where): string
    {
        return <<<SQL
            DELETE FROM {$table} {$where}
SQL;
    }

    private function mountBindValue(array $data, PDOStatement $pdoStatement): PDOStatement
    {
        foreach ($data as $column => $value) {
            $pdoStatement->bindValue(":{$column}", $value);
        }

        return $pdoStatement;
    }
}
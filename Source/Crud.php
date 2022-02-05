<?php

namespace Source;

use Source\Database\ConnectionDatabase;
use PDOException;
use PDOStatement;
use PDO;

class Crud
{
    private PDO $connectionDatabase;

    public function __construct()
    {
        $this->connectionDatabase = ConnectionDatabase::openConnection();
    }

    public function selectData(string $select, array $columnsToHide = array()): array
    {
        $data = [];
        try {
            $result = $this->connectionDatabase->query($select);

            foreach ($result->fetchAll() as $index => $value) {
                $data[$index] = $value;
            }

            $data = $this->hideSelectColumns($columnsToHide, $data);
        }catch (PDOException $excecao) {
        }

        return $data ? $data : array();
    }

    private function hideSelectColumns(array $columnsToHide, array $data): array
    {
        foreach ($data as $information) {
            foreach ($columnsToHide as $columnToHide) {
                unset($information->{$columnToHide});
            }
        }

        return $data;
    }

    public function saveData(array $data, string $table, array $columns = []): void
    {
        try {
            $insert = $this->prepareInsert($data, $table, $columns);
            $pdoStatement = $this->connectionDatabase->prepare($insert);
            $dataReadyToBeSaved = $this->mountBindValue($data, $pdoStatement);
            $dataReadyToBeSaved->execute();
        } catch (PDOException $excecao) {
        }
    }

    private function prepareInsert(array $data, string $table, array $columns): string
    {
        $commaSeparatedColumns = '';
        if(!empty($columns)){
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

    public function updateData(array $data, string $table, string $where): void
    {
        try {
            $update = $this->prepareUpdate($data, $table, $where);
            $pdoStatement = $this->connectionDatabase->prepare($update);
            $dataReadyToBeUpdated = $this->mountBindValue($data, $pdoStatement);
            $dataReadyToBeUpdated->execute();

        } catch (PDOException $excecao) {
        }
    }

    private function prepareUpdate(array $data, string $table, string $where)
    {
        $parameters = $this->returnParametersForUpdate($data);
        return  <<<SQL
            UPDATE {$table}
            SET {$parameters}
            WHERE {$where}
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

    public function deleteData(array $data, string $table, string $where): bool
    {
        try {
            $delete = $this->prepareDelete($table, $where);
            $pdoStatement = $this->connectionDatabase->prepare($delete);
            $dataReadyToBeRemoved = $this->mountBindValue($data, $pdoStatement);
            return $dataReadyToBeRemoved->execute();
        } catch (PDOException $excecao) {
        }
    }

    private function prepareDelete(string $table, string $where): string
    {
        return <<<SQL
            DELETE FROM {$table} WHERE {$where}
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
<?php

namespace Source\Database;

use PDO;

class ConnectionDatabase
{
    public static function openConnection(): PDO
    {
        try {
            return new PDO(
                $_ENV['DRIVER'] . ':host=' . $_ENV['HOST'] . ';dbname=' . $_ENV['NOME_BANCO'],
                $_ENV['NOME_USUARIO'],
                $_ENV['SENHA'],
                DATABASE['configuracao']
            );
        } catch (\PDOException $exception) {
            
        }
    }
}
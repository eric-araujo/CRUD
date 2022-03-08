<?php

namespace Database;

use PDO;

class ConnectionDatabase
{
    public static function openConnection(): PDO
    {
        try {
            return new PDO(
                $_ENV['DRIVER'] . ':host=' . $_ENV['HOST'] . ';dbname=' . $_ENV['DATABASE_NAME'],
                $_ENV['USER_NAME'],
                $_ENV['PASSWORD'],
                DATABASE['settings']
            );
        } catch (\PDOException $exception) {
            die($exception->getMessage());
        }
    }
}
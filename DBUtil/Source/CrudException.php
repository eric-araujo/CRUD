<?php

namespace DBUtil\Source;

use PDOException;

class CrudException
{
    public static function throwExceptionCrudPdo(PDOException $pdoException): void
    {
        throw new PDOException($pdoException->getMessage(), $pdoException->getCode());
    }
}
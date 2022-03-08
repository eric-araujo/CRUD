<?php

namespace DBUtil;

use PDOException;

class CrudException
{
    public static function throwExceptionCrudPdo(PDOException $pdoException): void
    {
        throw new PDOException($pdoException->getMessage(), $pdoException->getCode());
    }
}
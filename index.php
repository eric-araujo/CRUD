<?php

//EXAMPLES

require_once __DIR__ . '/vendor/autoload.php';

use DBUtil\Crud\Crud;

//OPEN CONNECTION DATABASE
$connection = new PDO(
    'mysql:host=localhost;dbname=agent_atw',
    'root',
    '123456'
);

$crud = new Crud($connection);

// SELECT DATA

$selectUsers = "SELECT * FROM usuarios WHERE ic_status = true ORDER BY dt_inclusao DESC";

$results = $crud->selectData($selectUsers);

echo "<pre>";
var_dump($results);
die;

// SAVE DATA

$data = array(
    "nm_usuario" => "ElicX2",
    "nm_email" => "elic@gmail.com.br",
    "nm_senha" => "123456"
);

$table = "usuarios";

$columnsThatWillBeFilled = array(
    "nm_usuario",
    "nm_email",
    "nm_senha",
);

$saved = $crud->saveData($data, $table, $columnsThatWillBeFilled);

die($saved);

// UPDATE DATA

$data = array(
    "nm_usuario" => "Lic",
    "nm_email" => "lic@gmail.com.br",
);

$table = "usuarios";

$where = "WHERE id_usuario = 5 AND ic_status = true";

$updated = $crud->updateData($data, $table, $where);

die($updated);

// REMOVE DATA

$table = "usuarios";

$where = "WHERE id_usuario = 5 AND ic_status = true";

$deleted = $crud->deleteData($table, $where);

die($deleted);
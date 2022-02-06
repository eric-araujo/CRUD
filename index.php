<?php

require_once __DIR__ . '/vendor/autoload.php';

use Source\Crud;

$crud = new Crud();

// SELECT DATA

$objectData = $crud->selectData("SELECT * FROM usuarios WHERE ic_status = true ORDER BY dt_inclusao DESC", array("nm_senha"));

foreach ($objectData as $value){
    var_dump($value);
}
die;

// SAVE DATA

$data = array(
    "nm_usuario" => "ElicX2",
    "nm_email" => "elic@gmail.com.br",
    "nm_senha" => "123456"
);

$saved = $crud->saveData($data, 'usuarios', array_keys($data));

die($saved);

// UPDATE DATA

$updated = $crud->updateData($data, 'usuarios', 'WHERE id_usuario = 4');

die($updated);

// REMOVE DATA

$deleted = $crud->deleteData('usuarios', 'WHERE id_usuario = 4');

die($deleted);
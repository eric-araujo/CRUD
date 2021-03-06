<h1 align="center">CRUD</h1>

![Badge](https://badges.genua.fr/scrutinizer/quality/g/eric-araujo/CRUD?style=flat-square)
![Badge](https://img.shields.io/github/checks-status/eric-araujo/crud/main?style=flat-square)
![Badge](https://img.shields.io/github/license/eric-araujo/crud?style=flat-square)
![Badge](https://img.shields.io/github/repo-size/eric-araujo/crud?style=flat-square)
![Badge](https://img.shields.io/packagist/php-v/dbutil/crud?style=flat-square)
![Badge](https://img.shields.io/github/v/release/eric-araujo/crud?style=flat-square)

## π Project Description
<p>Project to create, read, update and delete data from an application.</p>

## β¬ Download Instruction
```bash
composer require dbutil/crud
```

## π Examples of use

### π¦ Instantiating Class
```php
$connection = new PDO(
    'mysql:host=localhost;dbname=agent_atw',
    'root',
    '123456'
);

$crud = new Crud($connection);
```

### π Select Data
```php
$selectUsers = "SELECT * FROM users WHERE ic_status = true ORDER BY dt_include DESC";

$results = $crud->selectData($selectUsers);
```

### πΎ Insert Data
```php
$data = array(
    "nm_user" => "ElicX2",
    "nm_email" => "elic@gmail.com.br",
    "nm_password" => "123456"
);

$table = "users";

$columnsThatWillBeFilled = array(
    "nm_user",
    "nm_email",
    "nm_password",
);

$saved = $crud->saveData($data, $table, $columnsThatWillBeFilled);
```

### π Update Data
```php
$data = array(
    "nm_user" => "Lic",
    "nm_email" => "lic@gmail.com.br",
);

$table = "users";

$where = "WHERE id_user = 4 AND ic_status = true";

$updated = $crud->updateData($data, $table, $where);
```

### ποΈDelete Data
```php
$table = "users";

$where = "WHERE id_user = 4 AND ic_status = true";

$deleted = $crud->deleteData($table, $where);
```

<h1 align="center">CRUD</h1>

![Badge](https://badges.genua.fr/scrutinizer/quality/g/eric-araujo/CRUD?style=flat-square)
![Badge](https://img.shields.io/github/repo-size/eric-araujo/crud?style=flat-square)
![Badge](https://img.shields.io/github/license/eric-araujo/crud?style=flat-square)

## 📄 Project Description
<p>Project to create, read, update and delete data from an application.</p>

## ⏬ Download Instruction
```bash
composer require dbutil/crud
```

## 📋 Examples of use

### 📦 Instantiating Class
```php
$connection = new PDO(
    'mysql:host=localhost;dbname=agent_atw',
    'root',
    '123456'
);

$crud = new Crud($connection);
```

### 🗃 Select Data
```php
$selectUsers = "SELECT * FROM users WHERE ic_status = true ORDER BY dt_include DESC";

$removeColumn = array("nm_password");

$results = $crud->selectData($selectUsers, $removeColumn);

//OR

$results = $crud->selectData($selectUsers);
```

### 💾 Insert Data
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

### 📝 Update Data
```php
$data = array(
    "nm_user" => "Lic",
    "nm_email" => "lic@gmail.com.br",
);

$table = "users";

$where = "WHERE id_user = 4 AND ic_status = true";

$updated = $crud->updateData($data, $table, $where);
```

### 🗑️Delete Data
```php
$table = "users";

$where = "WHERE id_user = 4 AND ic_status = true";

$deleted = $crud->deleteData($table, $where);
```

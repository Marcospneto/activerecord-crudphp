<?php
require '../vendor/autoload.php';

use app\database\activerecord\Delete;
use app\database\activerecord\FindAll;
use app\database\activerecord\FindBy;
use app\database\activerecord\Update;
use app\database\models\User;
use app\database\activerecord\Insert;

$user = new User;

$user->firstName = 'Hudson';
$user->lastName = 'Menezes';


//var_dump($user->execute(new FindAll(where:['id' => 6])));
var_dump($user->execute(new FindAll()));
//var_dump($user->execute(new FindAll(fields:'firstName, lastName')));


//$user->execute(new Insert());
//var_dump($user->execute(new FindBy(field:'id', value:3)));
//$user->execute(new Delete(field:'id', value:2));
//atualizar o registro com campo(field) id de valor 1.
//$user->execute(new Update(field:'id', value:1));






/*debian-sys-maint
4OkSEERl9heYzFF3*/
<?php

namespace app\database\activerecord;


use app\database\interfaces\ActiveRecordExecuteInterface;
use app\database\interfaces\ActiveRecordInterface;
use ReflectionClass;
abstract class ActiveRecord implements ActiveRecordInterface {

    protected $table = null;
    /*Porque o $attribute vai ser um array? Porque no index na hora que eu for chamar os atributos
     atraves do metodo set, vai guardar dentro de um array. Na hora que for cadastrar, atualizar la
    no banco, vai ser muito mais facil resgatar os valores para trabalhar com eles*/
    protected $attributes = [];

    /*Pegando o nome da tabela de acordo com o nome da classe*/
    public function __construct(){
        if (!$this->table){
            $reflection = new ReflectionClass($this);
            $this->table = $reflection->getShortName();
        }
    }

    public function getTable(){
        return $this->table;
    }

    public function __isset($attribute){
        return isset($this->attributes[$attribute]);
    }

    public function __set($attribute, $value){
        $this->attributes[$attribute] = $value;
    }

    public function __get($attribute){
        return $this->attributes[$attribute];
    }

    /*Caso eu queira acessar a lista de atributos, utilizo esse metodo, pois o array atributes é protected*/
    public function getAttributes() {
        return $this->attributes;
    }


    public function execute(ActiveRecordExecuteInterface $activeRecordExecuteInterface)
    {
        return $activeRecordExecuteInterface->execute($this);
    }
}
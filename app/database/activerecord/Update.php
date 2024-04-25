<?php
namespace app\database\activerecord;

use app\database\connection\Connection;
use app\database\interfaces\ActiveRecordExecuteInterface;
use app\database\interfaces\ActiveRecordInterface;
use app\database\interfaces\UpdateInterface;
use Throwable;


class Update implements ActiveRecordExecuteInterface {
    private $field;
    private $value;

public function __construct(string $field, string $value){
    $this->field = $field;
    $this->value = $value;

}

    public function execute(ActiveRecordInterface $activeRecordInterface){


                try {
                    $query = $this->createQuery($activeRecordInterface);
                    $connection = Connection::connect();

                    $attributes = array_merge($activeRecordInterface->getAttributes(), [
                        $this->field => $this->value
                    ]);


                    $prepare = $connection->prepare($query);
                    $prepare->execute($attributes);
                    return $prepare->rowCount();


                }catch (Throwable $throw){
                    throw $throw;
                }


    }

    private function createQuery(ActiveRecordInterface $activeRecordInterface){

        if(array_key_exists('id', $activeRecordInterface->getAttributes())){
            throw new \Exception("O campo id nao pode ser passado para o update");
        }

        $sql = "update {$activeRecordInterface->getTable()} set ";

        foreach ($activeRecordInterface->getAttributes() as $key => $value){

                $sql .= "{$key}=:{$key},";

        }

        //atribuindo ao $sql o mesmo valor do $sql tirando a ','
        $sql = rtrim($sql, ',');
        $sql .= " where {$this->field} = :{$this->field}";

        return $sql;
    }

}






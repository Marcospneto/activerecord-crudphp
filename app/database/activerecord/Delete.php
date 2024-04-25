<?php

namespace app\database\activerecord;

use app\database\connection\Connection;
use app\database\interfaces\ActiveRecordExecuteInterface;
use app\database\interfaces\ActiveRecordInterface;
use Throwable;
class Delete implements ActiveRecordExecuteInterface{
private $field;
private $value;

public function __construct(string $field, int $value){
    $this->field = $field;
    $this->value = $value;

}



    public function execute(ActiveRecordInterface $activeRecordInterface){

        try {
            $query = $this->createQuery($activeRecordInterface);

            $connection = Connection::connect();

            $prepare = $connection->prepare($query);


            $prepare->execute([
                $this->field => $this->value
            ]);

            return $prepare->rowCount();

        }catch (Throwable $throw){
            throw $throw;
        }


    }

    private function createQuery(ActiveRecordInterface $activeRecordInterface){
        if($activeRecordInterface->getAttributes()){
            throw new \Exception('Para deletar não precisa passar atributos');
        }
        $sql = "delete from {$activeRecordInterface->getTable()}";
        $sql .= " where {$this->field}= :{$this->field}";

        return $sql;
    }


}
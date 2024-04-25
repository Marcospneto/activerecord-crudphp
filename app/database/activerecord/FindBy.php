<?php

namespace app\database\activerecord;

use app\database\connection\Connection;
use app\database\interfaces\ActiveRecordExecuteInterface;
use app\database\interfaces\ActiveRecordInterface;
use Throwable;

class FindBy implements ActiveRecordExecuteInterface{
    private $field;
    private $value;
    private $fields;

    //O terceiro parametro é caso queira uma coluna especifica da tabela, ex first
    public function __construct(string $field, int $value, string $fields = '*'){
        $this->field = $field;
        $this->value = $value;
        $this->fields = $fields;
    }

    public function execute(ActiveRecordInterface $activeRecordInterface){

        try {
            $query = $this->createQuery($activeRecordInterface);
            $connection = Connection::connect();
            $prepare = $connection->prepare($query);
            $prepare->execute([
               $this->field => $this->value
            ]);

            return $prepare->fetch();

        }catch (Throwable $throw){
            throw $throw;
        }


    }

    public function createQuery(ActiveRecordInterface $activeRecordInterface){

        $sql = "select {$this->fields} from {$activeRecordInterface->getTable()} where {$this->field} = :{$this->field}";
        return $sql;
    }
}
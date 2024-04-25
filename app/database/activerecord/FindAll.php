<?php

namespace app\database\activerecord;

use app\database\connection\Connection;
use app\database\interfaces\ActiveRecordExecuteInterface;
use app\database\interfaces\ActiveRecordInterface;
use Throwable;
class FindAll implements ActiveRecordExecuteInterface{

    public function __construct(private array $where = [], private string $limit = '', private string $offset = '',
        private string $fields = '*'){

        }






    public function execute(ActiveRecordInterface $activeRecordInterface){
        try {
            $query = $this->createQuery($activeRecordInterface);
            $connection = Connection::connect();
            $prepare = $connection->prepare($query);
            $prepare->execute($this->where);
            return $prepare->fetchAll();

        }catch (\Throwable $throw){
            throw $throw;
        }
    }

    private function createQuery(ActiveRecordInterface $activeRecordInterface){
        /*Se o valor passado for maior que 1 lança exception (Seria o valor do parametro que estou passando no metodo findall do index)*/
        if(count($this->where) > 1){
            throw new Exception('No where só pode passar um indice');
        }


        $where = array_keys($this->where);
        $sql = "select {$this->fields} from {$activeRecordInterface->getTable()}";
        $sql .= (!$this->where) ? '' : " where {$where[0]} =:{$where[0]}";
        /*Se nao tiver nada no limit vai ser vazio, mais caso for passado um valor vai ser o $this->limit*/
        $sql .= (!$this->limit) ? '' : " limit {$this->limit}";
        $sql .= ($this->offset != '') ? " offset {$this->offset}" : "";

        return $sql;
    }




}
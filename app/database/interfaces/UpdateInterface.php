<?php

namespace app\database\interfaces;

use app\database\activerecord\ActiveRecord;

interface UpdateInterface {
    public function Update(ActiveRecordInterface $iActiveRecord );

}



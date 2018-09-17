<?php

namespace App\Lib;


abstract class RecordMapper
{
    public abstract function newRecord(array $row);
    public abstract function newRecordSet(array $rows);
}

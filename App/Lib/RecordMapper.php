<?php

namespace App\Lib;


abstract class RecordMapper
{
    /**
     * @var DB
     */
    public $db;

    public abstract function newRecord(array $row);
    public abstract function newRecordSet(array $rows);
    public abstract function searchPaginated(PaginatedRepositorySearch $paginatedSearch);

    public function getRows($stmt){
        return $this->db->getRows($stmt);
    }
}

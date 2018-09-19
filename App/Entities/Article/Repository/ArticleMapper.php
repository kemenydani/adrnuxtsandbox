<?php

namespace App\Entities\Article\Repository;

use App\Entities\Article\Repository\ArticleRecord;
use App\Lib\DB;
use App\Lib\PaginatedRepositorySearch;
use App\Lib\RecordMapper;


class ArticleMapper extends RecordMapper
{
    /**
     * @var DB
     */
    public $db;
    private $table = 'article';
    private $id = 'Id';
    private $searchService = null;

    const PAGINATION_PER_PAGE = 5;

    public function __construct()
    {
        $this->db = DB::instance();
        $this->searchService = new PaginatedRepositorySearch($this);
    }

    public function all()
    {
        $stmt = <<<STMT
            SELECT * FROM `article`
STMT;

        return $this->newRecordSet( $this->db->getRows($stmt) );
    }

    public function searchPaginated(PaginatedRepositorySearch $paginatedSearch)
    {

      $rowsPerPage = $paginatedSearch->getLimit();
      $page = $paginatedSearch->getPage();
      $descending = $paginatedSearch->isDescending();
      $direction = $descending === true ? "DESC" : "ASC";

      $order = @strlen($paginatedSearch->getOrder()) ? " ORDER BY " . $paginatedSearch->getOrder() . " " .  $direction : "";

      $start = ( $page - 1 ) * $rowsPerPage;
      $limit = " LIMIT $start, $rowsPerPage ";

      $stmt = <<<STMT
            SELECT SQL_CALC_FOUND_ROWS * FROM `article` $order $limit
STMT;

      $totalItems = $this->db->totalRowCount();
      $totalPages = @ceil($totalItems / $rowsPerPage);

      $paginatedSearch->setResult($this->db->getRows($stmt));
      $paginatedSearch->setPage((int)$page);
      $paginatedSearch->setLimit((int)$rowsPerPage);
      $paginatedSearch->setTotal((int)$this->db->totalRowCount());
      $paginatedSearch->setPages((int)$totalPages);
      $paginatedSearch->setOrder($paginatedSearch->getOrder());
      $paginatedSearch->setDescending($descending);

      return $paginatedSearch;
    }

    public function paginate($search = '', $page, $rowsPerPage, $sortBy, $descending)
    {
        $rowsPerPage = $rowsPerPage ? $rowsPerPage: self::PAGINATION_PER_PAGE;
        $page = $page ? $page : 1;
        $descending = toBool($descending);
        $direction = $descending === true ? "DESC" : "ASC";

        $order = @strlen($sortBy) ? " ORDER BY $sortBy $direction" : "";

        $start = ( $page - 1 ) * $rowsPerPage;
        $limit = " LIMIT $start, $rowsPerPage ";

        $stmt = <<<STMT
            SELECT SQL_CALC_FOUND_ROWS * FROM `article` $order $limit
STMT;

        $totalItems = $this->db->totalRowCount();
        $totalPages = @ceil($totalItems / $rowsPerPage);

        return [
            'items' => $this->db->getRows($stmt),
            'pagination' => [
                'page' => (int)$page,
                'rowsPerPage' => (int)$rowsPerPage,
                'totalPages' => (int)$totalPages,
                'totalItems' => (int)$this->db->totalRowCount(),
                'sortBy' => $sortBy,
                'descending' => $descending,
            ]
        ];
    }

    public function insertRecord(ArticleRecord $record)
    {

    }

    public function updateRecord(ArticleRecord $record)
    {

    }

    // create entity based queries...

    public function newRecord(array $row) : ArticleRecord
    {
        return new ArticleRecord($row);
    }

    public function newRecordSet(array $rows) : ArticleRecordSet
    {
        $records = [];
        foreach ($rows as $row) $records[] = $this->newRecord($row);
        return new ArticleRecordSet($records);
    }

}


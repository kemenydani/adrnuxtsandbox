<?php

namespace App\Lib;

class paginatedSearch
{
    private $keyword = null;
    private $limit = 10;
    private $start = 1;
    private $page = 1;
    private $total = 0;
    private $descending = true;
    private $order = null;
    private $pages = 0;

    /**
    * @var RecordMapper
    */
    private $repository;

    private $result = [];

    public function __construct(RecordMapper $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return bool
     */
    public function isDescending(): bool
    {
      return $this->descending;
    }

    public function execute()
    {
        $this->repository->searchPaginated($this);
    }

    /**
     * @return int
     */
    public function getPages(): int
    {
      return $this->pages;
    }

    /**
     * @param int $pages
     */
    public function setPages($pages)
    {
      if($pages) $this->pages = (int)$pages;
    }

    public function getResult(): array
    {
      return $this->result;
    }

    public function setResult(array $result)
    {
      $this->result = $result;
    }

    public function getKeyword()
    {
      return $this->keyword;
    }

    public function setKeyword($keyword)
    {
      if($keyword) $this->keyword = (string)$keyword;
    }

    public function getLimit(): int
    {
      return $this->limit;
    }

    public function setLimit($limit)
    {
      if($limit) $this->limit = (int)$limit;
    }

    public function getStart(): int
    {
      return $this->start;
    }

    public function setStart($start)
    {
      if($start) $this->start = (int)$start;
    }

    public function getPage(): int
    {
      return $this->page;
    }

    public function setPage($page)
    {
      if($page) $this->page = (int)$page;
    }

    public function getTotal(): int
    {
      return $this->total;
    }

    public function setTotal($total)
    {
      if($total) $this->total = (int)$total;
    }

    public function setDescending($descending)
    {
      if($descending) $this->descending = toBool($descending);
    }

    public function getOrder()
    {
      return $this->order;
    }

    public function setOrder($order)
    {
      if($order) $this->order = (string)$order;
    }

}

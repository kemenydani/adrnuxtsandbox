<?php

namespace App\Article\Repository;

use App\Lib\Record;

class ArticleRecord extends Record
{
    protected $Id;
    protected $Title;
    protected $Active;
    protected $RevealedAt;
    protected $CreatedAt;
}
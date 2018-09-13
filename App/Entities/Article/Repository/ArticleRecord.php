<?php

namespace App\Entities\Article\Repository;

use App\Lib\Record;

class ArticleRecord extends Record
{
    protected $Id;
    protected $Title;
    protected $Lang;
    protected $Teaser;
    protected $Content;
    protected $Active;
    protected $RevealedAt;
    protected $CreatedAt;
}

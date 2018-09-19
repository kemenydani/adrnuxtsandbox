<?php

namespace App\Entities\Reference\Repository;

use App\Lib\Record;

class ReferenceRecord extends Record
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

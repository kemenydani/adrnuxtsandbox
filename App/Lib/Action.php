<?php
namespace App\Lib;

use Slim\Container;

abstract class Action
{
    public $repository = [];
    public $responder;
}
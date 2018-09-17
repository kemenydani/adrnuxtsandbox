<?php

namespace App\Lib;

class Language
{
    static $default = 'en';
    static $available = ['en', 'hu'];
    static $_instance = null;

    private $language = 'en';

    public function __construct()
    {
        $this->setLanguageFromHttp();
    }

    public function instance()
    {
        return self::$_instance ? self::$_instance : new Language();
    }

    public function setLanguage($code)
    {
        $this->language = $code;
    }

    public function setLanguageFromHttp()
    {
        $this->setLanguage(self::extractHttpLanguage());
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getHttpLanguage()
    {
        return self::extractHttpLanguage();
    }

    public static function extractHttpLanguage()
    {
        try
        {
            $HTTP_ACCEPT_LANGUAGE = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

            $extracted = [];

            if(is_array($HTTP_ACCEPT_LANGUAGE)) foreach($HTTP_ACCEPT_LANGUAGE as $entry) $extracted[] = @substr($entry, 0, 2);

            $matched = array_intersect(array_unique($extracted), self::$available);

            return count($matched) ? $matched[0] : self::$default;
        }
        catch(\Exception $e)
        {
            return self::$default;
        }
    }

    public function __toString()
    {
        return $this->getLanguage();
    }
}

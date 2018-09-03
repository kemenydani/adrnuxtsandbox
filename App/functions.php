<?php

function array_keys_included(array $array = [], array $keyMap = [])
{
    return  array_intersect_key($array, array_flip($keyMap));
}

function array_keys_excluded(array $array  = [], array $keyMap = [])
{
    return array_diff_key($array, array_flip($keyMap));
}

function toBool($var) {
    if (!is_string($var)) return (bool) $var;
    switch (strtolower($var)) {
        case '1':
        case 'true':
        case 'on':
        case 'yes':
        case 'y':
            return true;
        default:
            return false;
    }
}
<?php

if (!function_exists("outp")) {
    function outp($o)
    {
        echo "<pre>";
        print_r($o);
        echo "</pre>";
    }
}

if (!function_exists("tick")) {
    function tick($value)
    {
        if ($value) {
            return "<i class='fa fa-check'></i>";
            return "&#x2713;";
        }
    }
}


if (!function_exists("nf")) {
    function nf($value)
    {
        return number_format($value, 2);
    }
}

if (!function_exists("starts_with")) {
    function starts_with($haystack, $needle)
    {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }
}

if (!function_exists("ends_with")) {
    function ends_with($haystack, $needle)
    {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
    }
}

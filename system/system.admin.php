<?php
function init()
{
    //init code
}
function Admin.GetConfig($option, $IsBool)
{
    $file = file("config.php", FILE_SKIP_EMPTY_LINES);
    foreach($file as $line)
    {
        $newline = preg_match('/^(\$[a-z0-9_-]* ?= ?(.)*)/i', $option);
        if($IsBool && preg_match('/(true;)$/i', $newline))
            return true;
        elseif($IsBool)
            return false;
        else
            return preg_match('/[^\\]"(.*)";$')[1];
    }
}
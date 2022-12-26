<?php

function user()
{
    if(array_key_exists('user', $_SESSION))
    {
        return $_SESSION['user'];
    }
    return null;
}
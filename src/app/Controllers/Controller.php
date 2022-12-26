<?php
namespace App\Controllers;

abstract class Controller
{
    public function redirect($uri)
    {
        header("Location: $uri");
    }
}
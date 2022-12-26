<?php
namespace App;


class View
{
    public function __construct(private string $viewPath, private array $params)
    {
        
    }
    public function render(){
        foreach($this->params as $key =>$value){
            $$key = $value;
        }
        include __DIR__."/views/".$this->viewPath.".php";
    }
    public static function make(string $viewPath, array $params = []){
        return (new self($viewPath, $params))->render();
    }
}
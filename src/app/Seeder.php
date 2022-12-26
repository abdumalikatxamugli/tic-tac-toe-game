<?php
namespace App;

class Seeder
{
    public static function seed(string $modelClass, array $data)
    {
        foreach($data as $entry){
            $modelObject = new $modelClass();
            foreach($entry as $key=>$value){
                $modelObject->{$key} = $value;
            }
            $modelObject->save();
        }        
    }
}
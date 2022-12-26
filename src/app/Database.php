<?php
namespace App;

use PDO;

class Database
{
    private static $connection;

    public static function connect($config){
        if( is_null( self::$connection ) ){
            $databaseName = $config['DATABASE_NAME'];
            $user = $config['DATABASE_USER'];
            $password = $config['DATABASE_PASSWORD'];
            self::$connection = new PDO("mysql:host=database-container;dbname=$databaseName", $user, $password);
        }
    }
    public static function getConnection(){
        return self::$connection;
    }
}
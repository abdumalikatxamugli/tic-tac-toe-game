<?php
namespace App;

use Dotenv\Dotenv;

class Migration
{
    private static function getDbConnection(){
        $config = Dotenv::createImmutable(dirname(__DIR__))->load();
        Database::connect($config);
        return Database::getConnection();
    }
    public static function createTable($tableName, $sqlScript)
    {
        $connection = self::getDbConnection();
        $stmt = $connection->query("SHOW TABLES LIKE '$tableName'");
        $count = count($stmt->fetchAll());
        if($count === 0){    
            $connection->exec($sqlScript); 
        }
    }
}
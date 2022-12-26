<?php
namespace App\Models;

use App\Database;

abstract class Model
{
    public static $connection;
    public bool $updating = true;
    public array $data = [];
    public array $updateData = [];
    public array $conditions = [];
    public static object|null $currentObject = null;
    
    public function __construct()
    {
        self::$connection = Database::getConnection();
    }
    public static function getConnection()
    {
        return self::$connection;
    }
    public static function all($order = "asc", $limit = null)
    {
        if($limit){
            $stmt = self::$connection->query("Select * from `".static::$table."` order by id $order limit $limit");
        }else{
            $stmt = self::$connection->query("Select * from `".static::$table."` order by id  $order");
        }
        $result = $stmt->fetchAll();
        return self::toObjectMany($result);
    }
    
    public function save()
    {
        if(!$this->id)
        {
            $this->insert();
        }else
        {
            $this->update();
        }
        
    }
    public function update()
    {
        if( count($this->updateData) === 0)
        {
            return;
        }
        
        $table = "`".static::$table."`";
        $bindKeys = [];
        foreach(array_keys($this->updateData) as $value)
        {
            $bindKeys[]="$value=:".$value;
        }
        $bindKeys = implode(",", $bindKeys);
        $sql = "update $table set $bindKeys where id=:id";
        $connection = self::getConnection();
        $stmt = $connection->prepare($sql);
        foreach($this->updateData as $key=>$value)
        {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(":id", $this->id);
        $stmt->execute(); 
    }
    public function insert()
    {
        $columns = implode(",",array_keys($this->data));
        $table = "`".static::$table."`";
        $bindKeys = [];
        foreach(array_keys($this->data) as $value)
        {
            $bindKeys[]=":".$value;
        }
        $bindKeys = implode(",", $bindKeys);
        $sql = "insert into $table($columns) values($bindKeys)";
        $connection = self::getConnection();
        $stmt = $connection->prepare($sql);
        foreach($this->data as $key=>$value)
        {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $id = $connection->lastInsertId();
        $this->data['id'] = $id;
    }
    public static function where($column, $value)
    {
        /**
         * Determine if we are in static context
         * And if yes, create a new object
         */
        if(!(isset($this) && $this instanceof static)){
            static::$currentObject = new static();
        }
        return static::$currentObject->applyCondition($column, $value);
    }
    public function applyCondition($column, $value)
    {
        $this->conditions[$column] = $value;
        return $this;
    }

    public function get($order = "asc")
    {
        $sql = "Select * from `".static::$table."`";
        if(count($this->conditions) > 0)
        {
            $where = [];
            
            foreach($this->conditions as $name=>$value)
            {
                $where[] = "$name = :$name";
            }
            $sql .= " where ".implode(" and ",$where);
        }
        $sql .= " order by id $order";
        $stmt = self::$connection->prepare($sql);
        if(count($this->conditions) > 0)
        {
            foreach($this->conditions as $name=>$value)
            {
                $stmt->bindValue(":".$name, $value);
            }
        }
        $stmt->execute();
        $rawResult = $stmt->fetchAll();
        return self::toObjectMany($rawResult);
    }
    public function first()
    {
        $result = $this->get();
        if($result)
        {
            return $result[0];
        }
        return null;
    }
    public function last()
    {
        $result = $this->get('desc');
        if($result)
        {
            return $result[0];
        }
        return null;
    }
    public static function toObjectMany(array $data)
    {   
        $objectResults = [];
        foreach($data as $rawArray)
        {
            $objectResults[] = self::toObject($rawArray);
        };
        return $objectResults;
    }
    public static function toObject(array $rawArray)
    {
        $object = new static();
        foreach($rawArray as $name=>$value)
        {
            $object->updating = false;
            $object->{$name} = $value;
        }
        return $object;
    }
    public function __set($name, $value)
    {
        
        if( $this->id && $this->updating)
        {
            $this->updateData[$name] = $value;
            $this->data[$name] = $value;
        }else
        {
            $this->updating = true;
            $this->data[$name] = $value;
        }
       
    }
    public function __get($name)
    {
        if( array_key_exists($name, $this->data) )
        {
            if( isset($this->data[$name]) )
            {
                return $this->data[$name];
            }
            elseif( isset( $this->updateData[$name] ) )
            {
                return $this->updateData[$name];
            }
        }
        return null;
    }
}
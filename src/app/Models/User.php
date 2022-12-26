<?php
namespace App\Models;

class User extends Model
{
    public static $table = "users";
    
    public function authenticate()
    {
        $_SESSION['user_id'] = $this->id;
    }
    public static function logout()
    {
        unset($_SESSION['user_id']);
    }
    public static function attemptLogin($username, $password):bool
    {
        $user = self::where('username', $username)
                    ->where('password', $password)
                    ->first();
        if( $user )
        {
            $user->authenticate();
            return true;
        }
        return false;
    }
    public function incrementLevel()
    {
        $this->level = $this->level + 1;
        
        if( (int) $this->level === 2 )
        {
            $this->can_upload_profile_photo = 1;
        }
        if( (int) $this->level === 3 )
        {
            $this->can_create_own_group = 1;
        }
        $this->save();
    }
    public function decrementLevel()
    {
        if($this->level > 1)
        {
            $this->level = $this->level - 1;
            $this->save();
        }
    }
    public function hasGroup()
    {
        return count( Group::where('created_by', $this->id)->get() )> 0;
    }
    public function groups()
    {
        return UserGroup::where('user_id', $this->id)->get();
    }
}
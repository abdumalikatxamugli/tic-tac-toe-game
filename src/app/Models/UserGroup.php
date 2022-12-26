<?php

namespace App\Models;

class UserGroup extends Model
{
    protected static $table = "user_groups";
    public static function link($user_id, $group_id)
    {
        $userGroup = new self();
        $userGroup->user_id = $user_id;
        $userGroup->group_id = $group_id;
        $userGroup->save();
    }
    public function group()
    {
        return Group::where('id', $this->group_id)->first();
    }
    public function user()
    {
        return User::where('id', $this->user_id)->first();
    }
}
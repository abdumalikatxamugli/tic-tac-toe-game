<?php
namespace App\Models;

class Group extends Model
{
    protected static $table = "groups";

    public static function top()
    {
        $groups = self::all();
        foreach($groups as $group)
        {
            $group->level = $group->calcLevel();
        }
        usort($groups, function ($a, $b) {
            return  (int)$b->level - (int)$a->level;
        });
        return $groups;
    }
    public function calcLevel()
    {
        $user_links  = UserGroup::where('group_id', $this->id)->get();
        $level = 0;
        foreach($user_links as $link)
        {
            $level += $link->user()->level;
        }
        $childGroups = self::where('parent_group_id', $this->id)->get();
        foreach($childGroups as $group)
        {
            $level += $group->calcLevel();
        }
        return $level;
    }
}
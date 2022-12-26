<?php
namespace App\Models;

class GameState extends Model
{
    protected static $table = "game_states";
    const DEFAULT_STATE = [
        [null, null, null],
        [null, null, null],
        [null, null, null]
    ];
    public static function saveState($game_id, $gameState)
    {
        $state = new self();
        $state->game_id = $game_id;
        $state->state = json_encode($gameState);
        $state->save();
    }
    public static function getStates($stateEntries)
    {
        $states = [];
        foreach($stateEntries as $entry)
        {
            $states[] = json_decode( $entry->state, true);
        }
        return $states;
    }
}
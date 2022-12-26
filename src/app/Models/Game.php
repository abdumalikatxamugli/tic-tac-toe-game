<?php
namespace App\Models;

class Game extends Model
{
    protected static $table = 'games';
    const X = 'x';
    const O = 'o';

    public static function getValidMove($gameState, $side)
    {
        $freeCells = [];
        foreach($gameState as $rowIndex=>$row){
            foreach($row as $colIndex=>$column)
            {
                if(is_null($column))
                {
                    $freeCells[] = ['rowIndex'=>$rowIndex, 'colIndex'=>$colIndex];
                }
            }
        }
        if( count( $freeCells ) > 0 )
        {
            /**
             * pick random position
             */
            $cellPosition = $freeCells[ rand( 0, count($freeCells)-1 ) ];
            $gameState[$cellPosition['rowIndex']][$cellPosition['colIndex']] = $side;
            return $gameState;
        }
        return null;
    }
    public static function isWinningState($state)
    {
        /**
         * vertical win check
         */
        foreach($state as $rowIndex=>$row){
            $isWinPosition = true;
            foreach($row as $colIndex=>$column)
            {
                if($colIndex === 0)
                {
                    $side = $column;
                }
                if(is_null($column))
                {
                    $isWinPosition = false;
                    break;
                }
                if($column !== $side)
                {
                    $isWinPosition = false;
                    break;
                }
            }
            if($isWinPosition)
            {
                return $side;
            }
        }
        /**
         * horizontal check
         */
        $colIndex = 0;
        $rowIndex = 0;
        while($colIndex < 3)
        {
            $rowIndex = 0;
            $isWinPosition = true;
            while( $rowIndex < 3 )
            {
                if($rowIndex === 0)
                {
                    $side = $state[$rowIndex][$colIndex];
                }
                if(is_null($state[$rowIndex][$colIndex]))
                {
                    $isWinPosition = false;
                    break;
                }
                if($state[$rowIndex][$colIndex] !== $side)
                {
                    $isWinPosition = false;
                    break;
                }
                $rowIndex = $rowIndex + 1;
            }
            if($isWinPosition)
            {
                return $side;
            }
            $colIndex = $colIndex + 1;
        }
        /**
         * diagonal check:
         * there are only 2 variations
         */
        
        /**
         * 1st variation
         */ 
        if( !is_null($state[0][0]) && ($state[0][0] === $state[1][1]) && ($state[1][1] === $state[2][2]) )
        {
            return $state[0][0];
        }  
        
        /**
         * 2nd variation
         */ 
        if( !is_null($state[0][2]) && ($state[0][2] === $state[1][1]) && ($state[1][1] === $state[2][0]) )
        {
            return $state[0][2];
        }  
        return null;
    }
}
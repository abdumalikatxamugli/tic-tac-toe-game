<?php
namespace App\Controllers;

use App\Models\Game;
use App\Models\GameState;
use App\View;
use App\Models\User;
use App\Models\Group;

class HomeController extends Controller
{
    public function home()
    {
        $data['user'] = user();
        $data['group_links'] = user()->groups();
        $data['games'] = Game::where('user_id', user()->id)->get();
        return View::make('home', $data);
    }
    public function profile()
    {
        $data['user'] = User::where('id', $_GET['user_id'])->first();;
        $data['group_links'] = user()->groups();
        $data['games'] = Game::where('user_id', $_GET['user_id'])->get();
        return View::make('profile', $data);
    }
    public function topPlayers()
    {
        $data['top_players'] = User::all('desc', 10);
        return View::make('top_players', $data);
    }
    public function topGroups()
    {
        $data['top_groups'] = Group::top();
        return View::make('top_groups', $data);
    }
    public function childGroups()
    {
        $data['groups'] = Group::where('parent_group_id', $_GET['parent_group_id'])->get();;
        return View::make('child_groups', $data);
    }
    public function gameplay()
    {
        if( !isset($_GET['game_id']) ){
            $game = new Game();
            $game->user_id = user()->id;
            if(rand(0, 10) < 5)
            {
                $game->computer_side = 'x';
                $game->player_side = 'o';
            }else{
                $game->computer_side = 'o';
                $game->player_side = 'x';
            }
            $game->save();
            $data['game'] = $game;
            header("Location: /gameplay?game_id=$game->id");
        }else{
            $data['game'] = Game::where('id', $_GET['game_id'])->first();
            $lastState = GameState::where('game_id', $data['game']->id)->last();
            if( is_null($lastState) )
            {
                GameState::saveState($data['game']->id, GameState::DEFAULT_STATE);
                $data['state'] = GameState::DEFAULT_STATE;
            }else{
                $data['state'] = json_decode($lastState->state, true);
            }
        }
        return View::make('gameplay', $data);
    }
    public function gamewatch()
    {
        $data['game'] = Game::where('id', $_GET['game_id'])->first();
        $data['states'] = GameState::getStates( GameState::where('game_id', $_GET['game_id'])->get() );
        return View::make('gamewatch', $data);
    }
    /**
     * I know I should not echo the response json here.
     * But I have only one ajax request in this project.
     * So try to have some understanding.
     */
    public function makemove()
    {
        
        $gameState = json_decode(file_get_contents("php://input"), true)['state'];
        $side = json_decode(file_get_contents("php://input"), true)['side'];
        $game_id = json_decode(file_get_contents("php://input"), true)['game_id'];
        GameState::saveState($game_id, $gameState);
        /**
         * Check if the player won
         */
        $hasPlayerWon = Game::isWinningState($gameState);
        if( $hasPlayerWon )
        {
            user()->incrementLevel();
            echo json_encode(['nextState'=>$gameState, 'win'=>'player']);
            return;
        }
        $nextState = Game::getValidMove($gameState, $side);
        /**
         * The game over, declare draw
         */
        if(is_null($nextState))
        {
            echo json_encode(['nextState'=>$gameState, 'win'=>'draw']);
            return;
        }
        /**
         * Okay here we know that the next move exists
         * and the game is not over yet
         * so let's write it to database
         */
        GameState::saveState($game_id, $nextState);
        /**
         * Check if computer won with this move
         */
        $hasComputerWon = Game::isWinningState( $nextState );
        if( $hasComputerWon )
        {
            user()->decrementLevel();
            echo json_encode(['nextState'=>$nextState, 'win'=>'computer']);
            return;
        }
        /**
         * Here we know that nobody won yet.
         * So just move on.
         */
         echo json_encode(['nextState'=>$nextState, 'win'=>'none']);
    }
}
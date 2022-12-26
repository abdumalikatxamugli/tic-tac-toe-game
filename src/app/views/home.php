<html>
    <head>
        <link href="/bootstrap.min.css" rel="stylesheet"/>
    </head>
    <body style="background-color: whitesmoke">
        <div class="container">
            <div class="row bg-white p-4 ">
                <div class="col-md-4">
                    <div>
                        <?php if($user->profile_photo_path):?>
                            <div class="p-3">
                                <img src="/storage/<?php echo $user->profile_photo_path?>" alt="profile image" style="width: 100px; height:100px; border-radius: 50%;object-fit:cover">
                            </div>
                        <?php endif;?>
                        <ul>
                            <?php if($user->can_upload_profile_photo == 1):?>
                            <li>
                                <a href="/photoUpload">Profile photo</a>                        
                            </li>
                            <?php endif?>

                            <?php if($user->can_create_own_group == 1 && !$user->hasGroup()):?>
                            <li>
                                <a href="/createGroup">Create Group</a>                        
                            </li>
                            <?php endif?>
                        </ul>
                    </div>
                    
                    <div>
                        Usefull links:
                        <ul>
                            <li>
                                <a href="/topPlayers">Top Players</a>
                            </li>
                            <li>
                                <a href="/topGroups">Top Groups</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <a href="/logout">Logout</a>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="w-25 pb-3">
                        
                        <span style="font-size: 14px; font-style: italic">
                            Name: <?php echo $user->name?>
                            <br>
                            Username: <?php echo $user->username?>
                            <br>
                            Level: <?php echo $user->level?>
                        </span>
                    </div>
                    <div>
                        <ul>
                            <li>
                                <a href="/gameplay">Play</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <span>Watch Games:</span>
                        <ul>
                            <?php foreach($games as $game):?>
                                <li>
                                    <a href="/gamewatch?game_id=<?php echo $game->id?>">GAME #<?php echo $game->id?></a>
                                </li>
                            <?php endforeach?>
                        </ul>
                    </div>
                    <div>
                        <span>Groups where you are involved:</span>
                        <ul>
                            <?php foreach($group_links as $group_link):?>
                            <li><?php echo $group_link->group()->name?></li>
                            <?php endforeach?>
                        </ul>
                    </div>
                </div>
            </div>            
        </div>
    </body>
</html>
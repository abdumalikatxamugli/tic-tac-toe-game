<html>
    <head>
        <link href="/bootstrap.min.css" rel="stylesheet"/>
    </head>
    <body style="background-color: whitesmoke">
        <div class="container">
            <div class="d-flex flex-column justify-content-center align-items-center h-100">
                <div class="w-25 pb-3">
                    <?php if($user->profile_photo_path):?>
                        <div class="text-center p-3">
                            <img src="/storage/<?php echo $user->profile_photo_path?>" alt="profile image" style="width: 100px; height:100px; border-radius: 50%;object-fit:cover">
                        </div>
                    <?php endif;?>
                    <span style="font-size: 14px; font-style: italic">
                        Name: <?php echo $user->name?>
                        <br>
                        Username: <?php echo $user->username?>
                        <br>
                        Level: <?php echo $user->level?>
                    </span>
                </div>
                <div class="w-25 border p-4 bg-white">
                    <span>Groups involved:</span>
                    <ul>
                        <?php foreach($group_links as $group_link):?>
                        <li><?php echo $group_link->group()->name?></li>
                        <?php endforeach?>
                    </ul>
                </div>
                <div class="w-25 border p-4 bg-white">
                    <span>Games:</span>
                    <ul>
                        <?php foreach($games as $game):?>
                            <li>
                                <a href="/gamewatch?game_id=<?php echo $game->id?>">GAME #<?php echo $game->id?></a>
                            </li>
                        <?php endforeach?>
                    </ul>
                </div>
            </div>            
        </div>
    </body>
</html>
<html>
    <head>
        <link href="/bootstrap.min.css" rel="stylesheet"/>
    </head>
    <body style="background-color: whitesmoke">
        <div class="container">
            <div class="d-flex flex-column justify-content-center align-items-center h-100">
                <div class="w-25 border p-4 bg-white">
                    <span>Top players:</span>
                    <ol>
                        <?php foreach($top_players as $player):?>
                            <li>
                                <a href="/profile?user_id=<?php echo $player->id?>">
                                    <?php echo $player->name?>
                                </a>
                            </li>
                        <?php endforeach?>
                    </ol>
                </div>
            </div>            
        </div>
    </body>
</html>
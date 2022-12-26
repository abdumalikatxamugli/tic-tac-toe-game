<html>
    <head>
        <link href="/bootstrap.min.css" rel="stylesheet"/>
    </head>
    <body style="background-color: whitesmoke">
        <div class="container">
            <div class="d-flex flex-column justify-content-center align-items-center h-100">
                <div class="w-25 border p-4 bg-white">
                    <span>Top groups:</span>
                    <ol>
                        <?php foreach($top_groups as $group):?>
                            <li>
                                <a href="/childGroups?parent_group_id=<?php echo $group->id?>">
                                    <?php echo $group->name?> - <?php echo $group->level?>
                                </a>
                            </li>
                        <?php endforeach?>
                    </ol>
                </div>
            </div>            
        </div>
    </body>
</html>
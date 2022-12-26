<?php

use App\Migration;
use App\Models\Group;
use App\Models\User;
use App\Seeder;
use Faker\Factory;

require __DIR__."/vendor/autoload.php";

/**
 * Migrations
 */

/**
 * Users table
 */
$tableName = "users";
$sql = "Create table users(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                            username VARCHAR(255) UNIQUE, 
                            password VARCHAR(255),
                            name VARCHAR(255),
                            level INT DEFAULT 1,
                            profile_photo_path VARCHAR(255),
                            can_upload_profile_photo INT DEFAULT 0,
                            can_create_own_group INT DEFAULT 0
                           )";

Migration::createTable($tableName, $sql);


/**
 * Games table
 */

$tableName = "games";
$sql = "Create table games(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                            user_id INT,
                            player_side VARCHAR(16),
                            computer_side VARCHAR(16),
                            FOREIGN KEY (user_id) REFERENCES users(ID) 
                           )";

Migration::createTable($tableName, $sql);



/**
 * Game states table
 */

$tableName = "game_states";
$sql = "Create table game_states(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                            game_id INT,
                            state TEXT,
                            FOREIGN KEY (game_id) REFERENCES games(ID) 
                           )";

Migration::createTable($tableName, $sql);


/**
 * Groups table
 */

$tableName = "groups";
$sql = "Create table `groups`(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                            name VARCHAR(255) UNIQUE,
                            created_by INT,
                            parent_group_id INT NULL,
                            FOREIGN KEY (created_by) REFERENCES users(ID),
                            FOREIGN KEY (parent_group_id) REFERENCES `groups`(ID)
                           )";

Migration::createTable($tableName, $sql);



/**
 * Groups to user connection
 */

$tableName = "user_groups";
$sql = "Create table user_groups(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                            user_id INT,
                            group_id INT,
                            FOREIGN KEY (user_id) REFERENCES users(ID),
                            FOREIGN KEY (user_id) REFERENCES `groups`(ID) 
                           )";

Migration::createTable($tableName, $sql);






/**
 * Seeders
 */
$faker = Factory::create();

/**
 * Users seeder
 */
$data = [];
$i = 0;
while( $i < 10 )
{
    $userData['name'] = $faker->name();
    $userData['username'] = $faker->userName();
    $userData['password'] =  md5($faker->password());
    $userData['level'] = 3;
    $data[] = $userData;
    $i++;
}

Seeder::seed(User::class, $data);


/**
 * Groups seeder
 */

 $data = [];
 $i = 0;
 while( $i < 10 )
 {
    $groupData['name'] = $faker->city();
    $groupData['created_by'] = rand(1, 10);
    $data[] = $groupData;
    $i++;
 }

 Seeder::seed(Group::class, $data);
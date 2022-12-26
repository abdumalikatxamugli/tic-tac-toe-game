# TIC TAC TOE game

Setup instuctions:
1. Clone the project

``` git clone {project-url}```

2. Make sure you have mysql server not running on your mache.ine, and your port 80 is free. Then go to docker folder, make sure to change to MYSQL_ROOT_PASSWORD in docker-compose.yml if you want to use another password for the database. It is set to ```root``` in docker-compose.yml. Then run compose up with build flag on

``` cd docker```

``` docker compose up -d --build```

3. Connect to mysql server of docker with whatever mysql client you prefer and create a database. (I personally recommend Dbeaver)

4. Run bash in php-container in interactive mode.

``` docker exec -it php-container bash```

5. Install packages inside your php-container

``` composer install ```

6. Copy .env.example file to .env and fill in the database credentials

7. Run script to migrate and seed the tables

```cd src && php setup_db.php```

8. Now open address http://localhost:8000 on your browser. You should see the login page show up in your screen. Have fun.

P.S. I know that the bot you are playing against is probably the dumbest ever player ever existed, I have some thoughts about how to make it smarter like by making decision tree and making it choose the shortest path to victory, I try to implement it when I manage find free time to work on it again.
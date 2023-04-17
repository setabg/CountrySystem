nginx-php7.4-mysql8-node-docker-network
Fast lightweight Docker network using PHP MySQL Nginx and Node

Watch setup video
Create a Symfony 5 project with Docker PHP MySQL Nginx and Node - Part1 (2021) - https://www.youtube.com/watch?v=ITOnpzkzlYM
Create a Symfony 5 project with Docker PHP MySQL Nginx and Node - Part2 (2021) - https://www.youtube.com/watch?v=tcU5XwlEeRU

Enter containers
Enter the PHP container (to use bin/console, composer)
docker-compose exec php74-service bash
Enter the NODE container (to use yarn)
docker-compose exec node-service bash
Note: When done you can leave the container by typing exit

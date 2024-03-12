# LaravelVue
Test using Laravel and VueJs 3

To run the container, enter in the folder /back and apply the command docker-compose up --build, after the containers are running, enter in the Database´s container( run it by the root user: MYSQL -u root password) and create an user named "laravel" and password "laravel" (CREATE USER laravel@mysql_local IDENTIFIED BY 'password';) and grant permissions to it(GRANT ALL PRIVILEGES ON mysql_local.* TO 'laravel'@'mysql_local' WITH GRANT OPTION;), after enter in the Laravel´s container and apply 4 commands: composer install, php artisan key:generate, php artisan migrate and php artisan db:seed(this will generate the first user named "Admin" and password "123456".

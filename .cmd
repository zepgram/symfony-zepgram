#sql
CREATE USER 'symfony'@'%' IDENTIFIED BY 'zepgram';
CREATE USER 'symfony'@'localhost' IDENTIFIED BY 'zepgram';
GRANT ALL PRIVILEGES ON * . * TO 'symfony'@'localhost';
GRANT ALL PRIVILEGES ON * . * TO 'symfony'@'%';

#php
sudo apt install php7.2-apcu

#composer
composer require encore

#node
yarn install

#migration
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate

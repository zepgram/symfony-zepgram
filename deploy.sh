composer install --no-dev
bin/console doctrine:migrations:migrate
bin/console cache:clear --env=prod
yarn encore production

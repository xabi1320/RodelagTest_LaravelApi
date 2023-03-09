# Rodelag Test API

This API is contracted in Laravel with its framework lumen. It is inside an environment with Docker. and was made for an entrance test to a Backend developer vacancy. This API is integrated with the API Graphql of Rick & Morty https://rickandmortyapi.com/graphql
 

## Previous steps

- Run docker with this command `docker-compose up -d`
- With CLI go to directory `src` and run migrations with this command `docker-compose exec php php /var/www/html/artisan migrate`
- Go to `localhost:8888/v1/episode/list`

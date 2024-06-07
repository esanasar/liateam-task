# Laravel Project with MongoDB and Redis

This is a Laravel project template configured with MongoDB as the database and Redis as the cache driver. It also includes JWT-based authentication for API endpoints and implements CRUD operations for managing products and orders.

## Getting Started

Follow these instructions to get the project up and running on your local machine for development and testing purposes.

## installing
1. Clone the repository to your local machine using this command:
``` 
git clone https://github.com/esanasar/liateam-task.git 
```
2. copy ".env.example" file and change its name to ".env"
3. run the docker
```
docker compose up --build -d
```
4. open mongodb container using this command :
```
docker compose exec db mongosh
```
5. inside its terminal type this command :
```
rs.initiate()
```
now, the project is ready and you have access to it's apis
well done!
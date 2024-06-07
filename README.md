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
6. enter this command to open laravel container:
```
docker compose exec app sh
```
insided this container you can run tests using this command :
```
php artisan test
```

## using apis
here i will show you some examples how to use apis:

### user register

in postman enter this url with the "post" method :

```http://localhost:8000/api/register```

in body of the post request choose "form-data" and enter these data for the parameters of the request:

```json
{
   "name" : "test",
   "email" : "test@gmail.com",
   "password" : "123456"
}
```

for Create order and product apis you have to set authorization jwt access token in the header as below :

### Creating an Order
To create an order, you can use the following API endpoint with the "post" method:
```http://localhost:8000/api/orders```

POST /api/orders


#### Request Header
```json
"Authorization" => "Bearer <JWT_token>"
```
#### Request Body

The request body should contain a JSON object with the following structure:

```json
{
    "products": [
        {
            "id": 66633ab3328ea2540205afa5,
            "count": 3
        },
        {
            "id": 66633ab3328ea2540205afa6,
            "count": 2
        }
    ]
}
```

### Creating a product
To create an product, you can use the following API endpoint with the "post" method:
```http://localhost:8000/api/products```

POST /api/products


#### Request Header
```json
"Authorization" => "Bearer <JWT_token>"
```

#### Request Body

The request body should contain "form-data" with the following parameters:

```json
{
    "name" : "test",
    "price" : 10000, 
    "inventory" : 8
}
```




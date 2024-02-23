
# Simple Microservices Communication

Composed of users and notifications service, when a user is created an event is generated and is passed to notifications service using rabbitmq to log the users info in notifications.log file

## Installation

Start Up Containers

```bash
  docker-compose up --build -d
  docker-compose exec users composer install
  docker-compose exec users php bin/console doctrine:migrations:migrate
  docker-compose exec notifications composer install
```

## API Reference

#### Create a user

```http
  POST http://localhost:8100/users
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `email` | `string` | **Required**|
| `firstName` | `string` | **Required**|
| `lastName` | `string` | **Required**|

#### Sample Request

```
curl --location 'http://localhost:8100/users' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
    "email": "sample@nextbasket.com",
    "firstName": "Ben",
    "lastName": "Vhizao"
}'
```

#### Sample Response

```
Status Code: 201

{
    "status": "created",
    "email": "sample@nextbasket.com",
    "firstName": "Ben",
    "lastName": "Vhizao"
}
```


## Running Tests

Running PHPUnit Tests

```bash
  docker-compose exec users ./vendor/bin/phpunit tests
  docker-compose exec notifications ./vendor/bin/phpunit tests
```

## End to End Operation

1. Create new POST request same as above to endpoint `/users`
2. To start consuming messages from the queues run this command:
```
docker-compose exec notifications php bin/console messenger:consume async_priority_high -vv
```
3. Check the notifications.log inside notifications-service/var/log you should see something like this

```
notification.INFO: UserCreatedEvent received {"email":"sample@nextbasket.com","firstName":"Ben","lastName":"Vhizao"} []
```

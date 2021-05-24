# Casafy

## Requirements for this project:

- Docker
- Docker-compose

**Build and startup the docker containers.**

```
docker-compose up -d --build
```

**After finish docker operations, you should run database operations.**

```
./scripts.sh
```

**Access the URL.**

http://127.0.0.1:8002/api


#### Endpoints available

**Users**

	GET api/users
	POST api/users
	GET api/users/{id}
	PUT api/users/{id}
	DELETE api/users/{id}
	GET api/users/{id}/properties

**Properties**

    GET api/properties
    POST api/properties
    GET api/properties/{id}
    PUT api/properties/{id}
    DELETE api/properties/{id}
    PATCH api/properties/{id}/purchased

## **Data formats**

#### Add or update an user
```
{
	"name": "My name",
	"email": "myname@gmail.com"
}
```

#### Add or update a property
```
{
	"address": "My address",
	"bedrooms": 4,
	"bathrooms": 1,
	"total_area": 200,
	"value": 1800.00,
	"discount": 20,
	"owner_id": 2
}
```

### Tests

```
docker exec -it casafy-app php artisan test
```
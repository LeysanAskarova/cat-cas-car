# Symfony CAT_CAS_CAR application

## Local deployment

### Using docker-compose

Preferred way, allows to instanly view code changes in browser

```
docker-commpose up
```

To shutdown:
```
docker-compose down
```

Open `localhost:8000`

### From Docker image

```
docker build . --tag cat-cas-car 
docker run -p 8000:8000 -d cat-cas-car
```

To stop:

```
docker stop cat-cas-car
```

Open `localhost:8000`

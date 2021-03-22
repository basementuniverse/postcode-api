# Basic Postcode API

Start the API:
```
docker-compose up --build
```
Or:
```
make build
make up
```

Then access the API at `localhost:8080`.
The database can be accessed from the host at `localhost:3307`, or by running:
```
docker-compose exec mysql bash
$ mysql -uroot -psecret
```

To run migrations:
```
make migrate
```

To download and import postcodes (not functional yet):
```
make import-postcodes
```

## API endpoints

To return a list of postcodes based on partial string match:
```
GET /postcodes/{partial}
```

To return a list of postcodes based on location proximity:
```
GET /postcodes/{lat}/{long}[/{range}]
```

Lat/long are float values, range is a float measured in km (defaults to 5km)

## Todo

- [ ] Finish import command
- [ ] Finish `PostcodeRepository->findByLocation()` (narrow phase, will filter by Euclidean distance to specified lat/long)
- [ ] Unit test PostcodeRepository 
- [ ] E2E testing with test fixtures

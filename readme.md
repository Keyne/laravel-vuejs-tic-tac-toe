# PHP Full Stack Engineer project
___

## The challenge

Create and integrate a tic tac toe API within a pre-built vuejs front-end 

#### Tic Tac Toe functionality
The functional requirements:
  - Be able to create and delete matches
  - Be able to join a match
  - Be able to make moves and alter the game board
  - Identify the winner

## Running the application
[Install docker and docker-compose](https://docs.docker.com/compose/install/)

Then run
```bash
./setup
```
This will take a few minutes. It will create the containers and setup them for use.

When finished, run the application with:
```bash
./up
```

And the application will be running in [http://localhost:8080](http://localhost:8080).

**Note:** If the port 8080 is already in use, change the configuration in the docker-compose.yml file. For example, to use the port 9090 instead:
```yaml
ports:
  - 9090:80
``` 

## <a name="psr"></a>PSR-2
The application is PSR-2 compliant and comes with an included Code sniffer
```shell
$ vendor/bin/phpcs ./app
$ vendor/bin/phpcs ./tests
```

## <a name="tests"></a>Test coverage (PHPUnit)
Open on your browser the following file to view the test coverage results: `tests/build/coverage/index.html`.
 
```shell
$ ./phpunit
```
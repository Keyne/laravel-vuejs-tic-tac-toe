# PHP Full Stack Engineer project
___

## The challenge

We want to play Tic Tac Toe. As we are a remote friendly company, we want to be able to play without distance being a challenge to find the best players in the world ;)

We need your help to make this app work, as we have just coded the front end.

#### Tic Tac Toe functionality
The functional requirements that we want for our tic tac toe application are:
  - Be able to create and delete matches
  - Be able to join a match
  - Be able to make moves and alter the game board
  - Identify the winner

#### What does this repository contains
Here we have a Laravel web application that implements all the front-end logic needed for the game, and a simple controller with mocked responses to display the contract we want to have.

#### What do you have to code
 - All the backend logic necessary to make the game work.
 - All the tests that you believe necessary to assert the correctness of your code. You don't have to test the front end implementation. 

#### Skills we are going to assert
 - General coding skills: 
   - How do you name your methods, classes and variables
   - How do you take care of performance
   - How readable your code is
   - How simple are the algorithms used
   - How do you structure your code
 - Modeling skills
   - Which model you create to solve the problem
   - Which concepts it complies with
 - Problem solving skills
   - How do you solve logical problems
 - PHP knowledge
   - How you use the tools the language provides
   - How well you know the best practices of the language
 - Web development skills
   - Which patterns do you put in practice
   - Which concepts do you use and how
   - Which best practices you use
 - Testing skills
   - Which kind of tests you use
 - Basic git skills
   - How do you organize the changes
 
 #### Skills we are NOT going to assert
 - Page load performance optimization
 - Look and feel of the application
 - Extra features we did not ask for our application


#### Deadline and other conditions
 - For your organization, the exercise is supposed to take between 2 and 4 hours
 - You have four days to send us the solution. 
 - You must fork this repo and send us the link of that fork with the solution
 - The code must be in english.

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
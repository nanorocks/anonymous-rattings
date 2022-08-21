# project-rating-service

[![🚀 Deploy rating service to cPanel](https://github.com/nanorocks/project-rating-service/actions/workflows/cPanel.yml/badge.svg?branch=main)](https://github.com/nanorocks/project-rating-service/actions/workflows/cPanel.yml)

### PHP CS Fixer
Assuming you installed PHP CS Fixer as instructed above, you can run the following command to fix the files PHP files in the src directory:

$ tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src


### Docker devbox
The project is build on top of docker devbox so, all you need is to have docker desktop installed on you pc and then you can navigate to root to run: 

docker-compose up -d | For starting the devbox

docker-compose down | To clean up all containers

### Project access

- Project is running on http://localhost:80
- Db client is running on http://localhost:54320

Db creating for project
- go to http://localhost:54320
- set provider Mysql
- set username root
- set password secret
- set server database
- after login create database with name ratingdb

### Postman
https://www.getpostman.com/collections/85b32d8827c6579bccad

### Logger

Logs are available at /slim.log

### Connection

Check /is_connected

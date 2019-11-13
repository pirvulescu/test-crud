CRUD
==================================

# Start project (Mac)

Docker is required to be installed on the machine

  * Clone repository `git clone https://github.com/pirvulescu/test-crud.git`
  * Open directory  `cd test-crud`
  * Start project: `make all`
  
Behat tests  
  * Log in to the PHP7 image: `docker-compose exec php-fpm bash`
  * Run test: `vendor/bin/behat -c tests/behat/behat-dev.yml`
  
Rest API endpoint will be available at the URL http://localhost:8083

  
API endpoints:
 * GET /users/
 * GET /users/{id}  
 * POST /users/
    ```
    Payload
    {
    	"username": "testUsername",
    	"name": "My test username"
    }
    ```
 * PUT /users/
     ```
     Payload
     {
        "id": "testUsername",
     	"username": "testUsername",
     	"name": "My test username"
     }
     ```   
 * DELETE /users/{id} 

## Testing task for Searates
Task: https://drive.google.com/open?id=1kIfTo4JPsUn0VNqDlvfB8eTsxiAS7GiX

### Prepare
* Clone repository 
```
git clone https://github.com/makmakom/testing-task-searates.git
```
* Go to project directory
```
cd testing-task-searates
```
* Build docker containers
``` 
sudo docker-compose up --build
```
* Go inside php container. In my case, container name is "testing-task-searates_php_1"
``` 
sudo docker exec -it testing-task-searates_php_1 /bin/bash
```
* Run inside container
``` 
composer install
```
* App available on http://localhost:8080

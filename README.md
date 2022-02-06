# PHP_2022

## Instructions

### VirtualBox
```
git clone https://github.com/laravel/homestead.git ./Homestead
cd ./Homestead
git checkout release

// macOS / Linux...
bash init.sh

// Windows...
init.bat

// copy project file to Homestead directory
cp homestead/Homestead.yaml ~/Homestead/Homestead.yaml

// add line '127.0.0.1 application.local' to hosts file

vagrant up
```

### Docker
```
// copy example of ENV file and re-configure it if necessary
cp .env.example .env

docker-compose up
```

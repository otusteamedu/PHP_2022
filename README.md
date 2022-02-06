# PHP_2022

## Instructions

### Checkout GIT project
```
git clone https://github.com/otusteamedu/PHP_2022.git
git checkout KDmitrienko/hw1
```

### VirtualBox
```
git clone https://github.com/laravel/homestead.git ~/Homestead
cd ~/Homestead
git checkout release

// macOS / Linux...
bash init.sh

// Windows...
init.bat

// change directory to project
cd /{your_path}/PHP_2022/

// copy project file to Homestead directory (replace existing file)
cp homestead/Homestead.yaml ~/Homestead/Homestead.yaml

// add line '127.0.0.1 application.local' to hosts file

cd ~/Homestead/

vagrant up
```

### Docker
```
// copy example of ENV file and re-configure it if necessary
cp .env.example .env

docker-compose up
```

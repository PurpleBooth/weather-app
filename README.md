# Weather app

This is a small combination AngularJS & Silex app, it allows you to search for the current weather in your area.

You can see it running here, without any deployment: https://weather-app-purplebooth.herokuapp.com/

## Getting started

First ensure vagrant and virtualbox are installed.

You'll need the hosts updater plugin.

```
vagrant plugin install vagrant-hostsupdater
```

### Start the VM
```
vagrant up
vagrant ssh
```
### Install the dependencies.

```
vagrant ssh -c 'cd /vagrant && composer install'
```

Your service will be running at [http://dev.weather-app/](http://dev.weather-app/)  

### Running the tests

```
vagrant ssh -c 'cd /vagrant && (vendor/bin/behat ; vendor/bin/phpunit)'
```

### Checking the code style

```
vagrant ssh -c 'cd /vagrant && (vendor/bin/phpcs -p --standard=PSR2 src/ test/ ; vendor/bin/phpmd src/,test text unusedcode)'
```

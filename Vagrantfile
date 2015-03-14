# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/trusty64"
  config.ssh.forward_agent = true
    config.hostmanager.enabled = true
    config.hostmanager.manage_host = true
    config.hostmanager.include_offline = true

  config.vm.define "weather-app" do |weather|
    weather.vm.provision "shell", inline: <<PROVISIONSCRIPT
      add-apt-repository ppa:git-core/ppa
      curl -sL https://deb.nodesource.com/setup | sudo bash -
      apt-get install -y git build-essential php5-common php5-cli php5-curl php5-fpm nginx nodejs

      npm install -g zombie

      php -r "readfile('https://getcomposer.org/installer');" | php
      mv composer.phar /usr/local/bin/composer
PROVISIONSCRIPT

    weather.vm.provision "file", source: "provisioning/nginx-sites/dev", destination: "/tmp/nginx-dev-site"
    weather.vm.provision "file", source: "provisioning/nginx-sites/test", destination: "/tmp/nginx-test-site"

    weather.vm.provision "shell", inline: <<PROVISIONSCRIPT
      mv /tmp/nginx-dev-site /etc/nginx/sites-available/dev
      ln -s /etc/nginx/sites-available/dev /etc/nginx/sites-enabled/dev
      mv /tmp/nginx-test-site /etc/nginx/sites-available/test
      ln -s /etc/nginx/sites-available/test /etc/nginx/sites-enabled/test
      rm /etc/nginx/sites-enabled/default

      service nginx restart
PROVISIONSCRIPT

    weather.vm.network "private_network", ip: "192.168.33.12"
    weather.vm.hostname = 'weather-app'
    weather.hostmanager.aliases = %w(test.weather-app dev.weather-app)
    weather.vm.synced_folder ".", "/vagrant"
  end
end
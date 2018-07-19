raspberry
============
sudo apt-get update
sudo apt-get upgrade
sudo apt-get dist-upgrade
sudo reboot
sudo raspi-config

#screen resolution
sudo nano /boot/config.txt
	hdmi_mode=87
	hdmi_cvt=1024 600 60 1 0 0 0



vnc server
==========
sudo apt-get install tightvncserver
sudo vncserver :1
sudo nano /etc/rc.local
	before the exit 0 line.
	su - pi -c '/usr/bin/tightvncserver :1'
sudo reboot


static ip
==========
sudo nano /etc/dhcpcd.conf
	bottom of file
interface eth0
static ip_address=192.168.0.21/24
static routers=192.168.1.1
static domain_name_servers=192.168.1.1

interface wlan0
static ip_address=192.168.21.1/24
static routers=192.168.1.1
static domain_name_servers=192.168.1.1


open ssh terminal
==========
sudo raspi-config 
	enable ssh
sudo reboot
sudo ssh ip@192.168.1.21


install web stuff
=============
sudo apt-get install apache2
sudo apt-get install mysql-server
sudo apt-get install php5-mysql
sudo apt-get install libapache2-mod-php5


install wiringpi
=============
git clone git://git.drogon.net/wiringPi
cd wiringPi
./build

git clone https://github.com/technion/lol_dht22
cd lol_dht22
./configure
sudo make install


install database
==============
wget http://www.raspiviv.com/databases/datalogger.sql
mysql -u root -p < datalogger.sql
mysql -u root -p
CREATE USER 'datalogger'@'localhost' IDENTIFIED BY 'datalogger';
GRANT ALL PRIVILEGES ON datalogger . * TO 'datalogger'@'localhost';
 

install web page
==============
cd /var/www/html
sudo rm -rf index.html
sudo git clone https://github.com/kromar/raspiviv_community .


setup cronjob
===========
sudo crontab -e
* * * * *       php /var/www/html/core/sensor.php
* * * * *       php /var/www/html/core/climate_control.php
59 23 * * *     php /var/www/html/history.php



lcd calibration
=============
sudo apt-get install -y xinput-calibrator
sudo xinput_calibrator
sudo nano /etc/X11/xorg.conf.d/99-calibration.conf

disable screen timeout
=================
sudo nano /etc/lightdm/lightdm.conf
 [SeatDefaults]
 xserver-command=X -s 0 -dpms

#longpress right click
sudo nano /etc/X11/xorg.conf


autostart
====================
sudo nano /etc/xdg/lxsession/LXDE-pi/autostart



mysql 
=============
mysql -u root -p
--get size of database
select count(*) from 'datalogger'
select * from information_schema.TABLES where table_name = 'datalogger'\G


gpio
=======================
gpio readall
gpio write <pin> <value>
gpio mode 2 out
gpio write 2 1
gpio mode <pin> <value>
gpio read <pin>


raspiviv
=======================
watch tail -f -n 100 /var/log/raspiviv/raspiviv.log
watch tail -f -n 100 /var/log/raspiviv/deltaFilter.log




apache2 / php
=======================
php -i | grep 'php.ini'
sudo find / -name php.ini
sudo nano /etc/php5/apache2/php.ini

tail -f /var/log/apache2/error.log
tail -f /var/log/apache2/php_errors.log

chmod a+w /var/log/httpd
sudo service apache2 restart



logrotate
=======================
logrotate -vf /etc/logrotate.d		//manual logrotate
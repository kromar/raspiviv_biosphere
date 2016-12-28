raspberry
============
sudo apt-get dist-update
sudo raspi-config
sudo nano /boot/config.txt

lcd calibration
=============

sudo xinput_calibrator
sudo nano /etc/X11/xorg.conf.d/99-calibration.conf

sudo nano /etc/lightdm/lightdm.conf
 [SeatDefaults]
 xserver-command=X -s 0 -dpms

sudo apt-get install matchbox-keyboard

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
gpio mode <pin> <value>
gpio read <pin>


raspiviv
=======================
watch -n 1 tail /var/log/raspiviv.log
sudo crontab -e



apache2
=======================
/etc/php5/apache2/php.ini
watch -n 10 tail /var/log/apache2/error.log



logrotate
=======================
logrotate -vf /etc/logrotate.d		//manual logrotate
# Gateway Manager

### A project under the [Social Intelligence Smart-device (SIS)](http://sis.patricks.tw)

SIS Gateway Manager is a WebApp designed to control access of the smart lock system. The WebApp accepts user logging in via Facebook and sends this request to the manager. If the manager approves this request, the user will then receive a QR code by mail which he/she could use it to unlock the smart lock.

This WebApp also provides a API to accept query from the QR Code Reader.

There is also a Project named [HomeGateway](https://github.com/jeremy5189/HomeGateway), which provides the following features:

- Reading QR Code using a webcam and zbar in python
- Control hardware relay via RPi GPIO using gpio commands
- Connects to TI Sensortag via Node.js and emit realtime data to websocket.

# System Structure

![](http://i.imgur.com/KcH1rKY.png)

# Screenshots

### Home Control (Access Log, Door Control)
![](http://i.imgur.com/J9901Ra.png)

### List of Pending User Request (for door access)
![](http://i.imgur.com/w6CpjQ3.png)

### Approval Page
![](http://i.imgur.com/0rJzTwI.png)

### Realtime TI Sensor Tag
![](http://i.imgur.com/LAYNAwX.png)

![](http://i.imgur.com/SO8x25Z.gif)

### IFTTT (If that then that) for sensor 
![](http://i.imgur.com/ucGzBW7.png)

### BB8 robot control via Websocket
![](http://i.imgur.com/4rKo5Zu.png)

# Smart Lock Demo Video

[https://youtu.be/rcVKCsnfMRw](https://youtu.be/rcVKCsnfMRw)

# Install

	sudo apt-get install php7.0 php7.0-mysql mysql-client mysql-server php-mbstring php-xml git vim zip unzip apache2 libapache2-mod-php7.0
	composer install
	cp .env.example .env
	php artisan migrate --seed

## Default User

	admin@example.com
	password


# Home Gateway Manager

Home Gateway Manager is a WebApp designed to control access of the smart lock system. The WebApp accepts user logging in via Facebook and sends this request to the manager. If the manager approves this request, the user will then receive a QR code by mail which he/she could use it to unlock the smart lock.

This WebApp also provides a API to accept query from the QR Code Reader.

Code to control the smart lock and QR code reader.
[https://github.com/jeremy5189/DoorServer](https://github.com/jeremy5189/DoorServer)

# Screenshots

![](http://i.imgur.com/0rJzTwI.png)

# Smart Lock Demo Video

[https://www.youtube.com/watch?v=UvDTgSSAPtA](https://www.youtube.com/watch?v=UvDTgSSAPtA)

# Install

composer install
cp .env.example .env
php artisan migrate --seed


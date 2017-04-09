# Medienprojekt - TU Ilmenau
**Lernanwendung: Gegenüberstellung verschiedener Bild- und Videoformate**

Julia Peter & Mathias Kuntze

Betreuer: Dipl.-Inf. Thomas Köllmer

Professor: Prof. Karlheinz Brandenburg

#### Probleme bei der Installation?
Sollte bei der Installation etwas nicht funktionieren z.B. ein Fehler bei der Installation der Abhängigkeiten auftreten, dann schreibe bitte ein Issue hier in github. Wir werden uns zeitnah um das Problem kümmern.

### Benötigte Software
* Apache-Webserver und MYSQL-Server
```
sudo apt-get install apache2 php7.0 mysql-server php7.0-mysql libapache2-mod-php7.0 phpmyadmin
sudo a2enmod rewrite
sudo service apache2 restart
```
* Alternativen:
  * Linux: LAMP
  * Windows: XAMPP
  
### Installation

1 Web-Applikation downloaden

`git clone https://github.com/KuntzeM/Medienprojekt-WebServer.git`

2 leere MySQL Datenbank anlegen

3 Einstellungen in .env ändern


```
...
APP_URL=http://medienprojekt.dev

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=database_username
DB_PASSWORD=database_password
...
``` 

4 fehlende Abhängigkeiten per Konsole installieren
```
php composer.phar update
```

5 Datenbank-Tabellen anlegen

```
php artisan migrate:install
php artisan migrate:refresh --seed
```
_(--seed: Argument erstellt Datenbankeinträge u.a. Konfigurationseinstellungen)_

6 Web-Applikation müsste nun funktionieren
z.B.

http://medienprojekt.dev für Frontend

http://medienprojekt.dev/admin für Backend

default user: admin

default password: admin

7 Media-Server installieren > https://github.com/KuntzeM/Medienprojekt-MediaServer


### Abhängigkeiten
siehe [Abhängigkeiten in composer.json](https://github.com/KuntzeM/Medienprojekt-WebServer/blob/master/composer.json)

Die Abhänigkeiten werden mit dem Befehl
 ```
 php composer.phar update
 ```
installiert.



## Docker ##

We'll use 3 container:
 - MYSQL databse
 - MediaServer
 - WebServer



### MySQL ###

Run MYSQL directly from image 

    docker run --name mp-mysql -e MYSQL_RANDOM_ROOT_PASSWORD=yes -e MYSQL_DATABASE=medienprojekt -e MYSQL_USER=medienprojekt -e MYSQL_PASSWORD=NBjBGYqXGHeQcq77 -d mysql/mysql-server:5.6



### MediaServer ###

In checked out Mediaserver src: 

Build Mediaserver

    docker build -t mediaserver .
    
Start Mediaserver with link to mysql as host "mysqlserver"
 
    docker run --link mp-mysql:mysqlserver mediaserver
    
    
    
### Webserver ###
    
In checked out Webserver with link to mysql as host "mysqlserver"
    
Build Webserver 

    docker build -t webserver .
    
Start

    docker run --link mp-mysql:mysqlserver -p 8055:80 webserver
    
    
Application is exposed at port 8055.

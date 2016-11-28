# Medienprojekt - TU Ilmenau
**Lernanwendung: Gegenüberstellung verschiedener Bild- und Videoformate**

Julia Peter & Mathias Kuntze

Betreuer: Dipl.-Inf. Thomas Köllmer

Professor: Prof. Karlheinz Brandenburg

#### Probleme bei der Installation?
Sollte bei der Installation entwas nicht funktionieren z.B. ein Fehler bei der Installation der Abhängigkeiten auftreten, dann schreibe bitte ein Issue hier in github. Wir werden uns zeitnah um das Problem kümmern.


### Installation

1 Web-Applikation downloaden

`https://github.com/KuntzeM/Medienprojekt-MediaServer.git`

2 leere MySQL Datenbank anlegen

3 Einstellungen in .env ändern


```
APP_URL=http://medienprojekt.dev

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=database_username
DB_PASSWORD=database_password
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

7 Media-Server installieren > https://github.com/KuntzeM/Medienprojekt-WebServer


### Abhängigkeiten
siehe [Abhängigkeiten in composer.json](https://github.com/KuntzeM/Medienprojekt-WebServer/blob/master/composer.json)

Die Abhänigkeiten werden mit dem Befehl
 ```
 php composer.phar update
 ```
installiert.

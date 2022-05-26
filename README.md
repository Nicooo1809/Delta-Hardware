# Shop Installation (XAMPP)

## [Link zur Haupt-Seite (delta-hardware.de)](https://delta-hardware.de/)
## [Link zur Dev-Seite (dev.delta-hardware.de)](https://dev.delta-hardware.de/)


## Um den Shop verwenden zu können benötigt man einen Webserver (bspw.: Apache) mit PHP-Modul, eine Datenbank (bspw.: MySQL oder MariaDB) und eine Software um diese zu Konfigurieren (bspw.: PhpMyAdmin oder MySQL Workbench). Die Dateien des Webshops in dem ZIP-Archiv müssen in den Pfad „XAMPP\htdocs“ verschoben werden, das ganze sollte dann ungefähr folgendermaßen aussehen:

![](/readmebilder/install1.png)



## Nun konfigurieren wir die Datenbank, hierfür müssen 2 SQL Dateien ausgeführt werden. Das Setup der Datenbank und dann das Einfügen der eigentlichen Daten. Hierfür verwenden wir 2 Dateien in folgender Reihenfolge: 
## setup.sql – erstellt die Datenbank, den Benutzer und die Tabellen
## database.sql – Importiert die Beispieldaten
## Diese sind im Ordner hidden zu finden.

![](/readmebilder/install2.png)
![](/readmebilder/install3.png)

## Jetzt fehlt nur noch eins, starten:
## Starten Sie sowohl die Datenbank als auch den Webserver, in XAMPP sollte es nun folgendermaßen aussehen:

![](/readmebilder/install4.png)

## Fertig!
## Die Website kann nun unter http://127.0.0.1/index.php erreicht werden.

## Alternativ kann man unser Projekt auch unter https://delta-hardware.de erreichen (bis 21.06.22), der Code kann auf https://github.com/Nicooo1809/Delta-Hardware eingesehen werden.


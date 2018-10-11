# liturgia
Génération calendrier liturgique avec tous les propres.
Ce code permet de générer automatiquement l'ensemble du calendrier liturgique pour toute une année. Concrètement, il suffit de lancer la commande PHP-CLI suivante :
php genere_calendarium2.php
et vous obtenez la génération automatisée de plusieurs fichiers :
- calendarium_2018.xml (si vous avez configuré le fichier pour l'année 2018
- un ensemble de fichiers au format 2018-MM-JJ.xml (1 piur chaque jour de l'année) dans le répertoire /calendrier

Ce répertoire sera utilsié le le code de l'autre dépôt (repository) https://github.com/societaslaudis/plugin qui est un plugin Wordpress qui affiche les textes liturgiques pour chaque jour.

* Si vous ne savez pas ce qu'est PHP-CLI, voici une documentation officielle : http://php.net/manual/fr/features.commandline.php

Pour bien utiliser ce code, il faut savoir que :
- il utilise un tableau xls pour le temporal et les célébrations mobiles celebrations_mobiles.xlsx et un autre pour le sanctoral et les célébrations fixes Calendrier_Re.xlsx. La mise à jour (apparition de nouveaux saints aui calendrier universel ou local, ou alors adpatation au propre d'un diocèse ou d'un ordre particulier) est très simple.
- une interface php pour lire et écrire les fixhiers xlsx et docx est présente dans le répertoire /PHPExcel et /PHPWord et n'a pas été mofdifée par le projet.
- Ce système de conversion dans els deux sens entre xlsx et xml, au travers de petits scritps exécutés hors ligne permet également de générer, pour le plugin wordpress (l'autre dépôt) https://github.com/societaslaudis/plugin les fichiers sources bien formatés pour chacund es textes et la gestion de leur traduction.

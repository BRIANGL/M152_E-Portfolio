# m152_BG

Projet pour le module 152.

...Création d'une page facebook pour nous apprendre à implémenter du contenu multimédia dans nos pages html/php/js.

# Organisation du projet

Le projet est organisé en MVC. 

Le dossier contenant les vues est le dossier "pages". Il y contiens toutes les pages qui vont s'afficher à l'utilisateurs et toutes ces pages sont appelées par le fichier index.php qui est à la raçine du projet.

Le dossier contenant les controlleurs est le dossier "controllers". Il y contiens toutes les fonctions qui vont afficher les données sur la vue et toute la logique pour transformer les données du modèle en quelque chose d'affichable.

Le dossier contenant les modèles est le dossier "sql". Il y contiens toutes les classes qui touche a la "Data Base" (requètes SQL, connexion a la DB).

Le dossier contenant les médias est le dossier "media". Il y contiens tout les médias divisé dans 3 sous dossiers -> audio, image, video

Le dossier contenant la css et le javascript nécéssaire au fonctionnement du site est le dossier "assets".

# Pages

addView.php:
Page simple qui ajoute une "vue" dans la base de donnée à chaque média chargé par l'utilisateur 

ajax.php:
Page simple qui supprimer un media. Cette page est appelée en asynchrone par la page edit.php

delete.php:
Page de suppression de poste. Supprime un poste et ses médias associés.

edit.php:
Page qui permet d'éditer ses postes, ajouter des images, supprimer des images, et modifier le texte

index.php:
Page qui affiche les postes à l'utilisateur

post.php:
page qui permet à l'utilisateur d'ajouter un post avec des médias

Upload.php:
page qui upload le fichier et qui affiche un message de réussite ou d'erreur à l'utilisateur

UploadEdit.php:
La même page que la page upload à la seule différence que si le texte est différent de l'actuel, la page change le texte

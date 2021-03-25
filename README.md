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
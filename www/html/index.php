<!DOCTYPE html>
<html>
<head>
	<title>CONTAINER SYMFONY</title>
	<meta charset="utf-8" />
</head>
<body>
<h1>CONTAINER SYMFONY MODE D'EMPLOI</h1>
<p> Pour commencez, connectez-vous au container avec la commande : docker exec -ti symfony-web bash</p>
<p> A l'invite de commandes, changez d'utilisateur avec la commande : su mmi , le mot de passe est 123456 </p>
<p> Déplacez vous dans le dossier /var/www pour continuer</p>
<p> Saisissez les commandes :  git config --global user.email "you@example.com"  et git config --global user.name "Your Name"</p>
<p> Personnalisez les commandes avec votre adresse mail et votre nom (Informations pour GitHub) </p>
<p></p>
<p> Créez votre premier projet symfony avec la commande "symfony new PROJET --webapp" </p>
<p> Une fois le projet créé, repasez en root (exit)</p>
<p> et Déplacez-vous dans le dossier /etc/apache2/sites-enabled</p>
<p> Editez le fichier 001-symfony.conf et remplacer PROJET par le nom de votre projet (et donc de votre dossier qui a été créé dans /var/www)</p>
<p> Rechargez apache2</p>
<p> Votre projet est accessible par l'URL : symfony.mmi-troyes.fr:8319 (8319 étant le port déclaré dans docker-compose)
<p> </p>
<p> Si vous voulez créer un autre projet, procédez de même en dupliquant le fichier 001-symfony.conf et en modifiant le nom du projet</p>
<p> ATTENTION : La valeur de ServerName doit correspondre à un nom DNS pointant sur 127.0.0.1 (c'est le cas de symfony.mmi-troyes.fr et de wr319d.mmi-troyes.fr)</p>
</body>
</html>

<?php
//var_dump($_GET);



// je crée une var pour pouvoir la réutiliser partout car j'écrase le resultat precedent ou il ne reconnait aps l'idcat
$categorieid = $_GET["id_cat"];

$sql='SELECT a.id, title, intro, image, c.titre, c.description FROM categorie c INNER JOIN article a ON categorie_id = c.id WHERE categorie_id=:idcat';
$requete=$connexion->prepare($sql);
$requete->bindValue(":idcat", $categorieid,PDO::PARAM_INT);
$requete->execute();
$categorieArt=$requete->fetchAll();
//var_dump($categorieArt);

//Afficher le nombre d'article dans la page "une-catégorie"
$sql="SELECT COUNT(`categorie_id`) FROM article WHERE categorie_id=:idcat";
$requete=$connexion->prepare($sql);
$requete->bindValue(":idcat", $categorieid,PDO::PARAM_INT);
$requete->execute();
$nbArtcategory=$requete->fetchColumn();
//var_dump($nbArtcategory);


//var_dump($categories["description"]);
//$Titre = $_GET["title"]; VALUES (:titreH, :introArt)
//$intro = $_GET["intro"];
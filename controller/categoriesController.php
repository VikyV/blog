<?php



$sql='SELECT * FROM categorie';
$requete=$connexion->prepare($sql);
$requete->execute();
$categories=$requete->fetchAll();
//var_dump($categories);

 
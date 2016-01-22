
<?php

$pagination=0;
if(!empty($_GET["num"])&&is_numeric($_GET["num"]))
{
	$pagination=($_GET["num"]-1)*3;
	//je change le 3 aussi d'ici
}

$sql= "SELECT * FROM `article` ORDER BY date_creation
DESC LIMIT :valeurLimit,3";
$requete=$connexion->prepare($sql);
$requete->bindValue(":valeurLimit",$pagination, PDO::PARAM_INT);
$requete->execute();
$articles=$requete->fetchAll();
//var_dump($articles);

$sql="SELECT COUNT(`id`) FROM article";
$requete=$connexion->prepare($sql);
$requete->execute();
$nbPages=$requete->fetchColumn();
//var_dump($nbPages);


$Pagination = ($nbPages/3) ;

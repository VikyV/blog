<?php


//var_dump($_GET);

//$article=$requete->fetch();
//var_dump($article);

if(!empty($_GET["id-article"]))
{
	
	$idarticle = $_GET["id-article"];
//recuperer la page article
	$sql="SELECT * FROM `article` WHERE id=:newid";
	$requete=$connexion->prepare($sql);
	$requete->bindValue(":newid", $idarticle,PDO::PARAM_INT);
	$requete->execute();
	$article=$requete->fetch();
}

if(empty($article))
{
	header("location:index.php?page=404");
	die();
}

//var_dump($_POST);
//http://getbootstrap.com/examples/signin/
if(!empty($_POST))
{
	$errors = [];
//pour inserer les commentaires fait sur le site dans le serveur
	if(empty($errors))
	{
		$form=($_POST);
		$AuthorComment = $_POST["name"];
		$noteCom = $_POST["note"];
		$Comments = $_POST["contenu"];

		$sql='INSERT INTO commentaire(auteur, note, contenu, date_creation, article_id)
		VALUES(:nameAut, :noteCom, :ComentC, NOW(), :ida)';
		$requete=$connexion->prepare($sql);
		$requete->bindValue(":nameAut",$AuthorComment);
		$requete->bindValue(":noteCom",$noteCom);
		$requete->bindValue(":ComentC",$Comments);
		$requete->bindValue(":ida",$idarticle);
		
		$requete->execute();
		//die('Requete en ajax');
		//est-ce qu'on est bien en ajax:
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
    	{
    		$commentaireAjax = '
				<div class="media">
				<a class="pull-left" href="#">
				<img class="media-object" src="http://loremflickr.com/64/64/city" alt="image aléatoire de ville"></a>
				<div class="media-body">
				<h4 class="media-heading">'.$_POST['name'].'<small>'.date('y-m-d h:i:s').' : '.$_POST['note'].' / 5</small>
				</h4>
				'.$_POST['contenu'].'</div>
				</div>';


    		$dataAjax = ['sucess'=>'Votre commentaire a bien été ajouté', 'commentaire' => $commentaireAjax];
    		die(json_encode($dataAjax));// Permet de retourner des informations au format json
    	}



	}

}

//ici recuprer les commentaires du serveur afin de les inclure dans la p.article
	
$sql2='SELECT * FROM `commentaire` WHERE article_id =:ida ORDER BY article_id ASC' ;
$requete=$connexion->prepare($sql2);
$requete->bindValue(":ida",$idarticle);
$requete->execute();
$formulle=$requete->fetchAll();
//var_dump($formulle);

$sql2='SELECT * FROM `utilisateur`';
$requete=$connexion->prepare($sql2);

$requete->execute();
$utilisateur=$requete->fetchAll();
//var_dump($utilisateur);

//Afficher la catégorie dans la page article (lien compris)
//$sql='SELECT categorie_id FROM article WHERE categorie_id';
//$requete=$connexion->prepare($sql);
//$requete->execute();
//$categorieTitre=$requete->fetch();
//var_dump($categorieTitre);

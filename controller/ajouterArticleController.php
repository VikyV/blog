<?php
redirectIfNotConnected();

function validateDate ()
{
	$today=date("d-m-y");
 	$diff = (date_diff( date_create($today), date_create($_POST["dateArticle"])));
 	//var_dump($diff);
 	if($diff->invert == 1)
 	{
 		die();
 	}
}



// $TitleNewArt = $_POST["titre"];
function stringval ($TitleNewArt)
{
	if ($TitleNewArt > 2) 
	{
		die();
	}

}


//var_dump($_POST);

//validateDate();


if (!empty($_POST) && !empty($_FILES))
{	
	var_dump($_FILES);
    //die('stop');

	$errors=[];

	if(empty($_POST["titre"]))
	{
		$errors["titre"]="Veuillez entrer un titre";
	}
	if(empty($_POST["description"]))
	{
		$errors["description"]= "il nous faut un texte";
	}
	if (empty($_FILES['nameImage']) || $_FILES['nameImage']['error'] != 0)
	{
		$errors['nameImage'] = "Veuillez entrer une image";
	}
	else
	{
		// Vérification si l'utilisateur m'envoit réellement une image
		$extensions_valides = [ 'jpg' , 'jpeg' , 'gif' , 'png' ];
		$extension_upload = str_replace("image/", "", $_FILES['nameImage']['type']);
		if (!in_array($extension_upload, $extensions_valides))
		{
			$errors['image'] = "Image non valide";
		}

		$size = getimagesize($_FILES['nameImage']['tmp_name']);
		// $size['0'] est à la width
		// $size['1'] est à la height
		if ($size['0'] > 900 || $size[1] > 300)
		{
			$errors['image'] = "Image trop grande";
		}

		
 
	}
    



	if(empty($_POST["dateArticle"]))
	{
		$errors["dateArticle"]="Soyez aimable et donner une date raisonnable";
	}
	if(empty($_POST["AuthorArt"]))
	{
		$errors["AuthorArt"]="il nous faut un nom";
	}
	if(empty($_POST["categorie"]))
	{
		$errors["categorie"]="les catégories sont obligatoires !";
	}

	if (empty($errors))
	{
		$TitleNewArt = $_POST["titre"];
		$newdescriptArt = $_POST["description"];
		$nomImage = uniqid().'-'.$_FILES['nameImage']['name'];
		// $nomImage = uniqid().'.'.extension_upload;
		// Mettre le titre de l'article dans le nom de l'image
        // $nomImage = str_replace(' ', '-', $_POST['titre']).'-'.uniqid().'.'.extension_uploa
		$successUpload = move_uploaded_file($_FILES['nameImage']['tmp_name'], 'view/images/'.$nomImage);
		if ($successUpload == true)
        {
            $newdateCrea = $_POST["dateArticle"];
			$newAuthArt = $_POST["AuthorArt"];
			$newCateg=$_POST["categorie"];

		$sql="INSERT INTO article(title, description, date_creation, image, author, categorie_id)
			VALUES(:newtitle,:newdescript,:newdateC,:Newimage,:newauthorArt, :newcategA)";
			$requete=$connexion->prepare($sql);
			$requete->bindValue(":newtitle",$TitleNewArt);
			$requete->bindValue(":newdescript",$newdescriptArt);
			$requete->bindValue(':Newimage', $nomImage);
			$requete->bindValue(":newdateC",$newdateCrea);
			$requete->bindValue(":newauthorArt", $newAuthArt);
			$requete->bindValue(":newcategA",$newCateg);
		$requete->execute();
		$_SESSION['messageFlash'] = "Bravo, vous avez bien aouter un nouvel article avec succès";
            header("location:index.php?page=ajouterArticle");
            die;
        }
        else
        {
        	$errors['image'] = "Problème lors de l'upload de l'image";
        }

		
	}
}

$sql ="SELECT id, titre FROM categorie";
$requete=$connexion->prepare($sql);
$requete->execute();
$categoriA=$requete->fetchAll();
//var_dump($categoriA);

 


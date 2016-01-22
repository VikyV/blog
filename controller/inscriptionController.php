<?php
//var_dump($_POST);

if (!empty($_POST))
{	
	
	$errors=[];

	if(empty($_POST["inputNom"]))
	{
		$errors["inputNom"]="Veuillez entrer un nom";
	}
	if(empty($_POST["inputPrenom"]))
	{
		$errors["inputPrenom"]= "Veuillez entrer un prénom";
	}
	if(empty($_POST["inputEmail"]))
	{
		$errors["inputEmail"]= "Veuillez entrer un email";
	}
	if(empty($_POST["inputPassword"]))
	{
		$errors["inputPassword"]= "Veuillez entrer un password";
	}
 	else if (filter_var($_POST['inputPassword'], FILTER_VALIDATE_EMAIL) == false)
    {
    	$errors['inputPassword'] = "Veuillez rentrer un email valide";
    }



 	if(empty($_POST["inputConfirmsword"]) != ($_POST["inputPassword"]) )
	{
		$errors["inputConfirmsword"]= "Votre mot de passe est différent";
	}
	if (empty($errors))
	{
		$LogNom = $_POST["inputNom"];
		$LogPrnom = $_POST["inputPrenom"];
		$LogMail = $_POST["inputEmail"];
		
		$LogPass = password_hash($_POST["inputPassword"], PASSWORD_DEFAULT);

		$sql='INSERT INTO utilisateur(`nom`,`prenom`,`email`,`password`)
		VALUES(:InptNom, :InptPrnom,:InptMail, :InptPass)';
		$requete=$connexion->prepare($sql);
		$requete->bindValue(":InptNom",$LogNom);
		$requete->bindValue(":InptPrnom",$LogPrnom);
		$requete->bindValue(":InptMail",$LogMail);
		$requete->bindValue(":InptPass",$LogPass);
		$requete->execute();
		
		$_SESSION['sucess'] = 'Bravo, Vous êtes inscrit';
        header('Location: index.php');
        die();
       	
	}
}
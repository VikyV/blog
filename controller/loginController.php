<?php

// var_dump(password_hash('1234567', PASSWORD_DEFAULT));
// die();

//var_dump($_POST);




if (!empty($_POST))
{	
	
	$errors=[];

	
	if(empty($_POST["inputEmail"]))
	{
		$errors["inputEmail"]= "Veuillez entrer un email";
	}
	else if(filter_var($_POST["inputEmail"],FILTER_VALIDATE_EMAIL) == false)
	{ 
		$errors["inputEmail"]= "Veuillez entrer un email valide";
	
	}



	if(empty($_POST["inputPassword"]))
	{
		$errors["inputPassword"]= "Veuillez entrer un password";
	}

 
	if (empty($errors))
	{
	
		$LogMail = $_POST["inputEmail"];
		$LogPass = $_POST["inputPassword"];

		$sql='SELECT * FROM utilisateur WHERE email = :InptMail';
		$requete=$connexion->prepare($sql);
		$requete->bindValue(":InptMail",$LogMail);
		$requete->execute();

		$user = $requete->fetch();

		var_dump($user);
		if ($user)
		{
			// Vérification du mot de passe
			password_verify($_POST["inputPassword"],$user['password']);
			$_SESSION['utilisateur'] = $user;
            header('Location: index.php');
			die('connexion utilisateur');
		}
		else
		{
			$errors["all"]= "login/mot de passe incorrect";
		}
		
	}
}


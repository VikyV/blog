<?php
session_start();
$dsm = "mysql:host=localhost;dbname=BLOG;charset=utf8";
$userlogin ="root";
$password = "troiswa";
$connexion = new PDO($dsm,$userlogin,$password);
$connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
$connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);

// Rajouter un lien uniquement si on est connecté -->


function isConnected()
{
	if (empty($_SESSION['utilisateur']))
    {
    	return false;
    }
    
    return true;
}


function redirectIfNotConnected()
{
	if (isConnected() == false)
    {
    	header('Location: index.php?page=login');
        die();
    }
}


/*function isConnected($redirect = true)
{
	if(empty($_SESSION['utilisateur']))
	{
		if($redirect==false)
		{
			return false;
		}
		header('Location: index.php?page=login');
		die();
	}
	return true;
}
//version simple function isConnected($redirect=true) 
//{if(!empty($_SESSION['utilisateur']))
//		{	header('Location: index.php?page=login');
//			die();}		} 
isConnected(false);isConnected(true);*/
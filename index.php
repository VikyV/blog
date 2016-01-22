<?php
//si je met l'accès à cet endroit là ttes mes pages ont accès à la connexion et cela évite de charger en permance cette action
// en incluant ce fichier
include "config/config.inc.php";
$page="home";
if(!empty($_GET["page"]))
{
	$page=$_GET["page"];
}
if("logout"==$page)
{
	unset($_SESSION['utilisateur']);
	header('location:index.php?page=login');
	die();
}




$controller = "controller/".$page."Controller.php";
$view = "view/".$page."View.phtml";
if(file_exists($controller) == false || !file_exists($view) )
{
	//test : die; var_dump(file_exists($controller)); 
	header("location:index.php?page=404");
	die("lol-errorcontroller");
}

//var_dump(ajax check)
//var_dump($_SESSION);
include $controller;
include $view;
//include "controller/".$page."Controller.php";
//include "view/".$page."View.phtml";
//include "controller/".$page."Controller.php";include "view/".$page."View.phtml";
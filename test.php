<?php


require "vendor/autoload.php";
require "utilities/config.php";
require "utilities/Connexion.php";
require "models/User.php";

$user = new User();
$user->setFirst_name("aaaa");
$user->setLast_name("dddd");
$user->setEmail("sdfsdf");
$user->setPassword("dsfszdfsdf");
$user->setAdmin(false);

dump($user);
$cnx = new Connexion();
$cnx->addToDb("user", $user);

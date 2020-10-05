<?php require 'inc/partners.php';
shuffle($partners);
$partners = array_slice($partners, 0, 4);

require 'views/index.view.php';
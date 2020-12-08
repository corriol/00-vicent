<?php
$router->get("", "DefaultController", "index");
$router->get("movies","MovieController", "index");
$router->post("movies","MovieController", "filter");

$router->get("movies/create","MovieController", "create");
$router->post("movies/create","MovieController", "create");



$router->get("partners","PartnerController", "index");


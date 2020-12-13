<?php

/* Default routes */
$router->get("", "DefaultController", "index");
$router->get("contact", "DefaultController", "contact");


/* Movies routes */

$router->get("movies", "MovieController", "index");
$router->post("movies", "MovieController", "filter");

$router->get("movies/:id/show", "MovieController", "show",
    ["id" => "number"], "movies_show");

$router->get("movies/create", "MovieController", "create");
$router->post("movies/create", "MovieController", "store");

$router->get("movies/:id/edit", "MovieController", "edit", ["id" => "number"]);
$router->post("movies/:id/edit", "MovieController", "edit", ["id" => "number"]);

$router->get("movies/delete", "MovieController", "delete");
$router->post("movies/delete", "MovieController", "delete");

/* Partners routes */
$router->get("partners", "PartnerController", "index", [], "partners_index");
$router->post("partners", "PartnerController", "filter", [], "partners_filter");

$router->get("partners/create", "PartnerController", "create", [], "partners_create");
$router->post("partners/create", "PartnerController", "store", [], "partners_store");

$router->get("partners/:id/edit", "PartnerController", "edit", ["id"=>"number"], "partners_edit");
$router->post("partners/:id/edit", "PartnerController", "update", ["id"=>"number"], "partners_update");

$router->get("partners/:id/delete", "PartnerController", "delete", ["id"=>"number"], "partners_delete");
$router->post("partners/delete", "PartnerController", "destroy", [], "partners_destroy");



<?php

/* Default routes */
$router->get("", "DefaultController", "index");

$router->get("contact", "DefaultController", "contact");
$router->post("contact", "DefaultController", "contact");

$router->get("api/v1/movies", "ApiController", "index");

/* Auth routes */
$router->get("login", "AuthController", "login");
$router->post("login", "AuthController", "checkLogin");
$router->get("logout", "AuthController", "logout", [], "logout");


/* Movies routes */

$router->get("movies/:id/show", "MovieController", "show",
    ["id" => "number"], "movies_show");
$router->get("movies/genre/:id/list", "MovieController", "listByGenre",
    ["id" => "number"], "movies_genre_list");
$router->get("movies/search", "MovieController", "search", [], "movies_search");


/* Movies admin routes */
$router->get("admin/movies", "MovieController", "index", [], "movies_index", "ROLE_USER");
$router->post("admin/movies", "MovieController", "filter", [], "movies_filter", "ROLE_ADMIN");
$router->get("admin/movies/create", "MovieController", "create", [], "movies_create", "ROLE_ADMIN");
$router->post("admin/movies/create", "MovieController", "store", [], "movies_store", "ROLE_ADMIN");

$router->get("admin/movies/:id/edit", "MovieController", "edit", ["id" => "number"], "movies_edit", "ROLE_ADMIN");
$router->post("admin/movies/:id/edit", "MovieController", "edit", ["id" => "number"], "movies_edit", "ROLE_ADMIN");

$router->get("admin/movies/:id/delete", "MovieController", "delete", ["id"=>"number"], "movies_delete", "ROLE_ADMIN");
$router->post("admin/movies/delete", "MovieController", "destroy", [],"movies_destroy", "ROLE_ADMIN");

/* Partners routes */
$router->get("admin/partners", "PartnerController", "index", [], "partners_index",
    "ROLE_ADMIN");
$router->post("admin/partners", "PartnerController", "filter", [], "partners_filter",
    "ROLE_ADMIN");
$router->get("admin/partners/create", "PartnerController", "create", [], "partners_create",
    "ROLE_ADMIN");
$router->post("admin/partners/create", "PartnerController", "store", [], "partners_store",
    "ROLE_ADMIN");
$router->get("admin/partners/:id/edit", "PartnerController", "edit", ["id"=>"number"],
    "partners_edit", "ROLE_ADMIN");
$router->post("admin/partners/:id/edit", "PartnerController", "update", ["id"=>"number"],
    "partners_update", "ROLE_ADMIN");
$router->get("admin/partners/:id/delete", "PartnerController", "delete", ["id"=>"number"],
    "partners_delete", "ROLE_ADMIN");
$router->post("admin/partners/delete", "PartnerController", "destroy", [], "partners_destroy",
    "ROLE_ADMIN");


/* Users routes */
$router->get("admin/users", "UserController", "index", [], "users_index");
$router->post("admin/users", "UserController", "filter", [], "users_filter");

$router->get("admin/users/create", "UserController", "create", [], "users_create");
$router->post("admin/users/create", "UserController", "store", [], "users_store");

$router->get("admin/users/:id/edit", "UserController", "edit", ["id"=>"number"], "users_edit");
$router->post("admin/users/:id/edit", "UserController", "update", ["id"=>"number"], "useres_update");

$router->get("admin/users/:id/delete", "UserController", "delete", ["id"=>"number"], "users_delete");
$router->post("admin/users/delete", "UserController", "destroy", [], "users_destroy");


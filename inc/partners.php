<?php
require 'src/Partner.php';

define("PARTNER_PATH", "/partners");
$partnersAr = [
    ["logo"=>"company-1.png", "name"=>"Pizza Hut"],
    ["logo"=>"company-2.png", "name"=>"Coca-cola"],
    ["logo"=>"company-3.png", "name"=>"Gamescast"],
    ["logo"=>"company-4.png", "name"=>"Ingenius"],
    ["logo"=>"microsoft-logo.png", "name"=>"Microsoft"],
];

$partners = [];

$contador = 1;
foreach($partnersAr as $partnerAr) {
    $partner = new Partner();
    $partner->setId($contador);
    $partner->setLogo($partnerAr["logo"]);
    $partner->setName($partnerAr["name"]);
    $partners[] = $partner;
    $contador++;
}

$partner = new Partner();
$partner->setId($contador);
$partner->setName("Cisco");
$partner->setLogo("cisco.jpg");
$partners[]=$partner;

$partnerCopy=clone $partner;
$partners[]=$partnerCopy;

$partnerCopy->setName("Linksys");


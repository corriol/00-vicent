<?php
/**
function generarImagenUrl(string $url, string $alt = "imagen", int $height = 400, int $width = 400): string
{
    return '<img src="' . $url . '" alt="' . $alt . '" height="' . $height . 'px" $width="' . $width . 'px" />';
}
 **/

function generarImagenLocal(string $ruta, string $url, string $alt = "imagen",string $class="", int $height = 50, int $width = 50): string
{

    return '<img '.$class.' src="' . $ruta . $url . '" alt="' . $alt . '" height="' . $height . 'px" $width="' . $width . 'px" />';
}

?>

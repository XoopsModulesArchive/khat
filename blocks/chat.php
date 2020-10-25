<?php

require dirname(__DIR__, 3) . '/mainfile.php';
require dirname(__DIR__) . '/cache/config.php';
require dirname(__DIR__) . '/include/fonctions.php';
// innerHTML et iframe invisible pour masquer les rafraichissements
// inspiration: chat de NobodX
echo AfficherEnteteHTML();
// comme xoops.css centre les DIV, on realigne à gauche
echo '<style type="text/css">div { text-align: left }</STYLE>';
echo '<body class="bg1">';
$option_pop = "?nblig=$nblig";   // options[1]
$option_pop .= "&nbcar=$nbcar"; //options[2]
if ($modepop) {
    $option_pop .= '&modepop=1';
}
$option_pop .= "&son=$son";
echo "<iframe src=\"chataction.php$option_pop\" name=\"chataction\" width=\"0\" height=\"0\"  style=\"display:none;visibility:hidden\"></iframe>";
echo '<div id="miaou"></div>';
echo '</body></html>';

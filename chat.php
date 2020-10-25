<?php

require dirname(__DIR__, 2) . '/mainfile.php';
//include ('cache/config.php');
// innerHTML et iframe invisible pour masquer les rafraichissements
// inspiration: chat de NobodX
xoops_header(false);
// comme xoops.css centre les DIV, on realigne à gauche
echo '<style type="text/css">div { text-align: left }</STYLE>';
echo '<body id="khatbody" class="bg1">';
$nblig = $_GET['nblig'] ?? 0;
$nblig = (int)$nblig;
$nbcar = $_GET['nbcar'] ?? 0;
$nbcar = (int)$nbcar;
$modepop = $_GET['modepop'] ?? 0;
$son = $_GET['son'] ?? 'On';
$op = $_GET['op'] ?? '';
$lig = $_GET['lig'] ?? '';
$lig = (int)$lig;

$option_pop = "?nblig=$nblig";   // options[1]
$option_pop .= "&nbcar=$nbcar"; //options[2]
if ($modepop) {
    $option_pop .= '&modepop=1';
}
$option_pop .= "&son=$son";
if ($op) {
    $option_pop .= "&op=$op&lig=$lig";
}
//echo "<iframe src=\"chataction.php$option_pop\" name=\"chataction\" width=\"0\" height=\"0\"  style=\"display:none;visibility:hidden\"></iframe>";
echo "<iframe src=\"chataction.php$option_pop\" name=\"chataction\" width=\"0\" height=\"0\" style=\"visibility:hidden\"></iframe>";
//echo "<iframe src=\"chataction.php$option_pop\" name=\"chataction\" width=\"300\" height=\"100\" ></iframe>";
echo '<div id="khatdiv"></div>';
//echo "</body></html>";
xoops_footer();











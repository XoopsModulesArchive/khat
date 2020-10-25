<?php

require dirname(__DIR__, 2) . '/mainfile.php';
require_once __DIR__ . '/class/class.' . mb_strtolower($xoopsModuleConfig['mode']) . '.php';

// recup variables "proprement"
$nblig = $_GET['nblig'] ?? 10;
$nblig = (int)$nblig;
$nbcar = $_GET['nbcar'] ?? 50;
$nbcar = (int)$nbcar;
$modepop = $_GET['modepop'] ?? 0;
$son = $_GET['son'] ?? 'On';
$mt = $_GET['mt'] ?? '';
$op = $_GET['op'] ?? '';
$lig = $_GET['lig'] ?? 0;
$lig = (int)$lig;

// mode objet 21/05/2003 pour v1.1
// indirection 26/05
$khat = new $xoopsModuleConfig['mode']();

// innerHTML et iframe invisible pour masquer les rafraichissements
// inspiration: chat de NobodX

$fmt = $khat->lastMessageDate();

echo '<HTML><HEAD>';
if ($modepop) {
    $option_pop = '?modepop=1';
} else {
    $option_pop = "?nblig=$nblig";
} //options[1]
$option_pop .= "&mt=$fmt&son=$son";
if (0 != $xoopsModuleConfig['timeout']) {
    echo '<META HTTP-EQUIV="REFRESH" CONTENT="' . $xoopsModuleConfig['timeout'] . "; URL=chataction.php$option_pop&refresh=" . random_int(0, 10000) . "\">\n";
}
echo "</HEAD>\n";
echo '<BODY>';
$khat->setParamlien($option_pop);
if ('supprlig' == $op) {
    $resuppr = $khat->supplig($lig);
}
if ($mt != $fmt) {         // refraichir si changement dans le fichier msg
    $khat->makeKhat(
        [
            'ano' => $xoopsModuleConfig['ano'],
'smiley' => $xoopsModuleConfig['smiley'],
'html' => $xoopsModuleConfig['html'],
'xoopscode' => $xoopsModuleConfig['xoopscode'],
'timeout' => $xoopsModuleConfig['timeout'],
'formatdate' => $xoopsModuleConfig['formatdate'],
'nouveauxmsg' => $xoopsModuleConfig['nouveauxmsg'],
'lien' => 'chat.php',
'paramlien' => $option_pop,
        ]
    );

    // affichage du fichier via innerHTML dans la fenêtre parent!

    if (1 == $modepop) {
        $inHTML = $khat->getAllLines($xoopsModuleConfig['popuplength']);
    } else {
        $inHTML = $khat->getAllLines($nblig);
    }

    if ($mt && 'On' == $son) {
        $inHTML .= '<bgsound src="' . XOOPS_URL . '/' . $xoopsModuleConfig['soundfile'] . '">';
    } // sound for news messages

    echo "<script>\n var chat = parent.document.getElementById(\"khatdiv\");\n";

    $inHTML = str_replace('\\', '\\\\', $inHTML);

    $inHTML = str_replace('"', '\\"', $inHTML);  // necessaire pour le HTML des smiley et liens url

    echo "chat.innerHTML = \"$inHTML\";\n";

    echo 'parent.scrollBy(0,200);';

    echo "</script>\n";

    //echo $inHTML;   /////  POUR DEBUG UNIQUEMENT !!!!   <<<<<<<<<<<<<<<<<<<<
    //echo "op=$op,lig=$lig,option_pop=$option_pop<br>";
    //echo $resuppr."<br>";
}
echo '</BODY></HTML>';




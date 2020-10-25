<?php

require dirname(__DIR__, 3) . '/mainfile.php';
require dirname(__DIR__) . '/cache/config.php';
require dirname(__DIR__) . '/include/fonctions.php';
// innerHTML et iframe invisible pour masquer les rafraichissements
// inspiration: chat de NobodX
$fmt = filemtime(XOOPS_ROOT_PATH . '/' . $chat_file);
echo '<HTML><HEAD>';
if ($modepop) {
    $option_pop = '?modepop=1';
} else {
    $option_pop = "?nblig=$nblig";
} //options[1]
$option_pop .= "&mt=$fmt&son=$son";
if (0 != $khatimeout) {
    echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"$khatimeout; URL=$option_pop&refresh=" . random_int(0, 10000) . "\">\n";
}
echo "</HEAD>\n";
echo '<BODY ';
//if ($khatimeout != 0) echo "onLoad=\"window.setTimeout('history.go(0)', $khatimeout)\"";
echo '>';

if ($mt != $fmt) {         // refraichir si changement dans le fichier msg
    // affichage du fichier via innerHTML dans la fenêtre parent!

    if (1 == $modepop) {
        $inHTML = AfficherFichier(XOOPS_ROOT_PATH . '/' . $chat_file, $chat_length_p, $khatformatdate, $khatsmiley, $khathtml, $khatbbcode);
    } else {
        $inHTML = AfficherFichier(XOOPS_ROOT_PATH . '/' . $chat_file, $nblig, $khatformatdate, $khatsmiley, $khathtml, $khatbbcode);
    }

    if ($mt && 'Off' != $son) {
        $inHTML .= '<bgsound src=' . $xoopsConfig['xoops_url'] . '/' . $chat_soundfile . '>';
    } // sound for news messages

    echo "<script>\n var chat = parent.document.getElementById(\"miaou\");\n";

    $inHTML = str_replace('"', '\\"', $inHTML);

    echo "chat.innerHTML = \"$inHTML\";\n";

    echo "</script>\n";
}
echo '</BODY></HTML>';

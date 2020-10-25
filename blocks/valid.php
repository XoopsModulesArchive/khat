<?php

global $person, $msg, $REMOTE_ADDR, $HTTP_REFERER, $xoopsUser;
global $xoopsConfig, $xoopsTheme;
global $modversion;

require dirname(__DIR__) . '/cache/config.php';
include '../../../mainfile.php';
require dirname(__DIR__) . '/include/fonctions.php';

NettoyageFichier($xoopsConfig['root_path'] . $chat_file, $max_file_size, $chat_length_p);

$myts = new MyTextSanitizer();

if ($person) {
    $person = htmlspecialchars($person, 0);
} else {
    if ($xoopsUser) {
        $person = $xoopsUser->uname();

        if ('' == $person) {
            $person = $xoopsUser->getClientIP();
        }
    } else {
        $person = "($REMOTE_ADDR)";
    }
}
EcrireMsg($message, $person, $xoopsConfig['root_path'] . $chat_file);

header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');  // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: no-store, no-cache, must-revalidate');  // HTTP/1.1
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');                // HTTP/1.0
header("Location: $HTTP_REFERER");
echo '<html><head><meta http-equiv="Refresh" content="0; URL=' . $HTTP_REFERER . '">' . '</meta></head><body></body></html>';

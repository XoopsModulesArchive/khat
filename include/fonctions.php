<?php

function khatAno($khatAno, $xusr)
{
    global $REMOTE_ADDR;

    $res = $khatAno;

    if ($xusr) {
        $ip = $xoopsUser->getClientIP();
    } else {
        $ip = $REMOTE_ADDR;
    }

    $res = str_replace('@', $ip, $res);

    return ($res);
}

function NettoyageFichier($chat_file, $max_file_size, $chat_length)
{
    $file_size = filesize($chat_file);

    if ($file_size > $max_file_size) {
        $lines = file($chat_file);

        $a = count($lines);

        $u = $a - $chat_length;

        $msg_old = '';

        for ($i = $a; $i >= $u; $i--) {
            $msg_old = $lines[$i] . $msg_old;
        }

        $deleted = unlink($chat_file);

        $fp = fopen($chat_file, 'wb');

        $fw = fwrite($fp, $msg_old);

        fclose($fp);
    }
}

function EcrireMsg($message, $person, $chat_file)
{
    global $xoopsMyts;

    //    $message=$xoopsMyts->censorString($message); // on ne le fait qu'a l'affichage!

    $message = $xoopsMyts->htmlSpecialChars($message, 0);

    $message = $xoopsMyts->makeClickable($message);

    if ('' != $message) {
        //$infos = date("H:i")." <i>".$person."</i>";

        // ecriture de l'heure au format time unix standard pour Xoops

        $infos = time() . "<i>$person</i>";

        $fp = fopen($chat_file, 'a+b');

        $fw = fwrite($fp, "\n$infos :</b> $message");

        fclose($fp);
    }
}

function AfficherFichier($chat_file, $chat_length, $formatdate = 'm', $smiley = 'no', $html = 'no', $bbcode = 'no')
{
    global $xoopsMyts;

    $content = '';

    $lines = file($chat_file);

    $a = count($lines);

    $u = $a - $chat_length;

    for ($i = $a - 1; $i >= $u; $i--) {
        $s = rtrim($lines[$i]);

        if ('' == $s) {
            continue;
        }

        $heure = formatTimestamp(mb_substr($s, 0, 10), $formatdate);

        $s = '<b>' . $heure . ' ' . mb_substr($s, 10);

        // traitement de l'heure

        if (1 == $html) {
            $s = $xoopsMyts->undoHtmlSpecialChars($s);
        }

        $s = $xoopsMyts->censorString($s);

        $s = $xoopsMyts->displayTarea($s, 1, $smiley, $bbcode);

        $content .= $s;

        $content .= '<br>';
    }

    return ($content);
}

function AfficherEnteteHTML()
{
    global $xoopsConfig;

    $content = '';

    $content .= "<?xml version='1.0' encoding='"
                . _CHARSET
                . "'"
                . '?'
                . '>'
                . "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>"
                . "<html xmlns='http://www.w3.org/1999/xhtml'>"
                . '<head>'
                . '<title>Khat</title>'
                . '<meta http-equiv="Content-Type" content="text/html; charset='
                . _CHARSET
                . '">'
                . "<meta name=\"author\" content=\"kyex\">\n"
                . "<meta name=\"copyright\" content=\"Copyright (c) 2001 by kyex\">\n";

    $currenttheme = getTheme();

    require_once XOOPS_ROOT_PATH . '/themes/' . $currenttheme . '/theme.php';

    if (file_exists(XOOPS_ROOT_PATH . '/themes/' . $currenttheme . '/language/lang-' . $xoopsConfig['language'] . '.php')) {
        require XOOPS_ROOT_PATH . '/themes/' . $currenttheme . '/language/lang-' . $xoopsConfig['language'] . '.php';
    }

    $themecss = getcss($currenttheme);

    $content .= "<link rel='stylesheet' type='text/css' media='all' href='" . $xoopsConfig['xoops_url'] . "/xoops.css'>\n";

    if ($themecss) {
        $content .= "<link rel='stylesheet' type='text/css' href='$themecss'>\n\n";
    }

    $content .= "<script type='text/javascript'><!-- \n"
                . "function openPopup(theURL,winName,features) {\n"
                . "window.open(theURL,winName,features);\n"
                . "}\n"
                . 'function callJS(jsStr) {'
                . 'return eval(jsStr)'
                . "}\n"
                . "function goToURL() {\n"
                . "var i, args=goToURL.arguments; document.MM_returnValue = false;\n"
                . "for (i=0; i<(args.length-1); i+=2) eval(args[i]+\".location='\"+args[i+1]+\"'\");\n"
                . "}\n"
                . '--></script>';

    $content .= '</head>';

    return ($content);
}

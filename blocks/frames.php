<?php

if (!isset($nblig)) {
    $nblig = '10';
}

if (1 == $modepop) {
    $option_pop = "?modepop=1&nblig=$nblig";

    $hauteur_post = '40';
} else {
    $option_pop = "?nblig=$nblig";   // options[1]

    $hauteur_post = '20';
}
$option_pop .= "&nbcar=$nbcar"; //options[2]

echo '<html>'
     . '<head>'
     . '<title>Khat</title>'
     . '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></meta>'
     . '</head>'
     //."nblig in frm = $nblig et pop=$option_pop !!!<br>"
     //."donc frame name=\"mainFrame\" src=\"chat.php$option_pop\"<brS>"
     . "<frameset rows=\"*,$hauteur_post\" frameborder=\"NO\" border=\"0\" framespacing=\"0\">"
     . "<frame name=\"mainFrame\" src=\"chat.php$option_pop\">"
     . "<frame name=\"bottomFrame\" scrolling=\"NO\" noresize src=\"post.php$option_pop\">"
     . '</frameset>'
     . '<noframes><body bgcolor="#FFFFFF" text="#000000">'
     . '</body></noframes>'
     . '</html>';

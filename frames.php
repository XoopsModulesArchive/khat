<?php

include '../../mainfile.php';
xoops_header(false);

$nblig = $_GET['nblig'] ?? 0;
$nblig = (int)$nblig;
$nbcar = $_GET['nbcar'] ?? 0;
$nbcar = (int)$nbcar;

$modepop = $_GET['modepop'] ?? 0;

if ($nblig <= 0) {
    $nblig = '10';
}

if (1 == $modepop) {
    $option_pop = "?modepop=1&nblig=$nblig";

    $hauteur_post = '40';

    $GLOBALS['xoopsOption']['template_main'] = 'khat_frames_pop.html';
} else {
    $option_pop = "?nblig=$nblig";   // options[1]

    $hauteur_post = '20';

    $GLOBALS['xoopsOption']['template_main'] = 'khat_frames.html';
}
$option_pop .= "&nbcar=$nbcar"; //options[2]

/*
echo "<html>"
."<head>"
."<title>Khat</title>"
."<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\"></meta>"
."</head>"
//."nblig in frm = $nblig et pop=$option_pop !!!<br>"
//."donc frame name=\"mainFrame\" src=\"chat.php$option_pop\"<brS>"
."<frameset rows=\"*,$hauteur_post\" frameborder=\"NO\" border=\"0\" framespacing=\"0\">"
."<frame name=\"mainFrame\" src=\"chat.php$option_pop\">"
."<frame name=\"bottomFrame\" scrolling=\"NO\" noresize src=\"post.php$option_pop\">"
."</frameset>"
."<noframes><body bgcolor=\"#FFFFFF\" text=\"#000000\">"
."</body></noframes>"
."</html>";
*/

require_once XOOPS_ROOT_PATH . '/class/template.php';
//		echo XOOPS_ROOT_PATH.'/class/template.php';
$xoopsTpl = new XoopsTpl();
/*
        echo "<pre>";
        print_r($xoopsTpl);
        echo "</pre>";
*/
//echo $xoopsTpl->getTemplateDir();
//		$xoopsTpl->setCaching(2);
//		if ($xoopsConfig['debug_mode'] == 3) {
//			$xoopsTpl->debugging=true;
//			$xoopsTpl->setDebugging(true);
//		}
$xoopsTpl->assign('options_url', $option_pop);
$xoopsTpl->assign('hauteur_post', $hauteur_post);
//		$xoopsTpl->setCaching(0);
$xoopsTpl->display('db:' . $xoopsOption['template_main']);

//echo "fin";
//	xoops_footer();

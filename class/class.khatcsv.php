<?php

// class.khatcsv.php v1.0 27/05/2003 kyex

// MANQUE: nettoyage fichier, enteteHTML

require_once XOOPS_ROOT_PATH . '/modules/khat/class/class.khat.php';

/**
 * class KhatCsv(Khat)
 *
 * { Description }
 */
class KhatCsv extends Khat
{
    /**
     * KhatCsv::KhatCsv()
     *
     * Constructeur
     *
     * @param int $id
     */
    public function __construct($id = 0)
    {
        $this->filename = XOOPS_ROOT_PATH . '/modules/khat/cache/khat.csv';

        $this->soundfile = XOOPS_ROOT_PATH . '/modules/khat/msg.wav';

        if (is_array($id)) {
            $this->makeKhat($id);
        }
    }

    /**
     * KhatCsv::AfficheLigne()
     *
     * Retourne le code HTML correspondant à la ligne passée en parametre
     *
     * @param string $s
     * @return string la ligne à afficher, en HTML
     */
    public function AfficheLigne($s)
    {
        $myts = MyTextSanitizer::getInstance();

        if ('' == $s || $s == '<?php exit; ?' . '>') {
            return '';
        }

        [$heure, $person, $message] = explode(',', $s);

        // traitement de l'heure

        $heure = formatTimestamp($heure, $this->formatdate);

        if (1 == $this->html) {
            $message = $myts->undoHtmlSpecialChars($message);
        }

        $s = '<b>' . $heure . '</b><i>' . $person . '</i>: ' . $message;

        $s = $myts->displayTarea($s, 1, $this->smiley, $this->xoopscode);

        return $s . '<br>';
    }

    public function getMessage($s)
    {
        if ('' == $s || $s == '<?php exit; ?' . '>') {
            return '';
        }

        [$heure, $person, $message] = explode(',', $s);

        return $message;
    }

    public function getUser($s)
    {
        if ('' == $s || $s == '<?php exit; ?' . '>') {
            return '';
        }

        [$heure, $person, $message] = explode(',', $s);

        return $person;
    }

    public function getUid($s)
    {
        if ('' == $s || $s == '<?php exit; ?' . '>') {
            return 0;
        }

        $db = XoopsDatabaseFactory::getDatabaseConnection();

        $s = $this->getUser($s);

        $sql = 'SELECT uid FROM ' . $db->prefix('users') . " WHERE uname='$s'";

        $res = $db->query($sql);

        if (0 == $res) {
            return 0;
        }

        $row = $db->fetchArray($res);

        return $row['uid'];
    }

    public function getHeure($s)
    {
        if ('' == $s || $s == '<?php exit; ?' . '>') {
            return '';
        }

        [$heure, $person, $message] = explode(',', $s);

        return $heure;
    }

    /**
     * KhatCsv::getAllLines()
     *
     * Retourne le code HTML correspondant aux $length derniers messgaes écris
     *
     * @param int $length
     * @return string contenu du chat
     */
    public function getAllLines($length = 5)
    {
        $content = '';

        $lines = file($this->filename);

        $a = count($lines);

        $u = $a - $length;

        if ($u < 0) {
            $u = 0;
        }

        if ('bas' == $this->nouveauxmsg) {
            for ($i = $u; $i < $a; $i++) {
                $content .= $this->AfficheLigne(rtrim($lines[$i]));
            }
        } else {
            for ($i = $a - 1; $i >= $u; $i--) {
                $content .= $this->AfficheLigne(rtrim($lines[$i]));
            }
        }

        return $content;
    }

    /**
     * KhatCsv::lastMessageDate()
     *
     * Retourne la date du dernier message écrit (au format Unix), cela correspond à la date de modif du fichier de stockage.
     *
     * @return int date dernier message
     */
    public function lastMessageDate()
    {
        return filemtime($this->filename);
    }

    /**
     * KhatCsv::store()
     *
     * Sauve le message dans la fichier CSV
     */
    public function store()
    {
        $myts = MyTextSanitizer::getInstance();

        $message = $this->message;

        $message = htmlspecialchars($message, ENT_QUOTES | ENT_HTML5);

        $message = $myts->stripSlashesGPC($message);

        $message = str_replace(',', '&#44', $message);  // on virre les , et on met le code ASCII

        if ('' != $message) {
            // ecriture de l'heure au format time unix standard pour Xoops

            $s = implode(',', [time(), $this->getPersonString(), $message]);

            $fp = fopen($this->filename, 'a+b');

            $fw = fwrite($fp, $s . "\n");

            fclose($fp);

            $this->nettoyage();
        }
    }

    /**
     * KhatSql::nettoyage()
     *
     * Supprime de la base les lignes trop ancienne
     */
    public function nettoyage()
    {
        $lignes = file($this->filename);

        $nblignes = count($lignes);

        if ($nblignes > $this->maxlignes) {
            // on garde les dernieres lignes => on recupere la date de la premiere ligne a garder

            $premiereligne = $nblignes - $this->minlignes;

            $deleted = unlink($this->filename);

            $fp = fopen($this->filename, 'wb');

            for ($i = $premiereligne; $i < $nblignes; $i++) {
                fwrite($fp, $lignes[$i]);
            }

            fclose($fp);
        }
    }

    public function search($queryarray, $andor, $limit, $offset, $userid)
    {
        $lignes = file($this->filename);

        $ret = [];

        $nblignes = count($lignes);

        $i = 0;

        foreach ($lignes as $num => $ligne) {
            [$heure, $person, $message] = explode(',', $ligne);

            if (mb_stristr($message, $queryarray[0])) {
                $ret[$i]['link'] = 'index.php?op=archive&lig=' . $num . '';

                $ret[$i]['title'] = $message;

                $ret[$i]['time'] = $heure;

                $ret[$i]['uid'] = $this->getUid($ligne);

                $i++;
            }
        }

        return $ret;
    }
}




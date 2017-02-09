<?php
/**
* Gestion des langages
* Côté serveur : gestion des traductions avec gettext
* Utilisation de Poedit et de fichiers de traduction
*/
if(!isset($_SESSION['lang'])){
    $_SESSION['lang'] = 'fr_FR';
}
if(isset($_GET['lang'])){
    if(in_array($_GET['lang'], AVAILABLE_LANG)){
        $_SESSION['lang'] = $_GET['lang'];
    }
}

// nom du dossier (ici le même que la langue)
$domain = $_SESSION['lang'];

putenv('LANG='.$_SESSION['lang']);
setlocale(LC_MESSAGES, $_SESSION['lang']);
bindtextdomain($domain, './locale');
bind_textdomain_codeset($domain, 'UTF-8');
textdomain($domain);
#clearstatcache();

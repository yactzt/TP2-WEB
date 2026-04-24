<?php
session_start();

$pages_valides = ['accueil', 'tp3', 'tp4', 'tp5', 'tp6', 'tp7', 'tranquillite'];
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

if (!in_array($page, $pages_valides)) {
    $page = 'accueil';
}

$page_active = $page;

$titres = [
    'accueil'       => 'Accueil - B1WEB Yacine Tarzout',
    'tp3'           => 'TP3 - HTML5',
    'tp4'           => 'TP4 - CSS & JS',
    'tp5'           => 'TP5 - CSS Avanc&eacute;',
    'tp6'           => 'TP6 - Galerie',
    'tp7'           => 'TP7 - Zoning',
    'tranquillite'  => 'Tranquillit&eacute; Vacances',
];

$page_titre = isset($titres[$page]) ? $titres[$page] : 'B1WEB';

include 'header.php';
include 'pages/' . $page . '.php';
include 'footer.php';
?>

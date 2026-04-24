<?php
if (!isset($page_active)) {
    $page_active = 'accueil';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_titre) ? htmlspecialchars($page_titre) : 'B1WEB - Yacine Tarzout'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <canvas id="particles"></canvas>

    <header class="site-header">
        <nav class="nav-container">
            <a href="index.php" class="nav-logo">
                <span class="logo-icon">YT</span>
                B1WEB
            </a>
            <ul class="nav-links">
                <li><a href="index.php" class="<?php echo $page_active === 'accueil' ? 'active' : ''; ?>">Accueil</a></li>
                <li><a href="index.php?page=tp3" class="<?php echo $page_active === 'tp3' ? 'active' : ''; ?>">TP3</a></li>
                <li><a href="index.php?page=tp4" class="<?php echo $page_active === 'tp4' ? 'active' : ''; ?>">TP4</a></li>
                <li><a href="index.php?page=tp5" class="<?php echo $page_active === 'tp5' ? 'active' : ''; ?>">TP5</a></li>
                <li><a href="index.php?page=tp6" class="<?php echo $page_active === 'tp6' ? 'active' : ''; ?>">TP6</a></li>
                <li><a href="index.php?page=tp7" class="<?php echo $page_active === 'tp7' ? 'active' : ''; ?>">TP7</a></li>
                <li><a href="index.php?page=tranquillite" class="<?php echo $page_active === 'tranquillite' ? 'active' : ''; ?>">Tranquillit&eacute; Vacances</a></li>
            </ul>
        </nav>
    </header>

    <main class="site-main">

<h1 class="page-title">Op&eacute;ration Tranquillit&eacute; Vacances</h1>
<p class="page-subtitle">Faites surveiller votre domicile pendant vos vacances</p>

<?php
$form = isset($_GET['form']) ? $_GET['form'] : 'inscription';
if (!in_array($form, ['inscription', 'connexion', 'demande'])) {
    $form = 'inscription';
}
?>

<div class="tabs">
    <a href="index.php?page=tranquillite&form=inscription" class="tab-link <?php echo $form === 'inscription' ? 'active' : ''; ?>">Cr&eacute;er un compte</a>
    <a href="index.php?page=tranquillite&form=connexion" class="tab-link <?php echo $form === 'connexion' ? 'active' : ''; ?>">Se connecter</a>
    <a href="index.php?page=tranquillite&form=demande" class="tab-link <?php echo $form === 'demande' ? 'active' : ''; ?>">Faire une demande</a>
</div>

<?php
if ($form === 'inscription') {
    include 'forms/inscription.php';
} elseif ($form === 'connexion') {
    include 'forms/connexion.php';
} elseif ($form === 'demande') {
    include 'forms/demande.php';
}
?>

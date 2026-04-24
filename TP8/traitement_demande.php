<?php
session_start();
require_once 'config.php';

$page_active = 'tranquillite';
$page_titre = 'Résultat demande';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?page=tranquillite&form=demande');
    exit;
}

$date_debut = $_POST['date_debut'] ?? '';
$date_fin = $_POST['date_fin'] ?? '';
$contact_nom = trim($_POST['contact_nom'] ?? '');
$contact_telephone = trim($_POST['contact_telephone'] ?? '');

$erreurs = [];

if (empty($date_debut)) {
    $erreurs[] = 'La date de début est requise.';
}
if (empty($date_fin)) {
    $erreurs[] = 'La date de fin est requise.';
}
if (!empty($date_debut) && !empty($date_fin) && $date_fin < $date_debut) {
    $erreurs[] = 'La date de fin doit être postérieure à la date de début.';
}
if (empty($contact_nom) || strlen($contact_nom) < 2) {
    $erreurs[] = 'Le nom du contact doit contenir au moins 2 caractères.';
}
if (!preg_match('/^[0-9]{10}$/', $contact_telephone)) {
    $erreurs[] = 'Le téléphone du contact doit contenir exactement 10 chiffres.';
}

include 'header.php';

if (!empty($erreurs)) {
    echo '<div class="result-box">';
    echo '<h2>Erreurs</h2>';
    echo '<div class="alert alert-error"><ul>';
    foreach ($erreurs as $err) {
        echo '<li>' . htmlspecialchars($err) . '</li>';
    }
    echo '</ul></div>';
    echo '<p style="text-align:center;margin-top:1rem;"><a href="index.php?page=tranquillite&form=demande" class="tab-link">Retour</a></p>';
    echo '</div>';
} else {
    // TP9b : Enregistrement en base de données
    $id_utilisateur = $_SESSION['user_id'] ?? null;

    if ($id_utilisateur) {
        try {
            $pdo = getConnexion();
            $stmt = $pdo->prepare('INSERT INTO demande (date_debut, date_fin, contact_nom, contact_telephone, id_utilisateur) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$date_debut, $date_fin, $contact_nom, $contact_telephone, $id_utilisateur]);

            echo '<div class="alert alert-success" style="max-width:600px;margin:0 auto 1.5rem;">Demande enregistrée avec succès !</div>';
        } catch (PDOException $e) {
            echo '<div class="alert alert-error" style="max-width:600px;margin:0 auto 1.5rem;">Erreur : ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    } else {
        echo '<div class="alert alert-info" style="max-width:600px;margin:0 auto 1.5rem;">Vous devez être connecté pour enregistrer une demande en base de données.</div>';
    }

    // Affichage des données (TP9a)
    echo '<div class="result-box">';
    echo '<h2>Récapitulatif de la demande</h2>';
    echo '<table class="result-table">';
    echo '<tr><th>Date de début</th><td>' . htmlspecialchars($date_debut) . '</td></tr>';
    echo '<tr><th>Date de fin</th><td>' . htmlspecialchars($date_fin) . '</td></tr>';
    echo '<tr><th>Contact (nom)</th><td>' . htmlspecialchars($contact_nom) . '</td></tr>';
    echo '<tr><th>Contact (téléphone)</th><td>' . htmlspecialchars($contact_telephone) . '</td></tr>';
    echo '</table>';
    echo '<p style="text-align:center;margin-top:1.5rem;"><a href="index.php?page=tranquillite" class="tab-link">Retour</a></p>';
    echo '</div>';
}

include 'footer.php';
?>

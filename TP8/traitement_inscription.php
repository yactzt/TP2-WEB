<?php
session_start();
require_once 'config.php';

$page_active = 'tranquillite';
$page_titre = 'Résultat inscription';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?page=tranquillite&form=inscription');
    exit;
}

$nom = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$adresse = trim($_POST['adresse'] ?? '');
$telephone = trim($_POST['telephone'] ?? '');
$email = trim($_POST['email'] ?? '');
$mot_de_passe = $_POST['mot_de_passe'] ?? '';
$confirm_mdp = $_POST['confirm_mdp'] ?? '';

$erreurs = [];

if (empty($nom) || strlen($nom) < 2) {
    $erreurs[] = 'Le nom doit contenir au moins 2 caractères.';
}
if (empty($prenom) || strlen($prenom) < 2) {
    $erreurs[] = 'Le prénom doit contenir au moins 2 caractères.';
}
if (empty($adresse) || strlen($adresse) < 5) {
    $erreurs[] = 'L\'adresse doit contenir au moins 5 caractères.';
}
if (!preg_match('/^[0-9]{10}$/', $telephone)) {
    $erreurs[] = 'Le téléphone doit contenir exactement 10 chiffres.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreurs[] = 'L\'adresse email n\'est pas valide.';
}
if (strlen($mot_de_passe) < 6) {
    $erreurs[] = 'Le mot de passe doit contenir au moins 6 caractères.';
}
if ($mot_de_passe !== $confirm_mdp) {
    $erreurs[] = 'Les mots de passe ne correspondent pas.';
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
    echo '<p style="text-align:center;margin-top:1rem;"><a href="index.php?page=tranquillite&form=inscription" class="tab-link">Retour au formulaire</a></p>';
    echo '</div>';
} else {
    // TP9b : Enregistrement en base de données
    try {
        $pdo = getConnexion();
        $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare('INSERT INTO utilisateur (nom, prenom, adresse, telephone, email, mot_de_passe) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$nom, $prenom, $adresse, $telephone, $email, $hash]);

        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['user_nom'] = $nom;
        $_SESSION['user_prenom'] = $prenom;

        echo '<div class="alert alert-success" style="max-width:600px;margin:0 auto 1.5rem;">Compte créé avec succès !</div>';
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo '<div class="alert alert-error" style="max-width:600px;margin:0 auto 1.5rem;">Cet email est déjà utilisé.</div>';
        } else {
            echo '<div class="alert alert-error" style="max-width:600px;margin:0 auto 1.5rem;">Erreur lors de l\'inscription : ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }

    // Affichage des données (TP9a)
    echo '<div class="result-box">';
    echo '<h2>Récapitulatif de l\'inscription</h2>';
    echo '<table class="result-table">';
    echo '<tr><th>Nom</th><td>' . htmlspecialchars($nom) . '</td></tr>';
    echo '<tr><th>Prénom</th><td>' . htmlspecialchars($prenom) . '</td></tr>';
    echo '<tr><th>Adresse</th><td>' . htmlspecialchars($adresse) . '</td></tr>';
    echo '<tr><th>Téléphone</th><td>' . htmlspecialchars($telephone) . '</td></tr>';
    echo '<tr><th>Email</th><td>' . htmlspecialchars($email) . '</td></tr>';
    echo '</table>';
    echo '<p style="text-align:center;margin-top:1.5rem;"><a href="index.php?page=tranquillite&form=connexion" class="tab-link">Se connecter</a></p>';
    echo '</div>';
}

include 'footer.php';
?>

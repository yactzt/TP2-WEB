<?php
session_start();
require_once 'config.php';

$page_active = 'tranquillite';
$page_titre = 'Résultat connexion';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?page=tranquillite&form=connexion');
    exit;
}

$email = trim($_POST['email'] ?? '');
$mot_de_passe = $_POST['mot_de_passe'] ?? '';

$erreurs = [];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreurs[] = 'L\'adresse email n\'est pas valide.';
}
if (empty($mot_de_passe)) {
    $erreurs[] = 'Le mot de passe est requis.';
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
    echo '<p style="text-align:center;margin-top:1rem;"><a href="index.php?page=tranquillite&form=connexion" class="tab-link">Retour</a></p>';
    echo '</div>';
} else {
    // TP9b : Vérification en base de données
    try {
        $pdo = getConnexion();
        $stmt = $pdo->prepare('SELECT * FROM utilisateur WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            $_SESSION['user_id'] = $user['id_utilisateur'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_prenom'] = $user['prenom'];

            echo '<div class="alert alert-success" style="max-width:600px;margin:0 auto 1.5rem;">Connexion réussie !</div>';
            echo '<div class="result-box">';
            echo '<h2>Bienvenue ' . htmlspecialchars($user['prenom']) . ' ' . htmlspecialchars($user['nom']) . '</h2>';
            echo '<table class="result-table">';
            echo '<tr><th>Nom</th><td>' . htmlspecialchars($user['nom']) . '</td></tr>';
            echo '<tr><th>Prénom</th><td>' . htmlspecialchars($user['prenom']) . '</td></tr>';
            echo '<tr><th>Email</th><td>' . htmlspecialchars($user['email']) . '</td></tr>';
            echo '<tr><th>Adresse</th><td>' . htmlspecialchars($user['adresse']) . '</td></tr>';
            echo '<tr><th>Téléphone</th><td>' . htmlspecialchars($user['telephone']) . '</td></tr>';
            echo '</table>';
            echo '<p style="text-align:center;margin-top:1.5rem;"><a href="index.php?page=tranquillite&form=demande" class="tab-link">Faire une demande</a></p>';
            echo '</div>';
        } else {
            echo '<div class="alert alert-error" style="max-width:600px;margin:0 auto 1.5rem;">Email ou mot de passe incorrect.</div>';
            echo '<p style="text-align:center;"><a href="index.php?page=tranquillite&form=connexion" class="tab-link">Retour</a></p>';
        }
    } catch (PDOException $e) {
        // Fallback TP9a : affichage simple sans BDD
        echo '<div class="result-box">';
        echo '<h2>Données de connexion reçues</h2>';
        echo '<table class="result-table">';
        echo '<tr><th>Email</th><td>' . htmlspecialchars($email) . '</td></tr>';
        echo '<tr><th>Mot de passe</th><td>(masqué)</td></tr>';
        echo '</table>';
        echo '<p style="text-align:center;margin-top:1rem;color:var(--text-muted);font-size:0.85rem;">Base de données non disponible &ndash; affichage des données uniquement.</p>';
        echo '</div>';
    }
}

include 'footer.php';
?>

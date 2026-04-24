<?php
session_start();
require_once 'config.php';

$page_active = '';
$page_titre = 'Administration';

// Traitement du login admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_login'])) {
    $login = trim($_POST['login'] ?? '');
    $mdp = $_POST['mot_de_passe'] ?? '';

    try {
        $pdo = getConnexion();
        $stmt = $pdo->prepare('SELECT * FROM admin WHERE login = ?');
        $stmt->execute([$login]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($mdp, $admin['mot_de_passe'])) {
            $_SESSION['admin_id'] = $admin['id_admin'];
            $_SESSION['admin_login'] = $admin['login'];
        } else {
            $erreur_login = 'Login ou mot de passe incorrect.';
        }
    } catch (PDOException $e) {
        $erreur_login = 'Erreur de connexion à la base de données.';
    }
}

// Déconnexion
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['admin_id']);
    unset($_SESSION['admin_login']);
    header('Location: admin.php');
    exit;
}

include 'header.php';

if (!isset($_SESSION['admin_id'])) {
    // Formulaire de connexion admin
    ?>
    <h1 class="page-title">Administration</h1>
    <p class="page-subtitle">Acc&egrave;s r&eacute;serv&eacute; &agrave; l'administrateur</p>

    <?php if (isset($erreur_login)): ?>
        <div class="alert alert-error" style="max-width:400px;margin:0 auto 1.5rem;">
            <?php echo htmlspecialchars($erreur_login); ?>
        </div>
    <?php endif; ?>

    <div class="form-container" style="max-width:400px;">
        <h2>Connexion administrateur</h2>
        <form method="POST" action="admin.php">
            <input type="hidden" name="admin_login" value="1">
            <div class="form-group">
                <label for="login">Login</label>
                <input type="text" id="login" name="login" required placeholder="admin">
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required placeholder="Mot de passe">
            </div>
            <button type="submit" class="btn-submit">Se connecter</button>
        </form>
    </div>
    <?php
} else {
    // Interface admin
    $pdo = getConnexion();
    ?>
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:2rem;">
        <h1 class="page-title" style="margin-bottom:0;">Tableau de bord</h1>
        <div>
            <span style="color:var(--text-muted);font-size:0.85rem;">Connect&eacute; : <strong><?php echo htmlspecialchars($_SESSION['admin_login']); ?></strong></span>
            <a href="admin.php?action=logout" class="btn-logout">D&eacute;connexion</a>
        </div>
    </div>

    <div class="tabs" style="justify-content:flex-start;">
        <a href="admin.php" class="tab-link <?php echo !isset($_GET['vue']) ? 'active' : ''; ?>">Demandes</a>
        <a href="admin.php?vue=agents" class="tab-link <?php echo (isset($_GET['vue']) && $_GET['vue'] === 'agents') ? 'active' : ''; ?>">Agents &amp; Affectations</a>
        <a href="admin.php?vue=utilisateurs" class="tab-link <?php echo (isset($_GET['vue']) && $_GET['vue'] === 'utilisateurs') ? 'active' : ''; ?>">Utilisateurs</a>
    </div>

    <?php
    $vue = $_GET['vue'] ?? 'demandes';

    if ($vue === 'agents') {
        include 'admin_agents.php';
    } elseif ($vue === 'utilisateurs') {
        // Liste des utilisateurs
        $stmt = $pdo->query('SELECT * FROM utilisateur ORDER BY nom, prenom');
        $utilisateurs = $stmt->fetchAll();
        ?>
        <div class="content-section">
            <h2>Utilisateurs inscrits (<?php echo count($utilisateurs); ?>)</h2>
            <?php if (empty($utilisateurs)): ?>
                <p>Aucun utilisateur inscrit.</p>
            <?php else: ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Pr&eacute;nom</th>
                            <th>Email</th>
                            <th>T&eacute;l&eacute;phone</th>
                            <th>Adresse</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($utilisateurs as $u): ?>
                        <tr>
                            <td><?php echo $u['id_utilisateur']; ?></td>
                            <td><?php echo htmlspecialchars($u['nom']); ?></td>
                            <td><?php echo htmlspecialchars($u['prenom']); ?></td>
                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                            <td><?php echo htmlspecialchars($u['telephone']); ?></td>
                            <td><?php echo htmlspecialchars($u['adresse']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <?php
    } else {
        // Liste des demandes
        $stmt = $pdo->query('
            SELECT d.*, u.nom AS u_nom, u.prenom AS u_prenom, u.adresse AS u_adresse, u.email AS u_email
            FROM demande d
            JOIN utilisateur u ON d.id_utilisateur = u.id_utilisateur
            ORDER BY d.date_debut DESC
        ');
        $demandes = $stmt->fetchAll();
        ?>
        <div class="content-section">
            <h2>Demandes de surveillance (<?php echo count($demandes); ?>)</h2>
            <?php if (empty($demandes)): ?>
                <p>Aucune demande enregistr&eacute;e.</p>
            <?php else: ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Demandeur</th>
                            <th>Adresse</th>
                            <th>D&eacute;but</th>
                            <th>Fin</th>
                            <th>Contact urgence</th>
                            <th>T&eacute;l. contact</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($demandes as $d):
                            // Vérifier si un agent est affecté
                            $stmtAff = $pdo->prepare('SELECT COUNT(*) FROM affectation WHERE id_demande = ?');
                            $stmtAff->execute([$d['id_demande']]);
                            $nbAffectations = $stmtAff->fetchColumn();
                        ?>
                        <tr>
                            <td><?php echo $d['id_demande']; ?></td>
                            <td><?php echo htmlspecialchars($d['u_prenom'] . ' ' . $d['u_nom']); ?></td>
                            <td><?php echo htmlspecialchars($d['u_adresse']); ?></td>
                            <td><?php echo htmlspecialchars($d['date_debut']); ?></td>
                            <td><?php echo htmlspecialchars($d['date_fin']); ?></td>
                            <td><?php echo htmlspecialchars($d['contact_nom']); ?></td>
                            <td><?php echo htmlspecialchars($d['contact_telephone']); ?></td>
                            <td>
                                <?php if ($nbAffectations > 0): ?>
                                    <span class="badge badge-success">Agent affect&eacute;</span>
                                <?php else: ?>
                                    <span class="badge badge-pending">En attente</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <?php
    }
}

include 'footer.php';
?>

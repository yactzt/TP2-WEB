<?php
// Ce fichier est inclus depuis admin.php (l'admin est déjà authentifié)

// Traitement : Ajouter un agent
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_agent'])) {
    if ($_POST['action_agent'] === 'ajouter') {
        $nom = trim($_POST['agent_nom'] ?? '');
        $prenom = trim($_POST['agent_prenom'] ?? '');
        $matricule = trim($_POST['agent_matricule'] ?? '');
        if (!empty($nom) && !empty($prenom) && !empty($matricule)) {
            try {
                $stmt = $pdo->prepare('INSERT INTO agent (nom, prenom, matricule) VALUES (?, ?, ?)');
                $stmt->execute([$nom, $prenom, $matricule]);
                echo '<div class="alert alert-success">Agent ajouté avec succès.</div>';
            } catch (PDOException $e) {
                echo '<div class="alert alert-error">Erreur : ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
        }
    }
}

// Traitement : Affecter un agent à une demande
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_affectation'])) {
    $id_demande = intval($_POST['id_demande'] ?? 0);
    $id_agent = intval($_POST['id_agent'] ?? 0);
    $date_passage = $_POST['date_passage'] ?? '';
    $commentaire = trim($_POST['commentaire'] ?? '');

    if ($id_demande > 0 && $id_agent > 0 && !empty($date_passage)) {
        try {
            $stmt = $pdo->prepare('INSERT INTO affectation (date_passage, id_demande, id_agent, commentaire) VALUES (?, ?, ?, ?)');
            $stmt->execute([$date_passage, $id_demande, $id_agent, $commentaire]);
            echo '<div class="alert alert-success">Agent affecté avec succès.</div>';
        } catch (PDOException $e) {
            echo '<div class="alert alert-error">Erreur : ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    } else {
        echo '<div class="alert alert-error">Veuillez remplir tous les champs obligatoires.</div>';
    }
}

// Récupérer les données
$agents = $pdo->query('SELECT * FROM agent ORDER BY nom, prenom')->fetchAll();
$demandes_dispo = $pdo->query('
    SELECT d.id_demande, d.date_debut, d.date_fin, u.nom, u.prenom, u.adresse
    FROM demande d
    JOIN utilisateur u ON d.id_utilisateur = u.id_utilisateur
    ORDER BY d.date_debut
')->fetchAll();

$affectations = $pdo->query('
    SELECT af.*, d.date_debut, d.date_fin, u.nom AS u_nom, u.prenom AS u_prenom, u.adresse,
           a.nom AS a_nom, a.prenom AS a_prenom, a.matricule
    FROM affectation af
    JOIN demande d ON af.id_demande = d.id_demande
    JOIN utilisateur u ON d.id_utilisateur = u.id_utilisateur
    JOIN agent a ON af.id_agent = a.id_agent
    ORDER BY af.date_passage DESC
')->fetchAll();
?>

<!-- Liste des agents -->
<div class="content-section">
    <h2>Agents (<?php echo count($agents); ?>)</h2>
    <?php if (!empty($agents)): ?>
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Pr&eacute;nom</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agents as $a): ?>
            <tr>
                <td><?php echo $a['id_agent']; ?></td>
                <td><?php echo htmlspecialchars($a['matricule']); ?></td>
                <td><?php echo htmlspecialchars($a['nom']); ?></td>
                <td><?php echo htmlspecialchars($a['prenom']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>Aucun agent enregistr&eacute;.</p>
    <?php endif; ?>
</div>

<!-- Ajouter un agent -->
<div class="content-section">
    <h2>Ajouter un agent</h2>
    <form method="POST" action="admin.php?vue=agents" style="max-width:500px;">
        <input type="hidden" name="action_agent" value="ajouter">
        <div class="form-row">
            <div class="form-group">
                <label for="agent_nom">Nom *</label>
                <input type="text" id="agent_nom" name="agent_nom" required>
            </div>
            <div class="form-group">
                <label for="agent_prenom">Pr&eacute;nom *</label>
                <input type="text" id="agent_prenom" name="agent_prenom" required>
            </div>
        </div>
        <div class="form-group">
            <label for="agent_matricule">Matricule *</label>
            <input type="text" id="agent_matricule" name="agent_matricule" required placeholder="Ex: AG004">
        </div>
        <button type="submit" class="btn-submit">Ajouter l'agent</button>
    </form>
</div>

<!-- Affecter un agent -->
<div class="content-section">
    <h2>Affecter un agent &agrave; une demande</h2>
    <?php if (empty($demandes_dispo)): ?>
        <p>Aucune demande disponible.</p>
    <?php elseif (empty($agents)): ?>
        <p>Aucun agent disponible. Ajoutez d'abord un agent.</p>
    <?php else: ?>
    <form method="POST" action="admin.php?vue=agents" style="max-width:500px;">
        <input type="hidden" name="action_affectation" value="1">
        <div class="form-group">
            <label for="id_demande">Demande *</label>
            <select id="id_demande" name="id_demande" required>
                <option value="">-- S&eacute;lectionner --</option>
                <?php foreach ($demandes_dispo as $d): ?>
                <option value="<?php echo $d['id_demande']; ?>">
                    #<?php echo $d['id_demande']; ?> &ndash; <?php echo htmlspecialchars($d['prenom'] . ' ' . $d['nom']); ?>
                    (<?php echo $d['date_debut']; ?> au <?php echo $d['date_fin']; ?>)
                    &ndash; <?php echo htmlspecialchars($d['adresse']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_agent">Agent *</label>
            <select id="id_agent" name="id_agent" required>
                <option value="">-- S&eacute;lectionner --</option>
                <?php foreach ($agents as $a): ?>
                <option value="<?php echo $a['id_agent']; ?>">
                    <?php echo htmlspecialchars($a['matricule'] . ' - ' . $a['prenom'] . ' ' . $a['nom']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="date_passage">Date de passage *</label>
            <input type="date" id="date_passage" name="date_passage" required>
        </div>
        <div class="form-group">
            <label for="commentaire">Commentaire</label>
            <textarea id="commentaire" name="commentaire" rows="3" placeholder="Observations, consignes..."></textarea>
        </div>
        <button type="submit" class="btn-submit">Affecter l'agent</button>
    </form>
    <?php endif; ?>
</div>

<!-- Affectations existantes -->
<div class="content-section">
    <h2>Affectations en cours (<?php echo count($affectations); ?>)</h2>
    <?php if (!empty($affectations)): ?>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Date passage</th>
                <th>Agent</th>
                <th>Demandeur</th>
                <th>Adresse</th>
                <th>P&eacute;riode</th>
                <th>Commentaire</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($affectations as $af): ?>
            <tr>
                <td><?php echo htmlspecialchars($af['date_passage']); ?></td>
                <td><?php echo htmlspecialchars($af['a_prenom'] . ' ' . $af['a_nom'] . ' (' . $af['matricule'] . ')'); ?></td>
                <td><?php echo htmlspecialchars($af['u_prenom'] . ' ' . $af['u_nom']); ?></td>
                <td><?php echo htmlspecialchars($af['adresse']); ?></td>
                <td><?php echo $af['date_debut'] . ' au ' . $af['date_fin']; ?></td>
                <td><?php echo htmlspecialchars($af['commentaire'] ?? ''); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>Aucune affectation enregistr&eacute;e.</p>
    <?php endif; ?>
</div>

<div class="form-container">
    <h2>Cr&eacute;ation de compte</h2>
    <form action="traitement_inscription.php" method="POST">
        <div class="form-row">
            <div class="form-group">
                <label for="nom">Nom *</label>
                <input type="text" id="nom" name="nom" required minlength="2" maxlength="50" placeholder="Votre nom">
            </div>
            <div class="form-group">
                <label for="prenom">Pr&eacute;nom *</label>
                <input type="text" id="prenom" name="prenom" required minlength="2" maxlength="50" placeholder="Votre pr&eacute;nom">
            </div>
        </div>

        <div class="form-group">
            <label for="adresse">Adresse *</label>
            <input type="text" id="adresse" name="adresse" required minlength="5" maxlength="200" placeholder="Votre adresse compl&egrave;te">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="telephone">T&eacute;l&eacute;phone *</label>
                <input type="tel" id="telephone" name="telephone" required pattern="[0-9]{10}" placeholder="0600000000" title="Num&eacute;ro &agrave; 10 chiffres">
            </div>
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required placeholder="votre@email.fr">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe *</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required minlength="6" placeholder="Minimum 6 caract&egrave;res">
            </div>
            <div class="form-group">
                <label for="confirm_mdp">Confirmer le mot de passe *</label>
                <input type="password" id="confirm_mdp" name="confirm_mdp" required minlength="6" placeholder="Confirmez votre mot de passe">
            </div>
        </div>

        <button type="submit" class="btn-submit">Cr&eacute;er mon compte</button>
    </form>
</div>

<div class="form-container">
    <h2>Connexion</h2>
    <form action="traitement_connexion.php" method="POST">
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" required placeholder="votre@email.fr">
        </div>

        <div class="form-group">
            <label for="mot_de_passe">Mot de passe *</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required minlength="6" placeholder="Votre mot de passe">
        </div>

        <button type="submit" class="btn-submit">Se connecter</button>
    </form>
</div>

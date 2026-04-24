<div class="form-container">
    <h2>Demande de surveillance</h2>
    <p style="color: var(--text-muted); font-size: 0.85rem; text-align: center; margin-bottom: 1.5rem;">
        Remplissez ce formulaire pour demander une surveillance de votre domicile pendant vos vacances.
    </p>
    <form action="traitement_demande.php" method="POST">
        <div class="form-row">
            <div class="form-group">
                <label for="date_debut">Date de d&eacute;but *</label>
                <input type="date" id="date_debut" name="date_debut" required>
            </div>
            <div class="form-group">
                <label for="date_fin">Date de fin *</label>
                <input type="date" id="date_fin" name="date_fin" required>
            </div>
        </div>

        <div class="form-group">
            <label for="contact_nom">Nom du contact en cas d'urgence *</label>
            <input type="text" id="contact_nom" name="contact_nom" required minlength="2" maxlength="100" placeholder="Nom complet du contact">
        </div>

        <div class="form-group">
            <label for="contact_telephone">T&eacute;l&eacute;phone du contact *</label>
            <input type="tel" id="contact_telephone" name="contact_telephone" required pattern="[0-9]{10}" placeholder="0600000000" title="Num&eacute;ro &agrave; 10 chiffres">
        </div>

        <button type="submit" class="btn-submit">Envoyer la demande</button>
    </form>
</div>

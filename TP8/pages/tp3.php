<h1 class="page-title">TP 3 &ndash; M&eacute;mento HTML5</h1>
<p class="page-subtitle">Balises de texte, listes, tableaux et CV</p>

<div class="content-section">
    <h2>Balises de titres</h2>
    <p>Les balises <code>&lt;h1&gt;</code> &agrave; <code>&lt;h6&gt;</code> permettent de structurer le contenu avec diff&eacute;rents niveaux de titres.</p>
</div>

<div class="content-section">
    <h2>Balises de texte</h2>
    <ul>
        <li><code>&lt;p&gt;</code> &ndash; Paragraphe</li>
        <li><code>&lt;strong&gt;</code> &ndash; Texte important : <strong>texte important</strong></li>
        <li><code>&lt;em&gt;</code> &ndash; Emphase : <em>texte en italique</em></li>
        <li><code>&lt;mark&gt;</code> &ndash; Surlignage : <mark>texte surligné</mark></li>
        <li><code>&lt;br&gt;</code> &ndash; Retour &agrave; la ligne</li>
    </ul>
</div>

<div class="content-section">
    <h2>Les listes</h2>
    <h3>Liste non ordonn&eacute;e</h3>
    <ul>
        <li>HTML</li>
        <li>CSS</li>
        <li>SQL</li>
    </ul>
    <h3>Liste ordonn&eacute;e</h3>
    <ol>
        <li>Analyse</li>
        <li>D&eacute;veloppement</li>
        <li>Tests</li>
    </ol>
</div>

<div class="content-section">
    <h2>Le langage SQL</h2>
    <p>Le langage SQL (<strong>Structured Query Language</strong>) est un langage comprenant l'ensemble des ordres n&eacute;cessaires &agrave; la cr&eacute;ation et &agrave; la gestion d'une base de donn&eacute;es relationnelle.</p>
    <p>Il a &eacute;t&eacute; cr&eacute;&eacute; en 1986 et est l'aboutissement de plusieurs langages cr&eacute;&eacute;s depuis l'apparition du mod&egrave;le relationnel en 1970 (invent&eacute; par <strong>Mr Codd</strong>, math&eacute;maticien chez IBM).</p>
    <h3>Normes SQL</h3>
    <ul>
        <li>SQL 89</li>
        <li>SQL 92</li>
        <li>SQL 2011</li>
    </ul>
</div>

<div class="content-section">
    <h2>Mod&egrave;le de donn&eacute;es</h2>
    <h3>Tables utilis&eacute;es</h3>
    <table>
        <thead>
            <tr>
                <th>Table</th>
                <th>Cl&eacute; primaire</th>
                <th>Colonnes</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>fonction_personnel</td>
                <td>code_fonction</td>
                <td>code_fonction, libelle_fonction</td>
            </tr>
            <tr>
                <td>service</td>
                <td>num_service</td>
                <td>num_service, libelle_service, capacite_accueil, date_ouverture</td>
            </tr>
        </tbody>
    </table>
</div>

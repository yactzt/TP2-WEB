# Rapport TP5 - Zoning d'une page Web

## Introduction
Ce rapport présente la réalisation du TP5 concernant le zoning d'une page web, en se basant sur les exercices fournis. L'objectif est de comprendre et d'appliquer les principes de structuration d'une page web à l'aide de HTML et CSS.

## Exercice 1 : Analyse de la structure HTML

L'exercice 1 nous a demandé d'analyser la structure d'une page web et d'identifier les balises utilisées pour le zoning. En nous basant sur l'article "Apprenez les bases du HTML" [1], nous avons pu identifier les éléments clés suivants :

- **`<!DOCTYPE html>`** : Cette déclaration, placée en début de document, est cruciale pour indiquer au navigateur la version de HTML utilisée et garantir un rendu standardisé de la page. Son absence peut entraîner un mode de rendu "Quirks" qui peut varier d'un navigateur à l'autre.
- **`<html>`** : C'est la balise racine de tout document HTML. Elle englobe l'intégralité du contenu de la page.
- **`<head>`** : Cette section contient les métadonnées du document, telles que le titre de la page (`<title>`), l'encodage des caractères (`<meta charset="UTF-8">`), les liens vers les feuilles de style CSS (`<link rel="stylesheet" href="style.css">`), et d'autres informations non directement visibles par l'utilisateur mais essentielles au bon fonctionnement et au référencement de la page.
- **`<body>`** : Cette balise contient tout le contenu visible de la page web, c'est-à-dire ce que l'utilisateur voit et interagit avec (texte, images, liens, formulaires, etc.). C'est au sein du `<body>` que le zoning de la page est principalement mis en œuvre.

L'article met en évidence l'importance du DOCTYPE pour le modèle de boîte CSS, un concept fondamental pour la mise en page. Le modèle de boîte définit la manière dont les éléments HTML sont rendus en termes de contenu, de padding, de bordure et de marge.

Concernant la partie `article` mentionnée dans le TP, l'exemple de code fourni à la page 3 du PDF montre l'utilisation de la balise `<article>` au sein d'une section. La balise `<article>` est une balise sémantique de HTML5 qui représente un contenu autonome et indépendant, tel qu'un article de blog, un commentaire, un widget interactif, ou tout autre élément de contenu qui pourrait être distribué ou réutilisé indépendamment du reste de la page.

## Exercice 2 : Reproduction de zonings de pages

L'exercice 2 consistait à reproduire plusieurs modèles de zoning de pages web en utilisant un fichier CSS séparé pour la mise en forme et en respectant les proportions. Chaque modèle a été implémenté dans un fichier HTML distinct, lié au même fichier `style.css`.

### Approche technique
Pour la réalisation de cet exercice, la propriété CSS `display: flex` (Flexbox) a été largement utilisée pour la mise en page des éléments. Flexbox est un module de mise en page unidimensionnel qui permet de distribuer l'espace entre les éléments d'une interface et de les aligner. Pour les modèles nécessitant une grille bidimensionnelle, `display: grid` (CSS Grid Layout) a été privilégié, offrant un contrôle plus précis sur les lignes et les colonnes.

Le fichier `style.css` contient des styles généraux applicables à tous les modèles, ainsi que des styles spécifiques pour chaque modèle, préfixés par une classe (`.model1`, `.model2`, etc.) appliquée à la balise `<body>` de chaque fichier HTML. Cela permet de réutiliser les styles de base tout en adaptant la mise en page à chaque configuration spécifique.

### Modèles réalisés

Voici la description de chaque modèle et les balises/classes CSS utilisées pour leur implémentation :

#### Modèle 1 : Header + (Sidebar Gauche | Main)
- **Description** : Une en-tête en haut, suivie d'une barre latérale à gauche et d'un contenu principal à droite.
- **Fichier HTML** : `model1.html`
- **Classes CSS utilisées** : `.header`, `.container` (avec `flex-direction: row`), `.sidebar-left`, `.main-content`.

#### Modèle 2 : Header + (Sidebar Gauche | Main | Sidebar Droite)
- **Description** : Similaire au modèle 1, mais avec une barre latérale supplémentaire à droite du contenu principal.
- **Fichier HTML** : `model2.html`
- **Classes CSS utilisées** : `.header`, `.container` (avec `flex-direction: row`), `.sidebar-left`, `.main-content`, `.sidebar-right`.

#### Modèle 3 : (Sidebar Gauche | Sidebar Droite) + Footer
- **Description** : Deux barres latérales côte à côte, suivies d'un pied de page.
- **Fichier HTML** : `model3.html`
- **Classes CSS utilisées** : `.container` (avec `flex-direction: row` et `align-items: stretch`), `.sidebar-left`, `.sidebar-right`, `.footer` (avec `order: 1` pour le placer en bas).

#### Modèle 4 : Header + Menu + Main + Footer
- **Description** : Une en-tête, un menu de navigation, un contenu principal et un pied de page, empilés verticalement.
- **Fichier HTML** : `model4.html`
- **Classes CSS utilisées** : `.header`, `.menu`, `.main-content`, `.footer`.

#### Modèle 5 : Header + Menu + (4 blocs en grille 2x2) + Footer
- **Description** : Une en-tête, un menu, une section de quatre blocs organisés en grille 2x2, et un pied de page.
- **Fichier HTML** : `model5.html`
- **Classes CSS utilisées** : `.header`, `.menu`, `.grid-container` (avec `display: grid`, `grid-template-columns: repeat(2, 1fr)`), `.box`, `.footer`.

#### Modèle 6 : Header + Menu + (4x4 grille de blocs colorés) + Footer
- **Description** : Une en-tête, un menu, une section de seize blocs organisés en grille 4x4, et un pied de page.
- **Fichier HTML** : `model6.html`
- **Classes CSS utilisées** : `.header`, `.menu`, `.grid-container` (avec `display: grid`, `grid-template-columns: repeat(4, 1fr)`), `.box`, `.footer`.

#### Modèle 7 : Header + (Sidebar Gauche | 5 colonnes centrales | Sidebar Droite) + Footer (jaune)
- **Description** : Une en-tête, une barre latérale gauche, cinq colonnes centrales, une barre latérale droite, et un pied de page jaune.
- **Fichier HTML** : `model7.html`
- **Classes CSS utilisées** : `.header`, `.content-area` (avec `display: flex`), `.sidebar-left`, `.central-columns` (avec `display: flex`), `.central-column-item`, `.sidebar-right`, `.footer` (avec `background-color: yellow`).

## Conclusion
Ce TP a permis de mettre en pratique les concepts de zoning et de mise en page web en utilisant HTML et CSS. L'utilisation de Flexbox et CSS Grid s'est avérée essentielle pour créer des mises en page réactives et bien structurées, répondant aux exigences de chaque modèle. Les fichiers HTML et CSS générés démontrent une compréhension des techniques de base pour la structuration visuelle des pages web.

### Références
[1]: http://j-willette.developpez.com/tutoriels/html/les-bases-du-html/?page=page_1 "Apprenez les bases du HTML"

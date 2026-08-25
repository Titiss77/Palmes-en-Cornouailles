<?php echo $this->extend('Public/Layout/l_global'); ?>

<?php echo $this->section('contenu'); ?>
<div class="container" style="padding: 50px 0;">
    <h1 class="h1">Mentions Légales</h1>

    <h2 class="h2">1. Éditeur du site</h2>
    <p class="paragraph">
        <strong>Nom du Club :</strong> Palmes en Cornouailles<br>
        <strong>Forme juridique :</strong> Association Loi 1901<br>
        <strong>Adresse :</strong><?php echo $general['adresse']; ?> <br>
        <strong>Email :</strong><?php echo $general['mailClub']; ?><br>
        <strong>Directeur de la publication :</strong> <?php echo $president['nom']; ?> (Président)
    </p>

    <h2 class="h2">2. Hébergement</h2>
    <p class="paragraph">
        Le site est hébergé par :<br>
        <strong>Nom de l'hébergeur :</strong> Byet Internet Services (iFastNet)<br>
        <strong>Adresse :</strong> 275 New North Road, Islington, London, N1 7AA, Royaume-Uni<br>
        <strong>Site Web :</strong> <a href="https://byethost.com" target="_blank"
            rel="noopener noreferrer">byethost.com</a>
    </p>

    <h2 class="h2">3. Propriété intellectuelle</h2>
    <p class="paragraph">
        L'ensemble de ce site relève de la législation française et internationale sur le droit d'auteur et la propriété
        intellectuelle.
        Toute reproduction de photos (notamment celles des membres du bureau et encadrants) est interdite sans
        autorisation.
    </p>
</div>
<?php echo $this->endSection(); ?>
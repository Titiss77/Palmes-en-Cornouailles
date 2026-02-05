<?= $this->extend('Public/Layout/l_global') ?>

<?= $this->section('contenu') ?>
<div class="container" style="padding: 50px 0;">
    <h1 class="h1">Mentions Légales</h1>

    <h2 class="h2">1. Éditeur du site</h2>
    <p class="paragraph">
        <strong>Nom du Club :</strong> Palmes en Cornouailles<br>
        <strong>Forme juridique :</strong> Association Loi 1901<br>
        <strong>Adresse :</strong><?= $general['adresse'] ?> <br>
        <strong>Email :</strong><?= $general['mailClub'] ?><br>
        <strong>Directeur de la publication :</strong> <?= $president['nom'] ?> (Président)
    </p>

    <h2 class="h2">2. Hébergement</h2>
    <p class="paragraph">
        Le site est hébergé par :<br>
        <strong>Nom de l'hébergeur :</strong> [À COMPLÉTER PAR L'HÉBERGEUR, EX: O2SWITCH]<br>
        <strong>Adresse :</strong> [ADRESSE DE L'HÉBERGEUR]<br>
        <strong>Téléphone :</strong> [TÉLÉPHONE HÉBERGEUR]
    </p>

    <h2 class="h2">3. Propriété intellectuelle</h2>
    <p class="paragraph">
        L'ensemble de ce site relève de la législation française et internationale sur le droit d'auteur et la propriété
        intellectuelle.
        Toute reproduction de photos (notamment celles des membres du bureau et encadrants) est interdite sans
        autorisation.
    </p>
</div>
<?= $this->endSection() ?>
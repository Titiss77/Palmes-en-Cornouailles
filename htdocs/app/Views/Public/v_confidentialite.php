<?= $this->extend('Public/Layout/l_global') ?>

<?= $this->section('contenu') ?>
<div class="container" style="padding: 50px 0;">
    <h1>Politique de Confidentialité</h1>
    <p>Dernière mise à jour : <?= date('d/m/Y') ?></p>

    <h2>1. Absence de collecte de données</h2>
    <p>
        Le site internet du club <strong><?= $general['nomClub'] ?></strong> est un site vitrine à vocation informative.
        <strong>Nous ne collectons aucune donnée personnelle</strong> sur les visiteurs :
    </p>
    <ul>
        <li>Aucune création de compte utilisateur n'est possible pour le public.</li>
        <li>Aucun formulaire ne stocke vos informations dans notre base de données.</li>
        <li>Aucun cookie publicitaire ou de traçage commercial n'est utilisé.</li>
    </ul>

    <h2>2. Données publiées (Trombinoscope)</h2>
    <p>
        Certaines données personnelles concernant les membres de l'association (notamment les noms, fonctions et
        photographies du trombinoscope) sont publiées sur ce site pour présenter l'organigramme du club.
    </p>
    <p>
        Ces informations sont publiées avec le consentement des personnes concernées, recueilli lors de leur adhésion ou
        de leur prise de fonction.
    </p>

    <h2>3. Vos droits</h2>
    <p>
        Bien que nous ne récoltions pas de données sur les visiteurs, les personnes dont les informations sont affichées
        sur le site (membres, encadrants) disposent, conformément au RGPD, d'un droit d'accès, de rectification et de
        suppression de leurs données.
    </p>
    <p>
        Pour exercer ce droit (par exemple pour demander le retrait d'une photo), contactez-nous à :
        <?= $general['mailClub'] ?>.
    </p>
</div>
<?= $this->endSection() ?>
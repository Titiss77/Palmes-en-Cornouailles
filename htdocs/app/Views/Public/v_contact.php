<?= $this->extend('Public/Layout/l_global') ?>

<?php

/**
 * ============================================================================
 * VUE : INSCRIPTIONS & CONTACT
 * ============================================================================
 * Cette vue gère la page de renseignements administratifs et de contact.
 * Elle est composée de 4 blocs principaux :
 * 1. Informations (Conditions d'âge, niveau requis, tarifs).
 * 2. Formulaire de contact (Sécurisé avec CSRF + Honeypot).
 * 3. Matériel nécessaire (Liste avec statut Prêt/Achat).
 * 4. Trombinoscope (Membres du bureau).
 *
 * Les données ($tarifs, $materiel, $membres) proviennent du Contrôleur 'Contact'.
 */
?>

<?= $this->section('contenu') ?>

<?php

/**
 * ----------------------------------------------------------------------------
 * 1. CONFIGURATION LOCALE (Données Statiques)
 * ----------------------------------------------------------------------------
 * Nous définissons ici les listes qui ne nécessitent pas de base de données.
 * Cela permet de modifier les conditions ou les destinataires directement ici
 * sans toucher au code HTML plus bas.
 */

// Liste des pré-requis affichés en haut de page
$conditions = [
    'Être âgé de 6 ans minimum.',
    'Savoir nager 25 mètres sans aide.',
    'Certificat médical de non contre-indication indispensable.'
];

// Liste des destinataires pour le menu déroulant du formulaire
// Format : 'valeur_technique' => 'Libellé affiché à l'utilisateur'
$destinataires = [
    'pas_choisi' => '-- Veuillez choisir --',
    'tresorier' => '(Facturation/Tarifs)',
    'secretaire' => '(Licences/Dossiers)',
];
?>

<div class="site-container">
    <h2 class="title-section">Inscriptions & Contact</h2>

    <div class="grid-2 mb-5">

        <section class="card-item border-blue">
            <h3><i class="bi bi-info-circle"></i> Conditions d'inscription</h3>
            <ul class="list-check">
                <?php foreach ($conditions as $condition): ?>
                <li><?= esc($condition) ?></li>
                <?php endforeach; ?>
                <a href="<?= base_url('uploads/CACI.pdf') ?>" target="_blank"
                    class="btn-home d-inline-flex align-items-center gap-2 text-decoration-none">
                    <i class="bi bi-download"></i> Télécharger le certificat
                </a>
            </ul>
        </section>

        <section class="card-item">
            <h3><i class="bi bi-cash-stack"></i> Tarifs 2026</h3>
            <table class="custom-table small">
                <?php if (!empty($groupes)): ?>
                <?php foreach ($groupes as $g): ?>
                <tr>
                    <td style="background-color:<?= esc($g['codeCouleur']) ?>;"><?= esc($g['nom']) ?></td>
                    <td style="background-color:<?= esc($g['codeCouleur']) ?>;"><?= esc($g['description']) ?></td>
                    <td class="text-right" style="background-color:<?= esc($g['codeCouleur']) ?>;">
                        <strong><?= esc($g['prix']) ?>€</strong>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <p>Aucuns groupes pour le moment. Revenez bientôt !</p>
                <?php endif; ?>
            </table>
            <p>*Via Hello asso, paiement en 3x, passport et chèques vacances</p>
        </section>
    </div>

    <h3 class="title-section">Matériel à avoir</h3>
    <div class="grid-responsive">
        <?php if (!empty($materiel)): ?>
        <?php foreach ($materiel as $m): ?>
        <?php if ($m['idPret'] == 2): ?>
        <div class="materiel-card card-item h-100">

            <?php if (!empty($m['image'])): ?>
            <div class="materiel-photo-container">
                <img src="<?= base_url('uploads/' . esc($m['image'])); ?>" alt="<?= esc($m['nom']) ?>"
                    class="materiel-img">
            </div>
            <?php endif; ?>

            <div class="info p-3">
                <h3><?= esc($m['nom']) ?></h3>
                <p class="txt-small text-muted"><?= esc($m['description']) ?></p>
            </div>
            <div class="mt-2">
                <?php if ($m['idPret'] == 1): ?>
                <span class="badge-status is-lent">
                    <i class="bi bi-arrow-repeat"></i> <?= esc($m['nomPret']) ?>
                </span>
                <?php else: ?>
                <span class="badge-status is-personal">
                    <i class="bi bi-cart"></i> <?= esc($m['nomPret']) ?>
                </span>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php else: ?>
        <p>Aucuns materiels pour le moment. Revenez bientôt !</p>
        <?php endif; ?>
    </div>

    <h3 class="title-section">Matériel supplémentaire (prété pour essais)</h3>
    <div class="grid-responsive">
        <?php if (!empty($materiel)): ?>
        <?php foreach ($materiel as $m): ?>
        <?php if ($m['idPret'] == 1): ?>
        <div class="materiel-card card-item h-100">

            <?php if (!empty($m['image'])): ?>
            <div class="materiel-photo-container">
                <img src="<?= base_url('uploads/' . esc($m['image'])); ?>" alt="<?= esc($m['nom']) ?>"
                    class="materiel-img">
            </div>
            <?php endif; ?>

            <div class="info p-3">
                <h3><?= esc($m['nom']) ?></h3>
                <p class="txt-small text-muted"><?= esc($m['description']) ?></p>
            </div>
            <div class="mt-2">
                <?php if ($m['idPret'] == 1): ?>
                <span class="badge-status is-lent">
                    <i class="bi bi-arrow-repeat"></i> <?= esc($m['nomPret']) ?>
                </span>
                <?php else: ?>
                <span class="badge-status is-personal">
                    <i class="bi bi-cart"></i> <?= esc($m['nomPret']) ?>
                </span>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php else: ?>
        <p>Aucuns materiels pour le moment. Revenez bientôt !</p>
        <?php endif; ?>
    </div>

    <section class="trombi-container mt-5">
        <h2 class="title-section">L'équipe du bureau</h2>
        <div class="trombi-grid">

            <?php if (!empty($membres)): ?>
            <?php foreach ($membres as $m): ?>
            <div class="trombi-card">
                <div class="photo-container">
                    <img src="<?= base_url('uploads/' . esc($m['photo'])); ?>" alt="<?= esc($m['nom']); ?>">
                </div>
                <div class="info">
                    <h3><?= esc($m['nom']); ?></h3>
                    <p class="badge-fonction"><?= esc($m['fonctions']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>

            <?php else: ?>
            <p class="text-center">Aucun membre n'est enregistré pour le moment.</p>
            <?php endif; ?>

        </div>
    </section>

    <div class="grid-1 mb-5">
        <section class="card-item highlight-section">
            <h3 class="text-center"><i class="bi bi-envelope"></i> Une question ? Contactez-nous</h3>

            <?php if (session()->getFlashdata('success')): ?>
            <div class="alert-success-popup">
                <i class="bi bi-check-all"></i> <?= session()->getFlashdata('success') ?>
            </div>
            <?php endif; ?>

            <form action="<?= base_url('contact/envoyer') ?>" method="post" class="mt-3">

                <?= csrf_field() ?>

                <div style="display:none;">
                    <input type="text" name="honeypot" value="" tabindex="-1" autocomplete="off">
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label for="destinataire">Vous avez une question concernant :</label>
                        <select name="destinataire" id="destinataire" class="form-input">
                            <?php foreach ($destinataires as $value => $label): ?>
                            <option value="<?= esc($value) ?>"><?= esc($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="email">Votre adresse email :</label>
                        <input type="email" name="email" id="email" placeholder="exemple@mail.com" class="form-input"
                            required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="message">Votre message :</label>
                    <textarea name="message" id="message" placeholder="Détaillez votre demande ici..." rows="4"
                        class="form-input" required></textarea>
                </div>
                <div class="politique-form" style="margin: 20px 0;">
                    <input type="checkbox" name="rgpd_consent" id="rgpd_consent" required>
                    <label for="rgpd_consent" style="display:inline;">
                        J'accepte que mes données soient utilisées pour traiter ma demande.
                        <a href="<?= base_url('politique-confidentialite') ?>" target="_blank">En savoir plus</a>.
                    </label>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn-home" style="max-width: 300px; width:100%">
                        Envoyer mon message
                    </button>
                </div>
            </form>
        </section>
    </div>

</div>

<?= $this->endSection() ?>
<?php echo $this->extend('Public/Layout/l_global'); ?>

<?php

/**
 * ============================================================================
 * VUE : INSCRIPTIONS & CONTACT
 * ============================================================================.
 */

// --- CONFIGURATION LOCALE ---
$conditions = [
    'Être âgé de 6 ans minimum.',
    'Savoir nager 25 mètres sans aide.',
    'Certificat médical de non contre-indication indispensable.',
];

$destinataires = [
    'pas_choisi' => '-- Veuillez choisir --',
    '(Facturation/Tarifs)' => '(Facturation/Tarifs)',
    '(Licences/Dossiers)' => '(Licences/Dossiers)',
];
?>

<?php echo $this->section('contenu'); ?>

<div class="site-container">

    <?php if (session()->getFlashdata('success')) { ?>
    <div class="alert alert-success"
        style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; border: 1px solid #c3e6cb; margin: 20px 0; text-align: center;">
        <i class="bi bi-check-circle-fill"></i> <?php echo session()->getFlashdata('success'); ?>
    </div>
    <?php } ?>

    <?php if (session()->getFlashdata('error')) { ?>
    <div class="alert alert-danger"
        style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; border: 1px solid #f5c6cb; margin: 20px 0; text-align: center;">
        <i class="bi bi-exclamation-triangle-fill"></i> <?php echo session()->getFlashdata('error'); ?>
    </div>
    <?php } ?>

    <h2 class="title-section">Inscriptions & Contact</h2>

    <div class="grid-2 mb-5">
        <section class="card-item border-blue">
            <h3><i class="bi bi-info-circle"></i> Conditions d'inscription</h3>
            <ul class="list-check">
                <?php foreach ($conditions as $condition) { ?>
                <li><?php echo esc($condition); ?></li>
                <?php } ?>
                <a href="<?php echo base_url('uploads/CACI.pdf'); ?>" target="_blank"
                    class="btn-home d-inline-flex align-items-center gap-2 text-decoration-none">
                    <i class="bi bi-download"></i> Télécharger le certificat
                </a>
            </ul>
        </section>

        <section class="card-item">
            <h3><i class="bi bi-cash-stack"></i> Tarifs 2026</h3>
            <table class="custom-table small">
                <?php if (!empty($groupes)) { ?>
                <?php foreach ($groupes as $g) { ?>
                <tr>
                    <td style="background-color:<?php echo esc($g['codeCouleur']); ?>;"><?php echo esc($g['nom']); ?></td>
                    <td style="background-color:<?php echo esc($g['codeCouleur']); ?>;"><?php echo esc($g['description']); ?></td>
                    <td class="text-right" style="background-color:<?php echo esc($g['codeCouleur']); ?>;">
                        <strong><?php echo esc($g['prix']); ?>€</strong>
                    </td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <p>Aucun groupe pour le moment.</p>
                <?php } ?>
            </table>
            <p>*Via Hello asso, paiement en 3x, passport et chèques vacances</p>
        </section>
    </div>
    <section class="trombi-container mt-5">
        <h2 class="title-section">L'équipe du bureau</h2>
        <div class="trombi-grid">

            <?php if (!empty($membres)) { ?>
            <?php foreach ($membres as $m) { ?>
            <div class="trombi-card">
                <div class="photo-container">
                    <img src="<?php echo base_url('uploads/'.esc($m['photo'])); ?>" alt="<?php echo esc($m['nom']); ?>">
                </div>
                <div class="info">
                    <h3><?php echo esc($m['nom']); ?></h3>
                    <p class="badge-fonction"><?php echo esc($m['fonctions']); ?></p>
                </div>
            </div>
            <?php } ?>

            <?php } else { ?>
            <p class="text-center">Aucun membre n'est enregistré pour le moment.</p>
            <?php } ?>

        </div>
    </section>

    <div class="grid-1 mb-5">
        <section class="card-item highlight-section">
            <h3 class="text-center"><i class="bi bi-envelope"></i> Une question ? Contactez-nous</h3>

            <form action="<?php echo base_url('contact/envoyer'); ?>" method="post" class="mt-3">
                <?php echo csrf_field(); ?>

                <div style="display:none;">
                    <input type="text" name="honeypot" value="" tabindex="-1" autocomplete="off">
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label for="destinataire">Vous avez une question concernant :</label>
                        <select name="destinataire" id="destinataire" class="form-input">
                            <?php foreach ($destinataires as $value => $label) { ?>
                            <option value="<?php echo esc($value); ?>"><?php echo esc($label); ?></option>
                            <?php } ?>
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
                        <a href="<?php echo base_url('politique-confidentialite'); ?>" target="_blank">En savoir plus</a>.
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

<?php echo $this->endSection(); ?>
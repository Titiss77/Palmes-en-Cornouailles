<?= $this->extend('Public/Layout/l_global') ?>

<?php

/**
 * ==========================================================================
 * VUE : CONNEXION ADMINISTRATEUR (Login)
 * ==========================================================================
 * Cette vue affiche le formulaire d'authentification pour accéder au Back-Office.
 *
 * 1. Layout   : Étend 'l_global' pour garder le header/footer du site.
 * 2. Style    : Utilise Flexbox pour centrer le formulaire verticalement.
 * 3. Sécurité : Gère les retours d'erreurs (Flashdata) et la protection CSRF.
 */
?>

<?= $this->section('contenu') ?>

<div class="site-container" style="display:flex; justify-content:center; align-items:center; min-height:60vh;">

    <div class="card-item" style="width:100%; max-width:400px;">

        <h2 class="title-section text-center">Connexion Licenciés</h2>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="tag-status is-evenement"
            style="width:100%; margin-bottom:15px; background-color:#ffe6e6; color:#d63384; text-align:center;">
            <i class="bi bi-exclamation-triangle-fill"></i> <?= session()->getFlashdata('error') ?>
        </div>
        <?php endif; ?>

        <form action="<?= base_url('login/auth/liste') ?>" method="post">
            <div class="form-group">
                <label for="identifiant" class="sr-only" style="display:none">Identifiant</label> <input type="text"
                    id="identifiant" name="identifiant" placeholder="Identifiant" class="form-input" required
                    autocomplete="username">
            </div>

            <div class="form-group">
                <label for="password" class="sr-only" style="display:none">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="Mot de passe" class="form-input"
                    required autocomplete="current-password">
            </div>

            <button type="submit" class="btn-home" style="width:100%">
                Se connecter <i class="bi bi-box-arrow-in-right"></i>
            </button>

        </form>
    </div>
</div>

<?= $this->endSection() ?>
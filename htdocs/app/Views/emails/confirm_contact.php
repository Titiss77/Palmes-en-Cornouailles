<div
    style="font-family: 'Segoe UI', Helvetica, Arial, sans-serif; line-height: 1.6; color: #1a1a1a; max-width: 600px; margin: 0 auto; border: 1px solid #e4e4e4; padding: 0; border-radius: 12px; overflow: hidden; background-color: #ffffff;">
    <div style="background-color: #002d5a; padding: 30px 20px; text-align: center;">
        <h1 style="color: #ffffff; margin: 0; font-size: 22px; text-transform: uppercase; letter-spacing: 2px;">
            <?= esc($nomClub) ?></h1>
        <p style="color: #CA258B; margin: 5px 0 0; font-weight: bold; font-size: 14px; text-transform: uppercase;">Club
            de Nage avec Palmes — Quimper</p>
    </div>
    <div style="padding: 30px;">
        <p style="font-size: 16px; font-weight: bold; color: #002d5a;">Bonjour,</p>
        <p>Vous venez d'envoyer un message au secrétariat du club via notre formulaire de contact en ligne.</p>
        <p>Afin de valider votre demande, cliquez ci-dessous :</p>
        <div style="text-align: center; margin: 40px 0;">
            <a href="<?= $lien ?>"
                style="background-color: #CA258B; color: #ffffff; padding: 18px 35px; text-decoration: none; border-radius: 50px; font-weight: bold; display: inline-block;">Confirmer
                l'envoi</a>
        </div>
    </div>
    <div style="background-color: #f4f4f4; padding: 20px; text-align: center; font-size: 12px; color: #888;">
        <a href="<?= $urlAccueil ?>"
            style="color: #002d5a; text-decoration: none; font-weight: bold;"><?= $domainName ?></a>
    </div>
</div>
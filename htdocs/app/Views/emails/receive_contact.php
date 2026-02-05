<div
    style="font-family: 'Segoe UI', Arial, sans-serif; line-height: 1.6; color: #1a1a1a; max-width: 600px; margin: 0 auto; border: 1px solid #002d5a; padding: 0; border-radius: 12px; overflow: hidden; background-color: #ffffff;">
    <div style="background-color: #002d5a; padding: 20px; text-align: center; border-bottom: 4px solid #CA258B;">
        <h2 style="color: #ffffff; margin: 0; font-size: 18px; text-transform: uppercase; letter-spacing: 1px;">Nouveau
            Message Site Web</h2>
    </div>
    <div style="padding: 30px;">
        <p><strong>Expéditeur :</strong> <?= esc($email_user) ?></p>
        <p><strong>Destinataire :</strong> <?= esc($destinataireNom) ?></p>
        <hr>
        <div style="background-color: #fcfcfc; padding: 20px; border-left: 5px solid #002d5a;">
            <?= $messageContenu ?>
        </div>
    </div>
</div>
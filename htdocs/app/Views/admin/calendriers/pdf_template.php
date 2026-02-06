<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <style>
    body {
        font-family: sans-serif;
        font-size: 12px;
        color: #333;
    }

    /* En-tête avec Logo */
    .header {
        text-align: center;
        margin-bottom: 20px;
        border-bottom: 2px solid #0056b3;
        padding-bottom: 10px;
    }

    .logo {
        width: 80px;
        height: auto;
        vertical-align: middle;
    }

    .titre-doc {
        font-size: 24px;
        font-weight: bold;
        color: #0056b3;
        vertical-align: middle;
        margin-left: 15px;
    }

    /* Le tableau */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 6px 8px;
        text-align: left;
    }

    /* En-tête du tableau (Gris/Bleu comme souvent sur les calendriers) */
    th {
        background-color: #f2f2f2;
        color: #000;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 10px;
    }

    /* Lignes zébrées */
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Titres des Mois */
    .mois-header {
        background-color: #0056b3;
        color: white;
        padding: 8px;
        font-size: 14px;
        font-weight: bold;
        margin-top: 20px;
        margin-bottom: 5px;
    }

    /* Colonnes spécifiques */
    .col-date {
        width: 80px;
        font-weight: bold;
    }

    .col-lieu {
        width: 100px;
    }

    .col-bassin {
        width: 40px;
        text-align: center;
    }
    </style>
</head>

<body>

    <div class="header">
        <span class="titre-doc"><?= $title ?></span>
    </div>

    <?php foreach ($eventsByMonth as $mois => $events): ?>

    <div class="mois-header"><?= $mois ?></div>

    <table>
        <thead>
            <tr>
                <th class="col-date">Date</th>
                <th>Compétition</th>
                <th class="col-lieu">Lieu</th>
                <th class="col-bassin">Bassin</th>
                <th>Catégorie / Niveau</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $evt): ?>
            <tr>
                <td><?= $evt['date'] ?></td>
                <td><?= $evt['nom'] ?></td>
                <td><?= $evt['lieu'] ?></td>
                <td style="text-align:center;"><?= $evt['bassin'] ?></td>
                <td><?= $evt['niveau'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php endforeach; ?>

</body>

</html>
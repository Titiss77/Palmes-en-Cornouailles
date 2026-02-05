<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Page non trouvée - PEC</title>
    <style>
    body {
        height: 100%;
        background: #f8fbff;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        color: #002d5a;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        margin: 0;
    }

    .wrap {
        max-width: 800px;
        padding: 3rem;
        background-color: #ffffff;
        text-align: center;
        border: 1px solid #e1e8ed;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 45, 90, 0.1);
    }

    h1 {
        font-weight: bold;
        font-size: 5rem;
        margin: 0;
        color: #ca258b;
    }

    h2 {
        font-weight: normal;
        margin-top: 1rem;
        color: #002d5a;
    }

    p {
        margin-top: 1.5rem;
        font-size: 1.1rem;
        line-height: 1.6;
        color: #1a1a1a;
    }

    code {
        background-color: #fdf2f2;
        color: #d9534f;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        display: inline-block;
        margin-top: 1rem;
        font-family: monospace;
        border: 1px solid #f5c6cb;
    }

    .btn-home {
        display: inline-block;
        margin-top: 2rem;
        padding: 10px 25px;
        background-color: #002d5a;
        color: #ffffff;
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .btn-home:hover {
        background-color: #ca258b;
        transform: translateY(-2px);
    }
    </style>
</head>

<body>
    <div class="wrap">
        <h1>404</h1>
        <h2>Oups ! Mauvaise ligne de nage...</h2>

        <p>
            <strong>Cette page n'existe pas ou est en cours de production.</strong>
        </p>

        <?php if (ENVIRONMENT !== 'production'): ?>
        <code><?= nl2br(esc($message)) ?></code>
        <?php endif; ?>

        <br>
        <a href="javascript:history.back()" class="btn-home">Retourner à la page précédente</a>
    </div>
</body>

</html>
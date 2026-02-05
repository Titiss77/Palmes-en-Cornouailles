<?php
$sections = [
    [
        'section' => 'accueil',
        'titre' => "Administration du contenu de la page d'accueil",
        'icon' => 'bi-gear',
        'cards' => [
            [
                'label' => 'Identité',
                'desc' => 'Configuration générale du club',
                'icon' => 'bi-sliders',
                'url' => 'admin/general',
                'btn' => 'Modifier les infos'
            ],
            [
                'count' => $count['actualites'],
                'label' => 'Actualités',
                'desc' => 'Articles',
                'icon' => 'bi-newspaper',
                'url' => 'admin/actualites',
                'btn' => 'Gérer les contenus'
            ],
            [
                'count' => $count['disciplines'],
                'label' => 'Disciplines',
                'desc' => "Types d'activités & Sports proposés",
                'icon' => 'bi-geo-alt',
                'url' => 'admin/disciplines',
                'btn' => 'Gérer les disciplines'
            ],
            [
                'count' => $count['membres'],
                'label' => 'Membres',
                'desc' => 'Bureau, Coachs & Fonctions',
                'icon' => 'bi-people',
                'url' => 'admin/membres',
                'btn' => "Gérer l'équipe"
            ],
            [
                'count' => $count['piscines'],
                'label' => 'Lieux',
                'desc' => "Piscines & Bassins d'entraînement",
                'icon' => 'bi-geo-alt',
                'url' => 'admin/piscines',
                'btn' => 'Gérer les sites'
            ],
            [
                'count' => $count['partenaires'],
                'label' => 'Partenaires',
                'desc' => 'Organismes & Collaborateurs',
                'icon' => 'bi-people',
                'url' => 'admin/partenaires',
                'btn' => 'Gérer les partenaires'
            ],
        ]
    ],
    [
        'section' => 'contact',
        'titre' => 'Administration du contenu du materiel & équipements',
        'icon' => 'bi-gear',
        'cards' => [
            [
                'count' => $count['materiel'],
                'label' => 'Matériel',
                'desc' => 'Inventaire & Prêts de palmes',
                'icon' => 'bi-tools',
                'url' => 'admin/materiel',
                'btn' => 'Gérer le stock'
            ]
        ]
    ]
];
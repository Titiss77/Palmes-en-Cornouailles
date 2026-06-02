<?php

declare(strict_types=1);
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
                'btn' => 'Modifier les infos',
            ],
            [
                'count' => $count['actualites'] ?? 0,
                'label' => 'Événement(s)',
                'desc' => 'Articles',
                'icon' => 'bi-newspaper',
                'url' => 'admin/actualites',
                'btn' => 'Gérer les contenus',
            ],
            [
                'count' => $count['disciplines'] ?? 0,
                'label' => 'Discipline(s)',
                'desc' => "Types d'activités & Sports proposés",
                'icon' => 'bi-geo-alt',
                'url' => 'admin/disciplines',
                'btn' => 'Gérer les disciplines',
            ],
            [
                'count' => $count['membres'] ?? 0,
                'label' => 'Membre(s)',
                'desc' => 'Bureau, Coachs & Fonctions',
                'icon' => 'bi-people',
                'url' => 'admin/membres',
                'btn' => "Gérer l'équipe",
            ],
            [
                'count' => $count['piscines'] ?? 0,
                'label' => 'Lieux',
                'desc' => "Piscines & Bassins d'entraînement",
                'icon' => 'bi-geo-alt',
                'url' => 'admin/piscines',
                'btn' => 'Gérer les sites',
            ],
            [
                'count' => $count['partenaires'] ?? 0,
                'label' => 'Partenaire(s)',
                'desc' => 'Organismes & Collaborateurs',
                'icon' => 'bi-people',
                'url' => 'admin/partenaires',
                'btn' => 'Gérer les partenaires',
            ],
        ],
    ],
    [
        'section' => 'contact',
        'titre' => 'Administration du contenu du materiel & équipements',
        'icon' => 'bi-gear',
        'cards' => [
            [
                'count' => $count['groupes'] ?? 0,
                'label' => 'Groupe(s)',
                'desc' => 'Configuration des tarifs de chaques groupes',
                'icon' => 'bi-sliders',
                'url' => 'admin/groupes',
                'btn' => 'Modifier les infos',
            ],
            [
                'count' => $count['materiel'] ?? 0,
                'label' => 'Matériel(s)',
                'desc' => 'Inventaire & Prêts de palmes',
                'icon' => 'bi-tools',
                'url' => 'admin/materiel',
                'btn' => 'Gérer le stock',
            ],
            [
                'count' => $count['membres'] ?? 0,
                'label' => 'Membre(s)',
                'desc' => 'Modifications des membres en général',
                'icon' => 'bi-people',
                'url' => 'admin/membres',
                'btn' => "Gérer l'équipe",
            ],
        ],
    ],
];
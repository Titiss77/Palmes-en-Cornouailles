<?php

namespace App\Controllers\admin;

use App\Controllers\Root;

class Dashboard extends BaseAdminController
{
    protected $donneesModel;
    public function __construct()
    {
        $this->donneesModel = new Root();
    }
    public function index()
    {
        $data = $this->getCommonData('Dashboard - admin', 'admin/dashboard.css');

        // Récupération des compteurs via le modèle Donnees (ou des modèles spécifiques)
        // Note: count($this->donneesModel->get...) n'est pas très optimisé mais fonctionne pour l'instant.
        // Idéalement : $db->table('actualites')->countAll();
        
        $db = \Config\Database::connect();

        $data['count'] = [
            'path' => '/sectionAccueil.php',
            'actualites' => $db->table('actualites')->countAll(),
            'boutique'   => $db->table('boutique')->countAll(),
            'membres'    => $db->table('membres')->countAll(),
            'groupes'    => $db->table('groupes')->countAll(),
            'calendriers'=> $db->table('calendriers')->countAll(),
            'piscines'   => $db->table('piscines')->countAll(),
            'partenaires'=> $db->table('partenaires')->countAll(),
            'materiel'   => $db->table('materiel')->countAll(),
            'disciplines'=> $db->table('disciplines')->countAll(),
            'utilisateurs'=> $db->table('utilisateurs')->countAll(),
        ];

        return view('admin/v_dashboard', $data);
    }

    public function contact()
    {
        $data = $this->getCommonData('Dashboard - admin', 'admin/dashboard.css');

        // Récupération des compteurs via le modèle Donnees (ou des modèles spécifiques)
        // Note: count($this->donneesModel->get...) n'est pas très optimisé mais fonctionne pour l'instant.
        // Idéalement : $db->table('actualites')->countAll();
        
        $db = \Config\Database::connect();

        $data['count'] = [
            'actualites' => $db->table('actualites')->countAll(),
            'boutique'   => $db->table('boutique')->countAll(),
            'membres'    => $db->table('membres')->countAll(),
            'groupes'    => $db->table('groupes')->countAll(),
            'calendriers'=> $db->table('calendriers')->countAll(),
            'piscines'   => $db->table('piscines')->countAll(),
            'partenaires'=> $db->table('partenaires')->countAll(),
            'materiel'   => $db->table('materiel')->countAll(),
            'disciplines'=> $db->table('disciplines')->countAll(),
            'utilisateurs'=> $db->table('utilisateurs')->countAll(),
        ];

        return view('admin/v_dashboard', $data);
    }

    public function root()
    {
        $data = $this->getCommonData('Dashboard - admin', 'admin/dashboard.css');

        // Récupération des compteurs via le modèle Donnees (ou des modèles spécifiques)
        // Note: count($this->donneesModel->get...) n'est pas très optimisé mais fonctionne pour l'instant.
        // Idéalement : $db->table('actualites')->countAll();

        $data['root'] = $this->root->getRootStyles();
        

        return view('admin/v_root', $data);
    }
}
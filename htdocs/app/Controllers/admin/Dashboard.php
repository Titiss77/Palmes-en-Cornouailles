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
            'boutique' => $db->table('boutique')->countAll(),
            'membres' => $db->table('membres')->countAll(),
            'groupes' => $db->table('groupes')->countAll(),
            'calendriers' => $db->table('calendriers')->countAll(),
            'piscines' => $db->table('piscines')->countAll(),
            'partenaires' => $db->table('partenaires')->countAll(),
            'materiel' => $db->table('materiel')->countAll(),
            'disciplines' => $db->table('disciplines')->countAll(),
            'utilisateurs' => $db->table('utilisateurs')->countAll(),
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
            'boutique' => $db->table('boutique')->countAll(),
            'membres' => $db->table('membres')->countAll(),
            'groupes' => $db->table('groupes')->countAll(),
            'calendriers' => $db->table('calendriers')->countAll(),
            'piscines' => $db->table('piscines')->countAll(),
            'partenaires' => $db->table('partenaires')->countAll(),
            'materiel' => $db->table('materiel')->countAll(),
            'disciplines' => $db->table('disciplines')->countAll(),
            'utilisateurs' => $db->table('utilisateurs')->countAll(),
        ];

        return view('admin/v_dashboard', $data);
    }

    public function root()
    {
        $data = $this->getCommonData('Dashboard - admin', 'admin/page.css');

        // Récupération des compteurs via le modèle Donnees (ou des modèles spécifiques)
        // Note: count($this->donneesModel->get...) n'est pas très optimisé mais fonctionne pour l'instant.
        // Idéalement : $db->table('actualites')->countAll();

        $data['root'] = $this->root->getRootStyles();

        return view('admin/v_root', $data);
    }

    // Dans votre contrôleur Admin

    public function updateRoot()
    {
        $db = \Config\Database::connect();
        $newSettings = $this->request->getPost('root');

        if ($newSettings) {
            foreach ($newSettings as $libelle => $value) {
                // On remet le libellé au format BDD (ex: primary-color -> primary_color)
                $dbKey = str_replace('-', '_', $libelle);

                $db
                    ->table('root')
                    ->where('libelle', $dbKey)
                    ->update(['value' => $value]);
            }
            return redirect()->back()->with('success', 'Couleurs mises à jour avec succès !');
        }

        return redirect()->back()->with('error', 'Aucune donnée reçue.');
    }
}
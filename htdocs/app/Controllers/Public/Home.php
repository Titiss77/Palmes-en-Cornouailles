<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;
use App\Controllers\Root;
use App\Models\Public\Donnees;
use App\Models\Public\GroupeModel;
use App\Models\Public\PartenaireModel;
use App\Models\admin\PalmaresModel;

class Home extends BaseController
{
    protected $donneesModel;
    protected $groupeModel;
    protected $root;
    protected $generalData;
    protected $partenaireModel;
    protected $palmaresModel;  // AJOUT

    public function __construct()
    {
        $this->donneesModel = new Donnees();
        $this->groupeModel = new GroupeModel();
        $this->root = new Root();
        $this->partenaireModel = new PartenaireModel();
        $this->palmaresModel = new PalmaresModel();  // AJOUT

        $this->generalData = $this->donneesModel->getGeneral();
    }

    /**
     * Helper to merge page-specific data with global data (Header, Footer, Styles)
     */
    private function _render(string $view, array $pageData = [])
    {
        $globalData = [
            'root' => $this->root->getRootStyles(),
            'general' => $this->generalData,
            'titrePage' => $pageData['titrePage'] ?? $this->generalData['nomClub'],  // Default to Club Name
        ];

        return view($view, array_merge($globalData, $pageData));
    }

    public function index()
    {
        
        $data = [
            'cssPage' => 'Public/accueil.css',
            'disciplines' => $this->donneesModel->getDisciplines(),
            'coaches' => $this->donneesModel->getCoachs(),
            'coachesForm' => $this->donneesModel->getCoachsFormation(),
            'piscines' => $this->donneesModel->getPiscines(),
            'actualites' => $this->donneesModel->getActualites(),
            'groupes' => $this->groupeModel->getGroupes(),
            'partenaires' => $this->partenaireModel->getPartenaires(),
            'palmares' => $this->palmaresModel->getPalmaresWithRelations(),
        ];

        return $this->_render('Public/v_accueil', $data);
    }

    public function groupes()
    {
        $data = [
            'cssPage' => 'Public/groupes.css',
            'groupes' => $this->groupeModel->getGroupes(),
        ];

        return $this->_render('Public/v_groupes', $data);
    }

    public function calendriers()
    {
        $data = [
            'cssPage' => 'Public/calendrier.css',
            'titrePage' => 'Calendriers',
            'calendriers' => $this->donneesModel->getCalendriers(),
            'calendrierCompet' => $this->donneesModel->getCalendrier(),
        ];

        return $this->_render('Public/v_calendriers', $data);
    }

    public function boutique()
    {
        $data = [
            'cssPage' => 'Public/boutique.css',
            'titrePage' => 'Boutique du PEC',
            'boutique' => $this->donneesModel->getBoutique(),
            'liensautres' => $this->donneesModel->getLiensAutres(),
        ];

        return $this->_render('Public/v_boutique', $data);
    }

    public function actu($slug)
    {
        $data = [
            'cssPage' => 'Public/accueil.css',
            'titrePage' => 'actu',
            'actualites' => $this->donneesModel->getUneActualites($slug),
        ];

        return $this->_render('Public/v_actu', $data);
    }

    // app/Controllers/Public/Home.php

    public function mentions_legales()
    {
        // Vous pouvez passer des données au layout si nécessaire
        $data = [
            'titrePage' => 'Mentions Légales',
            'cssPage' => 'Public/legal.css',
            'general' => $this->generalData,
            'president' => $this->donneesModel->getPresident(),
        ];
        return $this->_render('Public/v_mentions_legales', $data);
    }

    public function confidentialite()
    {
        $data = [
            'titrePage' => 'Politique de Confidentialité',
            'cssPage' => 'Public/legal.css',
            'general' => $this->generalData,
        ];
        return $this->_render('Public/v_confidentialite', $data);
    }

    public function palmares()
    {
        
        $data = [
            'cssPage' => 'Public/accueil.css',
            'palmares' => $this->palmaresModel->getPalmaresWithRelations(),
        ];

        return $this->_render('Public/v_palmares', $data);
    }
}
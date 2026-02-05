<?php

namespace App\Controllers\admin;

use App\Models\admin\GeneralModel;

class General extends BaseAdminController
{
    protected $generalModel;

    public function __construct()
    {
        $this->generalModel = new GeneralModel();
    }

    public function index()
    {
        $data = $this->getCommonData('Identité du Club', 'admin/page.css');
        
        $item = $this->generalModel->getGeneralWithRelations();

        if (!$item) {
            $item = [
                'id' => null, 'nomClub' => '', 'mailClub' => '', 
                'description' => '', 'philosophie' => '',
                'nombreNageurs' => 0, 'nombreHommes' => 0,
                'projetSportif' => '',
                'lienFacebook' => '', 'lienInstagram' => '', 'lienffessm' => '', 'lienDrive' => '', 'lienDecatPro' => '',
                'logo_path' => null, 'groupe_path' => null, 'ffessm_path' => null
            ];
        }

        $data['item'] = $item;
        return view('admin/general/index', $data);
    }

    public function update()
    {
        if (!$this->validate([
            'nomClub'  => 'required|min_length[3]|max_length[100]',
            'mailClub' => 'permit_empty|valid_email',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $existing = $this->generalModel->first();
        $id = $existing ? $existing['id'] : null;

        // --- GESTION SPÉCIALE DU LOGO PRINCIPAL (FAVICON) ---
        // On n'utilise pas handleImageUpload car on veut écraser un fichier précis à la racine
        $fileLogo = $this->request->getFile('image');
        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            // On déplace le fichier à la racine (FCPATH) et on le renomme 'favicon.ico'
            // Le 3ème paramètre 'true' permet d'écraser le fichier existant
            $fileLogo->move(FCPATH, 'favicon.ico', true);
        }

        // --- GESTION DES AUTRES IMAGES (Classique BDD) ---
        $groupeId     = $this->handleImageUpload('image_groupe', 'general');    
        $ffessmLogoId = $this->handleImageUpload('image_ffessm', 'general');    

        $data = [
            'nomClub'       => $this->request->getPost('nomClub'),
            'mailClub'      => $this->request->getPost('mailClub'),
            'adresse'      => $this->request->getPost('adresse'),
            'description'   => $this->request->getPost('description'),
            'philosophie'   => $this->request->getPost('philosophie'),
            'nombreNageurs' => $this->request->getPost('nombreNageurs'),
            'nombreHommes'  => $this->request->getPost('nombreHommes'),
            'projetSportif' => $this->request->getPost('projetSportif'),
            'lienFacebook'  => $this->request->getPost('lienFacebook'),
            'lienInstagram' => $this->request->getPost('lienInstagram'),
            'lienffessm'    => $this->request->getPost('lienffessm'),
            'lienDrive'     => $this->request->getPost('lienDrive'),
            'lienDecatPro'  => $this->request->getPost('lienDecatPro'),
        ];

        // On met à jour les IDs seulement pour les images gérées en base
        if ($groupeId)     $data['image_groupe_id'] = $groupeId;
        if ($ffessmLogoId) $data['logoffessm_id'] = $ffessmLogoId;
        // On ne touche plus à 'image_id' pour le logo principal

        if ($id) {
            $this->generalModel->update($id, $data);
        } else {
            $this->generalModel->insert($data);
        }

        return redirect()->to('/admin/general')->with('success', 'Informations mises à jour.');
    }
}
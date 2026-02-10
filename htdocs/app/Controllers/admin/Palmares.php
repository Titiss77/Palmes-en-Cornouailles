<?php

namespace App\Controllers\admin;

use App\Models\admin\MembresModel;
use App\Models\admin\PalmaresModel;

class Palmares extends BaseAdminController
{
    protected $palmaresModel;
    protected $membresModel;

    public function __construct()
    {
        $this->palmaresModel = new PalmaresModel();
        $this->membresModel = new MembresModel();
    }

    public function index()
    {
        $data = $this->getCommonData('Gestion du Palmarès', 'admin/page.css');
        $data['palmares'] = $this->palmaresModel->getPalmaresWithRelations();
        return view('admin/palmares/index', $data);
    }

    public function new()
    {
        $data = $this->getCommonData('Ajouter une performance', 'admin/page.css');
        // On a besoin de la liste des membres pour le menu déroulant
        $data['membres'] = $this->membresModel->orderBy('nom', 'ASC')->findAll();
        return view('admin/palmares/create', $data);
    }

    public function create()
    {
        if (!$this->validate([
            'membre_id' => 'required|integer',
            'competition' => 'required|max_length[150]',
            'epreuve' => 'required|max_length[100]',
            'classement' => 'required',
            'date_epreuve' => 'required|valid_date',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 1. Génération du nom personnalisé pour l'image (Ex: Maelys_LE_BIGOT_Championnats_France)
        $membre = $this->membresModel->find($this->request->getPost('membre_id'));
        $nomNageur = $membre ? $membre['nom'] : 'Nageur';  // Supposant que 'nom' contient "Prénom NOM" ou concaténé
        $competition = $this->request->getPost('competition');

        $customImageName = $nomNageur . '_' . $competition;

        // 2. Upload avec le nom personnalisé
        $imageId = $this->handleImageUpload('image', 'palmares', $customImageName);

        $data = [
            'membre_id' => $this->request->getPost('membre_id'),
            'competition' => $competition,
            'epreuve' => $this->request->getPost('epreuve'),
            'temps' => $this->request->getPost('temps'),
            'classement' => $this->request->getPost('classement'),
            'date_epreuve' => $this->request->getPost('date_epreuve'),
            'image_id' => $imageId
        ];

        $this->palmaresModel->insert($data);

        return redirect()->to('/admin/palmares')->with('success', 'Performance ajoutée.');
    }

    public function edit($id = null)
    {
        $data = $this->getCommonData('Modifier Performance', 'admin/page.css');
        $item = $this->palmaresModel->getPalmaresWithRelations($id);

        if (!$item)
            return redirect()->to('/admin/palmares')->with('error', 'Introuvable.');

        $data['item'] = $item;
        $data['membres'] = $this->membresModel->orderBy('nom', 'ASC')->findAll();

        return view('admin/palmares/edit', $data);
    }

    public function update($id = null)
    {
        if (!$this->validate([
            'membre_id' => 'required|integer',
            'competition' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Récupération pour nommage image
        $membre = $this->membresModel->find($this->request->getPost('membre_id'));
        $nomNageur = $membre ? $membre['nom'] : 'Nageur';
        $competition = $this->request->getPost('competition');
        $customImageName = $nomNageur . '_' . $competition;

        $imageId = $this->handleImageUpload('image', 'palmares', $customImageName);

        $data = [
            'membre_id' => $this->request->getPost('membre_id'),
            'competition' => $competition,
            'epreuve' => $this->request->getPost('epreuve'),
            'temps' => $this->request->getPost('temps'),
            'classement' => $this->request->getPost('classement'),
            'date_epreuve' => $this->request->getPost('date_epreuve'),
        ];

        if ($imageId) {
            $data['image_id'] = $imageId;
        }

        $this->palmaresModel->update($id, $data);
        return redirect()->to('/admin/palmares')->with('success', 'Mise à jour effectuée.');
    }

    public function delete($id = null)
    {
        // ... (Logique identique aux autres contrôleurs pour supprimer image + entrée)
        $item = $this->palmaresModel->getPalmaresWithRelations($id);
        if ($item) {
            if (!empty($item['image_path'])) {
                $path = FCPATH . 'uploads/' . $item['image_path'];
                if (file_exists($path))
                    unlink($path);
                // Suppression entrée image en BDD si besoin...
            }
            $this->palmaresModel->delete($id);
            return redirect()->to('/admin/palmares')->with('success', 'Supprimé.');
        }
        return redirect()->back();
    }

    public function deleteImage($id = null)
    {
        $membre = $this->membresModel->getMembresWithRelations($id);

        if (!$membre || empty($membre['image_id'])) {
            return redirect()->back();
        }

        $oldImageId = $membre['image_id'];
        $oldImagePath = $membre['image_path'];

        // Récupère l'ID de l'image par défaut "membres/vide.jpg"
        $defaultId = $this->getDefaultImageId();

        // Si l'utilisateur a déjà l'image par défaut, on ne fait rien
        if ($oldImageId == $defaultId) {
            return redirect()->back()->with('error', "C'est déjà l'image par défaut.");
        }

        // 1. On remplace l'image actuelle par l'image par défaut
        $this->membresModel->update($id, ['image_id' => $defaultId]);

        // 2. On essaie de supprimer l'ancienne image (si orpheline)
        $this->nettoyerImageOrpheline($oldImageId, $oldImagePath);

        return redirect()->back()->with('success', 'Photo réinitialisée (défaut).');
    }
}
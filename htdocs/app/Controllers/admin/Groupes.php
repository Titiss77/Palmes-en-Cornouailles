<?php

namespace App\Controllers\admin;

use App\Models\admin\GroupesModel;

class Groupes extends BaseAdminController
{
    protected $groupeModel;

    public function __construct()
    {
        $this->groupeModel = new GroupesModel();
    }

    // 1. LISTE
    public function index()
    {
        $data = $this->getCommonData('Gestion des Groupes', 'admin/page.css');
        $data['groupes'] = $this->groupeModel->getGroupesWithRelations();

        return view('admin/groupes/index', $data);
    }

    // 2. FORMULAIRE DE CRÉATION
    public function new()
    {
        $data = $this->getCommonData('Nouveau Groupe', 'admin/page.css');
        return view('admin/groupes/create', $data);
    }

    // 3. TRAITEMENT DE CRÉATION
    public function create()
    {
        if (!$this->validate([
            'nom' => 'required|min_length[2]|max_length[100]',
            'prix' => 'required|max_length[50]',
            'ordre' => 'integer'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload de l'image dans le dossier 'groupes'
        $imageId = $this->handleImageUpload('image', 'groupes', $this->request->getPost('nom'));

        $data = [
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'tranche_age' => $this->request->getPost('tranche_age'),
            'horaire_resume' => $this->request->getPost('horaire_resume'),
            'prix' => $this->request->getPost('prix'),
            'codeCouleur' => $this->request->getPost('codeCouleur'),
            'ordre' => $this->request->getPost('ordre') ?? 0,
            'image_id' => $imageId
        ];

        $this->groupeModel->insert($data);

        return redirect()->to('/admin/groupes')->with('success', 'Groupe créé avec succès.');
    }

    // 4. FORMULAIRE D'ÉDITION
    public function edit($id = null)
    {
        $data = $this->getCommonData('Modifier Groupe', 'admin/page.css');
        $item = $this->groupeModel->getGroupesWithRelations($id);

        if (!$item) {
            return redirect()->to('/admin/groupes')->with('error', 'Groupe introuvable.');
        }

        $data['item'] = $item;
        return view('admin/groupes/edit', $data);
    }

    // 5. TRAITEMENT DE MISE À JOUR
    public function update($id = null)
    {
        if (!$this->validate([
            'nom' => 'required|min_length[2]|max_length[100]',
            'prix' => 'required|max_length[50]',
            'ordre' => 'integer'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageId = $this->handleImageUpload('image', 'groupes', $this->request->getPost('nom'));

        $data = [
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'tranche_age' => $this->request->getPost('tranche_age'),
            'horaire_resume' => $this->request->getPost('horaire_resume'),
            'prix' => $this->request->getPost('prix'),
            'codeCouleur' => $this->request->getPost('codeCouleur'),
            'ordre' => $this->request->getPost('ordre')
        ];

        if ($imageId) {
            $data['image_id'] = $imageId;
        }

        $this->groupeModel->update($id, $data);

        return redirect()->to('/admin/groupes')->with('success', 'Groupe mis à jour.');
    }

    // 6. SUPPRESSION
    public function delete($id = null)
    {
        $groupe = $this->groupeModel->getGroupesWithRelations($id);

        if ($groupe) {
            // Suppression de l'image physique si elle existe
            if (!empty($groupe['image_path'])) {
                $cheminFichier = FCPATH . 'uploads/' . $groupe['image_path'];
                if (file_exists($cheminFichier)) {
                    unlink($cheminFichier);
                }
                // Suppression de l'entrée dans la table images
                if (!empty($groupe['image_id'])) {
                    $db = \Config\Database::connect();
                    $db->table('images')->where('id', $groupe['image_id'])->delete();
                }
            }

            $this->groupeModel->delete($id);
            return redirect()->to('/admin/groupes')->with('success', 'Groupe supprimé.');
        }

        return redirect()->to('/admin/groupes')->with('error', 'Introuvable.');
    }

    // 7. SUPPRESSION IMAGE SEULE
    public function deleteImage($id = null)
    {
        $groupe = $this->groupeModel->getGroupesWithRelations($id);

        if (!$groupe || empty($groupe['image_id'])) {
            return redirect()->back();
        }

        $imageId = $groupe['image_id'];
        $imagePath = $groupe['image_path'];

        // Détacher l'image du groupe
        $this->groupeModel->update($id, ['image_id' => null]);

        // Supprimer l'entrée image et le fichier
        $db = \Config\Database::connect();
        $db->table('images')->where('id', $imageId)->delete();

        if (!empty($imagePath)) {
            $fullPath = FCPATH . 'uploads/' . $imagePath;
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        return redirect()->back()->with('success', 'Image supprimée.');
    }
}
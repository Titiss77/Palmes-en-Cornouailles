<?php

namespace App\Controllers\admin;

use App\Models\admin\PiscinesModel;

class Piscines extends BaseadminController
{
    protected $piscineModel;

    public function __construct()
    {
        $this->piscineModel = new PiscinesModel();
    }

    // 1. LISTE
    public function index()
    {
        $data = $this->getCommonData('Gestion des Lieux', 'admin/page.css');
        $data['piscines'] = $this->piscineModel->getPiscinesWithRelations();

        return view('admin/piscines/index', $data);
    }

    // 2. FORMULAIRE DE CRÉATION
    public function new()
    {
        $data = $this->getCommonData('Nouveau Lieu', 'admin/page.css');
        return view('admin/piscines/create', $data);
    }

    // 3. TRAITEMENT DE CRÉATION
    public function create()
    {
        if (!$this->validate([
            'nom' => 'required|min_length[3]|max_length[100]',
            'adresse' => 'required|min_length[5]|max_length[255]',
            'type_bassin' => 'required|in_list[25m,50m]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload de l'image (dossier 'piscines')
        $imageId = $this->handleImageUpload('image', 'piscines');

        $data = [
            'nom' => $this->request->getPost('nom'),
            'adresse' => $this->request->getPost('adresse'),
            'type_bassin' => $this->request->getPost('type_bassin'),
            'image_id' => $imageId
        ];

        $this->piscineModel->insert($data);

        return redirect()->to('/admin/piscines')->with('success', 'Lieu ajouté avec succès.');
    }

    // 4. FORMULAIRE D'ÉDITION
    public function edit($id = null)
    {
        $data = $this->getCommonData('Modifier Lieu', 'admin/page.css');
        $item = $this->piscineModel->getPiscinesWithRelations($id);

        if (!$item) {
            return redirect()->to('/admin/piscines')->with('error', 'Lieu introuvable.');
        }

        $data['item'] = $item;
        return view('admin/piscines/edit', $data);
    }

    // 5. TRAITEMENT DE MISE À JOUR
    public function update($id = null)
    {
        if (!$this->validate([
            'nom' => 'required|min_length[3]|max_length[100]',
            'adresse' => 'required|min_length[5]|max_length[255]',
            'type_bassin' => 'required|in_list[25m,50m]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageId = $this->handleImageUpload('image', 'piscines');

        $data = [
            'nom' => $this->request->getPost('nom'),
            'adresse' => $this->request->getPost('adresse'),
            'type_bassin' => $this->request->getPost('type_bassin'),
        ];

        if ($imageId) {
            $data['image_id'] = $imageId;
        }

        $this->piscineModel->update($id, $data);

        return redirect()->to('/admin/piscines')->with('success', 'Lieu mis à jour.');
    }

    // 6. SUPPRESSION
    public function delete($id = null)
    {
        $item = $this->piscineModel->getPiscinesWithRelations($id);

        if ($item) {
            // Suppression physique et BDD de l'image
            if (!empty($item['image_path'])) {
                $cheminFichier = FCPATH . 'uploads/' . $item['image_path'];
                if (file_exists($cheminFichier)) {
                    unlink($cheminFichier);
                }
                if (!empty($item['image_id'])) {
                    $db = \Config\Database::connect();
                    $db->table('images')->where('id', $item['image_id'])->delete();
                }
            }

            $this->piscineModel->delete($id);
            return redirect()->to('/admin/piscines')->with('success', 'Lieu supprimé.');
        }

        return redirect()->to('/admin/piscines')->with('error', 'Introuvable.');
    }

    // 7. SUPPRESSION IMAGE SEULE
    public function deleteImage($id = null)
    {
        $item = $this->piscineModel->getPiscinesWithRelations($id);

        if (!$item || empty($item['image_id'])) {
            return redirect()->back();
        }

        $imageId = $item['image_id'];
        $imagePath = $item['image_path'];

        $this->piscineModel->update($id, ['image_id' => null]);

        $db = \Config\Database::connect();
        $db->table('images')->where('id', $imageId)->delete();

        if (!empty($imagePath)) {
            $fullPath = FCPATH . 'uploads/' . $imagePath;
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        return redirect()->back()->with('success', 'Photo supprimée.');
    }
}
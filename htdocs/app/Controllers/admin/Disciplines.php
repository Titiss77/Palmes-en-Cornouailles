<?php

namespace App\Controllers\admin;

use App\Models\admin\DisciplinesModel;

class Disciplines extends BaseAdminController
{
    protected $disciplineModel;

    public function __construct()
    {
        $this->disciplineModel = new DisciplinesModel();
    }

    // 1. LISTE
    public function index()
    {
        $data = $this->getCommonData('Gestion des Disciplines', 'admin/page.css');
        $data['disciplines'] = $this->disciplineModel->getDisciplinesWithRelations();

        return view('admin/disciplines/index', $data);
    }

    // 2. FORMULAIRE DE CRÉATION
    public function new()
    {
        $data = $this->getCommonData('Nouvelle Discipline', 'admin/page.css');
        return view('admin/disciplines/create', $data);
    }

    // 3. TRAITEMENT DE CRÉATION
    public function create()
    {
        if (!$this->validate([
            'nom' => 'required|min_length[3]|max_length[100]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload de l'image (dossier 'disciplines')
        $imageId = $this->handleImageUpload('image', 'disciplines', $this->request->getPost('nom'));

        $data = [
            'nom'         => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'image_id'    => $imageId
        ];

        $this->disciplineModel->insert($data);

        return redirect()->to('/admin/disciplines')->with('success', 'Discipline ajoutée avec succès.');
    }

    // 4. FORMULAIRE D'ÉDITION
    public function edit($id = null)
    {
        $data = $this->getCommonData('Modifier Discipline', 'admin/page.css');
        $item = $this->disciplineModel->getDisciplinesWithRelations($id);

        if (!$item) {
            return redirect()->to('/admin/disciplines')->with('error', 'Discipline introuvable.');
        }

        $data['item'] = $item;
        return view('admin/disciplines/edit', $data);
    }

    // 5. TRAITEMENT DE MISE À JOUR
    public function update($id = null)
    {
        if (!$this->validate([
            'nom' => 'required|min_length[3]|max_length[100]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageId = $this->handleImageUpload('image', 'disciplines', $this->request->getPost('nom'));

        $data = [
            'nom'         => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
        ];

        if ($imageId) {
            $data['image_id'] = $imageId;
        }

        $this->disciplineModel->update($id, $data);

        return redirect()->to('/admin/disciplines')->with('success', 'Discipline mise à jour.');
    }

    // 6. SUPPRESSION
    public function delete($id = null)
    {
        $item = $this->disciplineModel->getDisciplinesWithRelations($id);

        if ($item) {
            // Suppression fichier et entrée image
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

            $this->disciplineModel->delete($id);
            return redirect()->to('/admin/disciplines')->with('success', 'Discipline supprimée.');
        }

        return redirect()->to('/admin/disciplines')->with('error', 'Introuvable.');
    }

    // 7. SUPPRESSION IMAGE SEULE
    public function deleteImage($id = null)
    {
        $item = $this->disciplineModel->getDisciplinesWithRelations($id);

        if (!$item || empty($item['image_id'])) {
            return redirect()->back();
        }

        $imageId = $item['image_id'];
        $imagePath = $item['image_path'];

        $this->disciplineModel->update($id, ['image_id' => null]);

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
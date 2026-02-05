<?php

namespace App\Controllers\admin;

use App\Models\admin\PartenairesModel;

class Partenaires extends BaseAdminController
{
    protected $partenaireModel;

    public function __construct()
    {
        $this->partenaireModel = new PartenairesModel();
    }

    // 1. LISTE
    public function index()
    {
        $data = $this->getCommonData('Gestion des Partenaires', 'admin/page.css');
        $data['partenaires'] = $this->partenaireModel->getPartenairesWithRelations();

        return view('admin/partenaires/index', $data);
    }

    // 2. FORMULAIRE DE CRÉATION
    public function new()
    {
        $data = $this->getCommonData('Nouveau Partenaire', 'admin/page.css');
        return view('admin/partenaires/create', $data);
    }

    // 3. TRAITEMENT DE CRÉATION
    public function create()
    {
        if (!$this->validate([
            'description' => 'required|max_length[255]|is_unique[partenaires.description]', // "description" agit comme le nom
            'ordre'       => 'integer'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload logo dans le dossier 'partenaires'
        $imageId = $this->handleImageUpload('image', 'partenaires');

        $data = [
            'description' => $this->request->getPost('description'),
            'ordre'       => $this->request->getPost('ordre') ?? 1,
            'image_id'    => $imageId
        ];

        $this->partenaireModel->insert($data);

        return redirect()->to('/admin/partenaires')->with('success', 'Partenaire ajouté avec succès.');
    }

    // 4. FORMULAIRE D'ÉDITION
    public function edit($id = null)
    {
        $data = $this->getCommonData('Modifier Partenaire', 'admin/page.css');
        $item = $this->partenaireModel->getPartenairesWithRelations($id);

        if (!$item) {
            return redirect()->to('/admin/partenaires')->with('error', 'Partenaire introuvable.');
        }

        $data['item'] = $item;
        return view('admin/partenaires/edit', $data);
    }

    // 5. TRAITEMENT DE MISE À JOUR
    public function update($id = null)
    {
        // On vérifie l'unicité sauf pour l'ID courant
        if (!$this->validate([
            'description' => "required|max_length[255]|is_unique[partenaires.description,id,{$id}]",
            'ordre'       => 'integer'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageId = $this->handleImageUpload('image', 'partenaires');

        $data = [
            'description' => $this->request->getPost('description'),
            'ordre'       => $this->request->getPost('ordre')
        ];

        if ($imageId) {
            $data['image_id'] = $imageId;
        }

        $this->partenaireModel->update($id, $data);

        return redirect()->to('/admin/partenaires')->with('success', 'Partenaire mis à jour.');
    }

    // 6. SUPPRESSION
    public function delete($id = null)
    {
        $item = $this->partenaireModel->getPartenairesWithRelations($id);

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

            $this->partenaireModel->delete($id);
            return redirect()->to('/admin/partenaires')->with('success', 'Partenaire supprimé.');
        }

        return redirect()->to('/admin/partenaires')->with('error', 'Introuvable.');
    }

    // 7. SUPPRESSION LOGO SEUL
    public function deleteImage($id = null)
    {
        $item = $this->partenaireModel->getPartenairesWithRelations($id);

        if (!$item || empty($item['image_id'])) {
            return redirect()->back();
        }

        $imageId = $item['image_id'];
        $imagePath = $item['image_path'];

        $this->partenaireModel->update($id, ['image_id' => null]);

        $db = \Config\Database::connect();
        $db->table('images')->where('id', $imageId)->delete();

        if (!empty($imagePath)) {
            $fullPath = FCPATH . 'uploads/' . $imagePath;
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        return redirect()->back()->with('success', 'Logo supprimé.');
    }
}
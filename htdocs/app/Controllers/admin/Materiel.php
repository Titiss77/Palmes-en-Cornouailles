<?php

namespace App\Controllers\admin;

use App\Models\admin\MaterielModel;

class Materiel extends BaseAdminController
{
    protected $matModel;

    public function __construct()
    {
        $this->matModel = new MaterielModel();
    }

    // 1. LISTE
    public function index()
    {
        $data = $this->getCommonData('Gestion du Matériel', 'admin/page.css');
        $data['materiel'] = $this->matModel->getMaterielWithRelations();

        return view('admin/materiel/index', $data);
    }

    // 2. FORMULAIRE DE CRÉATION
    public function new()
    {
        $data = $this->getCommonData('Nouveau Matériel', 'admin/page.css');
        // On récupère les types de prêt pour le select
        $data['typesPret'] = $this->matModel->getTypesPret();
        
        return view('admin/materiel/create', $data);
    }

    // 3. TRAITEMENT DE CRÉATION
    public function create()
    {
        if (!$this->validate([
            'nom' => 'required|min_length[2]|max_length[100]',
            'idPret' => 'required|integer', // Le type de prêt est obligatoire
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageId = $this->handleImageUpload('image', 'materiel', $this->request->getPost('nom'));

        $data = [
            'nom'         => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'idPret'      => $this->request->getPost('idPret'),
            'image_id'    => $imageId
        ];

        $this->matModel->insert($data);

        return redirect()->to('/admin/materiel')->with('success', 'Matériel ajouté avec succès.');
    }

    // 4. FORMULAIRE D'ÉDITION
    public function edit($id = null)
    {
        $data = $this->getCommonData('Modifier Matériel', 'admin/page.css');
        $item = $this->matModel->getMaterielWithRelations($id);

        if (!$item) {
            return redirect()->to('/admin/materiel')->with('error', 'Élément introuvable.');
        }

        $data['item'] = $item;
        $data['typesPret'] = $this->matModel->getTypesPret();

        return view('admin/materiel/edit', $data);
    }

    // 5. TRAITEMENT DE MISE À JOUR
    public function update($id = null)
    {
        if (!$this->validate([
            'nom' => 'required|min_length[2]|max_length[100]',
            'idPret' => 'required|integer',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageId = $this->handleImageUpload('image', 'materiel', $this->request->getPost('nom'));
        

        $data = [
            'nom'         => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'idPret'      => $this->request->getPost('idPret'),
        ];

        if ($imageId) {
            $data['image_id'] = $imageId;
        }

        $this->matModel->update($id, $data);

        return redirect()->to('/admin/materiel')->with('success', 'Matériel mis à jour.');
    }

    // 6. SUPPRESSION
    public function delete($id = null)
    {
        $item = $this->matModel->getMaterielWithRelations($id);

        if ($item) {
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

            $this->matModel->delete($id);
            return redirect()->to('/admin/materiel')->with('success', 'Élément supprimé.');
        }

        return redirect()->to('/admin/materiel')->with('error', 'Introuvable.');
    }

    // 7. SUPPRESSION IMAGE SEULE
    public function deleteImage($id = null)
    {
        $item = $this->matModel->getMaterielWithRelations($id);

        if (!$item || empty($item['image_id'])) {
            return redirect()->back();
        }

        $imageId = $item['image_id'];
        $imagePath = $item['image_path'];

        $this->matModel->update($id, ['image_id' => null]);

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
<?php

namespace App\Controllers\admin;

use App\Models\admin\PalmaresModel;

class Palmares extends BaseAdminController
{
    protected $palmaresModel;

    public function __construct()
    {
        $this->palmaresModel = new PalmaresModel();
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
        return view('admin/palmares/create', $data);
    }

    public function create()
    {
        // Validation des nouveaux champs
        if (!$this->validate([
            'nom_nageur'    => 'required|min_length[2]',
            'prenom_nageur' => 'required|min_length[2]',
            'competition'   => 'required|max_length[150]',
            'epreuve'       => 'required|max_length[100]',
            'classement'    => 'required',
            'date_epreuve'  => 'required|valid_date',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 1. Génération du nom pour l'image via les inputs
        $nom = $this->request->getPost('nom_nageur');
        $prenom = $this->request->getPost('prenom_nageur');
        $epreuve = $this->request->getPost('epreuve');
        
        // Ex: LE_BIGOT_Maelys_Championnats_France
        $customImageName = $nom . '_' . $prenom . '_' . $epreuve;

        // 2. Upload
        $imageId = $this->handleImageUpload('image', 'palmares', $customImageName);

        $data = [
            'nom_nageur'    => $nom,
            'prenom_nageur' => $prenom,
            'competition'   => $this->request->getPost('competition'),
            'epreuve'       => $epreuve,
            'temps'         => $this->request->getPost('temps'),
            'classement'    => $this->request->getPost('classement'),
            'date_epreuve'  => $this->request->getPost('date_epreuve'),
            'image_id'      => $imageId
        ];

        $this->palmaresModel->insert($data);

        return redirect()->to('/admin/palmares')->with('success', 'Performance ajoutée.');
    }

    public function edit($id = null)
    {
        $data = $this->getCommonData('Modifier Performance', 'admin/page.css');
        $item = $this->palmaresModel->getPalmaresWithRelations($id);

        if (!$item) return redirect()->to('/admin/palmares')->with('error', 'Introuvable.');

        $data['item'] = $item;
        return view('admin/palmares/edit', $data);
    }

    public function update($id = null)
    {
        if (!$this->validate([
            'nom_nageur'    => 'required|min_length[2]',
            'prenom_nageur' => 'required|min_length[2]',
            'competition'   => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nom = $this->request->getPost('nom_nageur');
        $prenom = $this->request->getPost('prenom_nageur');
        $epreuve = $this->request->getPost('epreuve');
        
        $customImageName = $nom . '_' . $prenom . '_' . $epreuve;

        $imageId = $this->handleImageUpload('image', 'palmares', $customImageName);

        $data = [
            'nom_nageur'    => $nom,
            'prenom_nageur' => $prenom,
            'competition'   => $this->request->getPost('competition'),
            'epreuve'       => $epreuve,
            'temps'         => $this->request->getPost('temps'),
            'classement'    => $this->request->getPost('classement'),
            'date_epreuve'  => $this->request->getPost('date_epreuve'),
        ];

        if ($imageId) {
            $data['image_id'] = $imageId;
        }

        $this->palmaresModel->update($id, $data);
        return redirect()->to('/admin/palmares')->with('success', 'Mise à jour effectuée.');
    }
    
    // ... méthode delete() et deleteImage() inchangées ...
     public function delete($id = null)
    {
        $item = $this->palmaresModel->getPalmaresWithRelations($id);
        if ($item) {
             if (!empty($item['image_path'])) {
                $path = FCPATH . 'uploads/' . $item['image_path'];
                if (file_exists($path)) unlink($path);
                 if (!empty($item['image_id'])) {
                    $db = \Config\Database::connect();
                    $db->table('images')->where('id', $item['image_id'])->delete();
                }
            }
            $this->palmaresModel->delete($id);
            return redirect()->to('/admin/palmares')->with('success', 'Supprimé.');
        }
        return redirect()->back();
    }
    
      public function deleteImage($id = null)
    {
        $item = $this->palmaresModel->getPalmaresWithRelations($id);

        if (!$item || empty($item['image_id'])) {
            return redirect()->back();
        }

        $imageId = $item['image_id'];
        $imagePath = $item['image_path'];

        $this->palmaresModel->update($id, ['image_id' => null]);

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
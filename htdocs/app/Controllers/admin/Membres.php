<?php

namespace App\Controllers\admin;

use App\Models\admin\FonctionsModel;
use App\Models\admin\MembresModel;

class Membres extends BaseAdminController
{
    protected $membresModel;
    protected $fonctionsModel;

    // CHEMIN EXACT DE L'IMAGE PAR DÉFAUT (relatif au dossier uploads/)
    const DEFAULT_IMAGE_PATH = 'membres/vide.jpg';

    public function __construct()
    {
        $this->membresModel = new MembresModel();
        $this->fonctionsModel = new FonctionsModel();
    }

    public function index()
    {
        $data = $this->getCommonData('Gestion des Membres', 'admin/page.css');
        $data['membres'] = $this->membresModel->getMembresWithRelations();

        return view('admin/membres/index', $data);
    }

    public function new()
    {
        $data = $this->getCommonData('Nouveau Membre', 'admin/page.css');
        $data['fonctions'] = $this->fonctionsModel->orderBy('titre', 'ASC')->findAll();

        return view('admin/membres/create', $data);
    }

    public function create()
    {
        if (!$this->validate([
            'nom' => 'required|min_length[2]|max_length[100]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 1. Gestion de l'image
        $imageId = $this->handleImageUpload('image', 'membres', $this->request->getPost('nom'));

        // SI AUCUNE IMAGE : On assigne l'image par défaut
        if (!$imageId) {
            $imageId = $this->getDefaultImageId();
        }

        // 2. Création
        $memberData = [
            'nom' => $this->request->getPost('nom'),
            'image_id' => $imageId
        ];

        $newId = $this->membresModel->insert($memberData);

        // 3. Rôles
        $roles = $this->request->getPost('fonctions');
        if ($newId) {
            $this->membresModel->updateRoles($newId, $roles);
        }

        return redirect()->to('/admin/membres')->with('success', 'Membre ajouté avec succès.');
    }

    public function edit($id = null)
    {
        $data = $this->getCommonData('Modifier Membre', 'admin/page.css');
        $item = $this->membresModel->getMembresWithRelations($id);

        if (!$item) {
            return redirect()->to('/admin/membres')->with('error', 'Membre introuvable.');
        }

        $data['item'] = $item;
        $data['fonctions'] = $this
            ->fonctionsModel
            ->select('*, CASE 
        WHEN titre = "President" THEN 1 
        WHEN titre = "Vice-Président" THEN 2 
        WHEN titre = "Comptable" THEN 3 
        WHEN titre = "Secrétaire" THEN 4 
        WHEN titre = "Sponsoring" THEN 5 
        WHEN titre = "Informatique" THEN 6
        WHEN titre = "Coach" THEN 7 
        WHEN titre = "Coach en formation" THEN 8
        ELSE 99 
    END as ordre_affichage', false)  // <--- AJOUT DE false ICI
            ->orderBy('ordre_affichage', 'ASC')
            ->findAll();
        $data['currentRoles'] = !empty($item['roles_ids']) ? explode(',', $item['roles_ids']) : [];

        return view('admin/membres/edit', $data);
    }

    public function update($id = null)
    {
        if (!$this->validate([
            'nom' => 'required|min_length[2]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Récupération infos actuelles
        $oldMembre = $this->membresModel->find($id);
        $oldImageId = $oldMembre['image_id'] ?? null;

        // Tentative upload nouvelle image
        $newImageId = $this->handleImageUpload('image', 'membres', $this->request->getPost('nom'));

        $data = ['nom' => $this->request->getPost('nom')];

        // Si nouvelle image uploadée, on remplace
        if ($newImageId) {
            $data['image_id'] = $newImageId;
        }

        $this->membresModel->update($id, $data);

        // Nettoyage ancienne image SI on a changé ET que ce n'est pas l'image par défaut
        if ($newImageId && $oldImageId && $newImageId !== $oldImageId) {
            $oldImageRow = \Config\Database::connect()->table('images')->where('id', $oldImageId)->get()->getRow();
            if ($oldImageRow) {
                $this->nettoyerImageOrpheline($oldImageId, $oldImageRow->path);
            }
        }

        $roles = $this->request->getPost('fonctions');
        $this->membresModel->updateRoles($id, $roles);

        return redirect()->to('/admin/membres')->with('success', 'Membre mis à jour.');
    }

    public function delete($id = null)
    {
        $membre = $this->membresModel->getMembresWithRelations($id);

        if ($membre) {
            $imageId = $membre['image_id'];
            $imagePath = $membre['image_path'];

            $this->membresModel->delete($id);

            // Vérifie si on peut nettoyer l'image (si ce n'est pas celle par défaut)
            if ($imageId) {
                $this->nettoyerImageOrpheline($imageId, $imagePath);
            }

            return redirect()->to('/admin/membres')->with('success', 'Membre supprimé.');
        }

        return redirect()->to('/admin/membres')->with('error', 'Introuvable.');
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

    /**
     * Récupère l'ID de l'image 'membres/vide.jpg'.
     * La crée en BDD si elle n'existe pas encore.
     */
    private function getDefaultImageId()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('images');

        // On cherche le chemin exact "membres/vide.jpg"
        $path = self::DEFAULT_IMAGE_PATH;

        $row = $builder->where('path', $path)->get()->getRow();

        if ($row) {
            return $row->id;
        }

        // Création de l'entrée dans la BDD si elle n'existe pas
        $builder->insert([
            'path' => $path,
            'alt' => 'Avatar par défaut',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return $db->insertID();
    }

    /**
     * Supprime une image physiquement et en BDD seulement si :
     * 1. Elle n'est plus utilisée par aucun membre
     * 2. Ce n'est PAS l'image par défaut (membres/vide.jpg)
     */
    private function nettoyerImageOrpheline($imageId, $imagePath)
    {
        // =========================================================
        // PROTECTION ABSOLUE
        // Si le chemin correspond à l'image par défaut, ON ARRÊTE TOUT.
        // =========================================================
        if ($imagePath === self::DEFAULT_IMAGE_PATH) {
            return;  // On ne touche ni à la BDD ni au fichier
        }

        // Si ce n'est pas l'image par défaut, on vérifie si elle est encore utilisée
        $count = $this->membresModel->where('image_id', $imageId)->countAllResults();

        if ($count == 0) {
            // Suppression BDD
            $db = \Config\Database::connect();
            $db->table('images')->where('id', $imageId)->delete();

            // Suppression Fichier
            $fullPath = FCPATH . 'uploads/' . $imagePath;
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }
}
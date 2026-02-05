<?php

namespace App\Controllers\admin;

use App\Models\admin\ActualiteModel;

class Actualites extends BaseAdminController
{
    protected $actuModel;

    public function __construct()
    {
        // On instancie le modèle
        $this->actuModel = new ActualiteModel();
    }

    // 1. LISTE DES ACTUALITÉS
    public function index()
    {
        $data = $this->getCommonData('Gestion Actualités', 'admin/page.css');

        // Récupération via le modèle
        $data['actualites'] = $this->actuModel->getActualitesWithRelations();

        return view('admin/actualites/index', $data);
    }

    // 2. pageULAIRE DE CRÉATION
    public function new()
    {
        $data = $this->getCommonData('Nouvelle Actualité', 'admin/page.css');
        return view('admin/actualites/create', $data);
    }

    function nettoyer_chaine($chaine)
    {
        // 1. Translitérer les accents (é -> e, ç -> c)
        $chaine = iconv('UTF-8', 'ASCII//TRANSLIT', $chaine);

        // 2. Supprimer tout ce qui n'est pas lettre, chiffre ou tiret
        $chaine = preg_replace('/[^a-zA-Z0-9 -]/', '', $chaine);

        // 3. Mettre en minuscule
        $chaine = strtolower($chaine);

        // 4. Remplacer les espaces par des tirets
        $chaine = str_replace(' ', '-', $chaine);

        return $chaine;
    }

    // 3. TRAITEMENT DE CRÉATION
    public function create()
    {
        // Règles de validation
        if (!$this->validate([
            'titre' => 'required|min_length[3]|max_length[150]',
            'description' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload de l'image via la méthode du BaseadminController
        $imageId = $this->handleImageUpload('image', 'actualites');

        $data = [
            'titre' => $this->request->getPost('titre'),
            'slug' => $this->nettoyer_chaine($this->request->getPost('titre')),
            'description' => $this->request->getPost('description'),
            'date_evenement' => $this->request->getPost('date_evenement') ?: null,
            'statut' => $this->request->getPost('statut'),
            'type' => 'actualite',
            'id_auteur' => session()->get('user_id') ?? 1,  // ID de l'admin connecté
            'image_id' => $imageId
        ];

        $this->actuModel->insert($data);

        return redirect()->to('/admin/actualites')->with('success', 'Actualité créée avec succès.');
    }

    // 4. pageULAIRE D'ÉDITION
    public function edit($id = null)
    {
        $data = $this->getCommonData('Modifier Actualité', 'admin/page.css');

        $item = $this->actuModel->getActualitesWithRelations($id);

        if (!$item) {
            return redirect()->to('/admin/actualites')->with('error', 'Article introuvable.');
        }

        $data['item'] = $item;

        return view('admin/actualites/edit', $data);
    }

    // 5. TRAITEMENT DE MISE À JOUR
    public function update($id = null)
    {
        // Validation
        if (!$this->validate([
            'titre' => 'required|min_length[3]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload nouvelle image (si présente)
        $imageId = $this->handleImageUpload('image', 'actualites');

        $data = [
            'titre' => $this->request->getPost('titre'),
            'slug' => url_title($this->request->getPost('titre'), '-', true),
            'description' => $this->request->getPost('description'),
            'date_evenement' => $this->request->getPost('date_evenement') ?: null,
            'statut' => $this->request->getPost('statut'),
        ];

        // On ne met à jour l'image que si une nouvelle a été envoyée
        if ($imageId) {
            $data['image_id'] = $imageId;
        }

        $this->actuModel->update($id, $data);

        return redirect()->to('/admin/actualites')->with('success', 'Actualité mise à jour.');
    }

    // 6. SUPPRESSION COMPLÈTE (BDD + FICHIER)
    public function delete($id = null)
    {
        // 1. Récupérer les infos de l'actualité pour obtenir le chemin de l'image
        // On utilise la méthode existante qui fait la jointure avec la table images
        $actualite = $this->actuModel->getActualitesWithRelations($id);

        if ($actualite) {
            // 2. Si une image est associée, on la supprime physiquement
            if (!empty($actualite['image_path'])) {
                // FCPATH pointe vers la racine du dossier 'public'
                $cheminFichier = FCPATH . 'uploads/' . $actualite['image_path'];

                if (file_exists($cheminFichier)) {
                    unlink($cheminFichier);  // Suppression du fichier
                }

                // 3. (Optionnel) Supprimer aussi la ligne dans la table 'images' pour éviter les orphelins
                // Si vous ne le faites pas, le fichier disparaît mais la ligne reste en BDD 'images'
                if (!empty($actualite['image_id'])) {
                    $db = \Config\Database::connect();
                    $db->table('images')->where('id', $actualite['image_id'])->delete();
                }
            }

            // 4. Suppression de l'actualité elle-même
            $this->actuModel->delete($id);

            return redirect()->to('/admin/actualites')->with('success', 'Actualité et image supprimées avec succès.');
        }

        return redirect()->to('/admin/actualites')->with('error', 'Impossible de trouver cet article.');
    }

    // 7. SUPPRESSION UNIQUEMENT DE L'IMAGE
    public function deleteImage($id = null)
    {
        // Récupère l'article
        $article = $this->actuModel->getActualitesWithRelations($id);

        if (!$article || empty($article['image_id'])) {
            return redirect()->back()->with('error', 'Aucune image à supprimer.');
        }

        // Sauvegarde des infos avant de modifier la BDD
        $imageId = $article['image_id'];
        $imagePath = $article['image_path'];

        // ÉTAPE 1 (CRUCIALE) : On détache d'abord l'image de l'article
        // Cela empêche la suppression en cascade de l'article
        $this->actuModel->update($id, ['image_id' => null]);

        // ÉTAPE 2 : On supprime l'entrée dans la table 'images'
        $db = \Config\Database::connect();
        $db->table('images')->where('id', $imageId)->delete();

        // ÉTAPE 3 : Suppression physique du fichier
        // Note : On utilise directement image_path car il contient déjà "uploads/..." (voir BaseadminController)
        if (!empty($imagePath)) {
            $cheminFichier = FCPATH . 'uploads/' . $imagePath;

            if (file_exists($cheminFichier)) {
                unlink($cheminFichier);
            }
        }

        return redirect()->back()->with('success', 'Image supprimée avec succès.');
    }
}
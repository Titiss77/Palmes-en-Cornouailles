<?php

namespace App\Controllers\admin;

use App\Models\admin\BoutiquesModel;

class Boutiques extends BaseAdminController
{
    protected $boutiquesModel;

    public function __construct()
    {
        // Instanciation du modèle (tel que défini dans vos fichiers)
        $this->boutiquesModel = new BoutiquesModel();
    }

    // 1. LISTE DES ARTICLES
    public function index()
    {
        $data = $this->getCommonData('Gestion Boutique', 'admin/page.css');
        
        // Utilisation de la méthode existante dans votre modèle
        $data['boutiques'] = $this->boutiquesModel->getBoutiquesWithRelations();

        return view('admin/boutiques/index', $data);
    }

    // 2. pageULAIRE DE CRÉATION
    public function new()
    {
        $data = $this->getCommonData('Nouvel Article', 'admin/page.css');
        return view('admin/boutiques/create', $data);
    }

    // 3. TRAITEMENT DE CRÉATION
    public function create()
    {
        // Validation des champs
        if (!$this->validate([
            'nom' => 'required|min_length[3]|max_length[50]',
            'description' => 'required',
            'tranchePrix' => 'required|max_length[50]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Préparation des données
        $data = [
            'nom' => $this->request->getPost('nom'),
            'url' => $this->request->getPost('url'),
            'description' => $this->request->getPost('description'),
            'tranchePrix' => $this->request->getPost('tranchePrix'),
        ];

        // Insertion via le modèle
        $this->boutiquesModel->insert($data);

        return redirect()->to('/admin/boutiques')->with('success', 'Article créé avec succès.');
    }

    // 4. pageULAIRE D'ÉDITION
    public function edit($id = null)
    {
        $data = $this->getCommonData('Modifier Article', 'admin/page.css');

        // Récupération de l'article
        $item = $this->boutiquesModel->getBoutiquesWithRelations($id);

        if (!$item) {
            return redirect()->to('/admin/boutiques')->with('error', 'Article introuvable.');
        }

        $data['item'] = $item;

        return view('admin/boutiques/edit', $data);
    }

    // 5. TRAITEMENT DE MISE À JOUR
    public function update($id = null)
    {
        // Validation
        if (!$this->validate([
            'nom' => 'required|min_length[3]|max_length[50]',
            'description' => 'required',
            'tranchePrix' => 'required|max_length[50]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nom' => $this->request->getPost('nom'),
            'url' => $this->request->getPost('url'),
            'description' => $this->request->getPost('description'),
            'tranchePrix' => $this->request->getPost('tranchePrix'),
        ];

        $this->boutiquesModel->update($id, $data);

        return redirect()->to('/admin/boutiques')->with('success', 'Article mis à jour.');
    }

    // 6. SUPPRESSION
    public function delete($id = null)
    {
        $article = $this->boutiquesModel->getBoutiquesWithRelations($id);

        if ($article) {
            $this->boutiquesModel->delete($id);
            return redirect()->to('/admin/boutiques')->with('success', 'Article supprimé.');
        }

        return redirect()->to('/admin/boutiques')->with('error', 'Impossible de trouver cet article.');
    }
}
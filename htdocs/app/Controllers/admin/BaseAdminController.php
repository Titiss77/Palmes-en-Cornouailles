<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Controllers\Root;
use App\Models\Public\Donnees;

class BaseAdminController extends BaseController
{
    protected $donneesModel;
    protected $root;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Initialisation parent
        parent::initController($request, $response, $logger);

        // Chargement des outils communs
        $this->donneesModel = new Donnees();
        $this->root = new Root(); // Note: Idéalement, Root devrait être une Library ou un Helper
    }

    /**
     * Méthode utilitaire pour gérer l'upload et la création de l'image en BDD
     * @return int|null ID de l'image ou null
     */
    protected function handleImageUpload($fileInputName, $subfolder = 'general')
    {
        $file = $this->request->getFile($fileInputName);

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // 1. Déplacer le fichier
            $newName = $file->getName(); // Ou $file->getName() si vous voulez garder le nom
            $pathStr = $subfolder . '/';
            
            // Créer le dossier s'il n'existe pas
            if (!is_dir(FCPATH . 'uploads/'.$pathStr)) {
                mkdir(FCPATH . 'uploads/'.$pathStr, 0777, true);
            }

            $file->move(FCPATH . 'uploads/'.$pathStr, $newName);
            $fullPath = $pathStr . $newName;

            // 2. Insérer dans la table images
            $db = \Config\Database::connect();
            $builder = $db->table('images');
            
            // Vérifier si existe déjà (optionnel)
            $existing = $builder->where('path', $fullPath)->get()->getRow();
            if ($existing) {
                return $existing->id;
            }

            $builder->insert([
                'path' => $fullPath,
                'alt'  => $file->getClientName(), // Nom d'origine comme texte alt par défaut
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            return $db->insertID();
        }

        return null;
    }

    /**
     * Charge les données de base pour les vues admin
     */
    protected function getCommonData(string $title, string $cssPage = '')
    {
        return [
            'root'      => $this->root->getRootStyles(),
            'general'   => $this->donneesModel->getGeneral(),
            'titrePage' => $title,
            'cssPage'   => $cssPage,
            'isLogged'  => session()->get('isLoggedIn'),
            'userNom'   => session()->get('nom')
        ];
    }
}
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
        $this->root = new Root();  // Note: Idéalement, Root devrait être une Library ou un Helper
    }

    // AJOUTER CETTE FONCTION POUR NETTOYER LE NOM
    protected function sanitizeFilename($filename)
    {
        // 1. Translittération (enlève les accents : ë -> e, é -> e)
        setlocale(LC_ALL, 'en_US.utf8');
        $filename = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $filename);

        // 2. Remplacer les espaces par des underscores
        $filename = str_replace(' ', '_', $filename);

        // 3. Ne garder que les lettres, chiffres, tirets et underscores
        $filename = preg_replace('/[^A-Za-z0-9\-\_]/', '', $filename);

        // 4. Éviter les underscores multiples (ex: "Jean  Pierre" -> "Jean_Pierre")
        $filename = preg_replace('/_+/', '_', $filename);

        return trim($filename, '_');
    }

    /**
     * MODIFICATION DE LA MÉTHODE handleImageUpload
     * Ajout du paramètre $customName (optionnel)
     */
    protected function handleImageUpload($fileInputName, $subfolder = 'general', $customName = null)
    {
        $file = $this->request->getFile($fileInputName);

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // DÉBUT MODIFICATION ------------------------------
            if ($customName) {
                // Si un nom est fourni, on le nettoie et on ajoute l'extension du fichier
                $extension = $file->getExtension();
                // Si l'extension est vide, on tente de la deviner
                if (empty($extension)) {
                    $extension = $file->guessExtension();
                }
                $newName = $this->sanitizeFilename($customName) . '.' . $extension;
            } else {
                // Sinon comportement par défaut (nom du fichier d'origine)
                $newName = $file->getName();
            }
            // FIN MODIFICATION --------------------------------

            $pathStr = $subfolder . '/';

            if (!is_dir(FCPATH . 'uploads/' . $pathStr)) {
                mkdir(FCPATH . 'uploads/' . $pathStr, 0777, true);
            }

            // Note: CodeIgniter gère automatiquement les doublons en ajoutant _1, _2 si le fichier existe déjà
            // sauf si vous ajoutez le paramètre true pour écraser : $file->move(..., ..., true);
            $file->move(FCPATH . 'uploads/' . $pathStr, $newName);
            $fullPath = $pathStr . $newName;

            // 2. Insérer dans la table images
            $db = \Config\Database::connect();
            $builder = $db->table('images');

            $existing = $builder->where('path', $fullPath)->get()->getRow();
            if ($existing) {
                return $existing->id;
            }

            $builder->insert([
                'path' => $fullPath,
                'alt' => $customName ?: $file->getClientName(),  // On peut aussi utiliser le nom comme ALT
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
            'root' => $this->root->getRootStyles(),
            'general' => $this->donneesModel->getGeneral(),
            'titrePage' => $title,
            'cssPage' => $cssPage,
            'isLogged' => session()->get('isLoggedIn'),
            'userNom' => session()->get('nom')
        ];
    }
}
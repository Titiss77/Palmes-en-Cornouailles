<?php

declare(strict_types=1);

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Controllers\Root;
use App\Models\Public\Donnees;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;
use Psr\Log\LoggerInterface;

class BaseAdminController extends BaseController
{
    protected $donneesModel;
    protected $root;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger): void
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
     * Ajout du paramètre $customName (optionnel).
     *
     * @param mixed      $fileInputName
     * @param mixed      $subfolder
     * @param null|mixed $customName
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
                
                // AJOUT DU TIMESTAMP (time) POUR CASSER LE CACHE ET FORCER UN NOUVEL ID
                $newName = $this->sanitizeFilename($customName) . '_' . time() . '.' . $extension;
            } else {
                // Comportement par défaut (nom d'origine + timestamp pour sécuriser aussi)
                $extension = $file->getExtension() ?: $file->guessExtension();
                $baseName = pathinfo($file->getName(), PATHINFO_FILENAME);
                $newName = $this->sanitizeFilename($baseName) . '_' . time() . '.' . $extension;
            }
            // FIN MODIFICATION --------------------------------

            $pathStr = $subfolder.'/';

            if (!is_dir(FCPATH.'uploads/'.$pathStr)) {
                mkdir(FCPATH.'uploads/'.$pathStr, 0o777, true);
            }

            $file->move(FCPATH.'uploads/'.$pathStr, $newName);
            $fullPath = $pathStr.$newName;

            // 2. Insérer dans la table images
            $db = Database::connect();
            $builder = $db->table('images');

            $existing = $builder->where('path', $fullPath)->get()->getRow();
            if ($existing) {
                return $existing->id;
            }

            $builder->insert([
                'path' => $fullPath,
                'alt' => $customName ?: $file->getClientName(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            return $db->insertID();
        }

        return null;
    }

    /**
     * Charge les données de base pour les vues admin.
     */
    protected function getCommonData(string $title, string $cssPage = '')
    {
        return [
            'root' => $this->root->getRootStyles(),
            'general' => $this->donneesModel->getGeneral(),
            'titrePage' => $title,
            'cssPage' => $cssPage,
            'isLogged' => session()->get('isLoggedIn'),
            'userNom' => session()->get('nom'),
        ];
    }
}
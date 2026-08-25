<?php

declare(strict_types=1);

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Controllers\Root;
use App\Models\Public\Donnees;

class Login extends BaseController
{
    protected $donneesModel;
    protected $root;

    public function __construct()
    {
        $this->donneesModel = new Donnees();
        $this->root = new Root();
    }

    /**
     * Affiche le formulaire de connexion.
     */
    public function index()
    {
        // Si l'admin est déjà connecté, on le redirige directement vers le dashboard
        if (session()->get('isLoggedIn') && 'admin' === session()->get('role')) {
            return redirect()->to(base_url('admin/dashboard'));
        }

        $data = [
            'root' => $this->root->getRootStyles(),
            'titrePage' => 'Connexion administration',
            'cssPage' => 'Public/contact.css',
            'general' => $this->donneesModel->getGeneral(),
        ];

        return view('admin/v_login', $data);
    }

    /**
     * Gère la tentative d'authentification.
     */
    public function authenticate()
    {
        $session = session();

        $username = $this->request->getPost('identifiant');
        $passwordRaw = $this->request->getPost('password');

        // Au lieu de : $envLogin = env('ADMIN_LOGIN');
        // On lit le fichier dédié :
        $clubConfig = parse_ini_file(ROOTPATH.'club.ini');

        $envLogin = $clubConfig['ADMIN_LOGIN'];
        $envPassword = $clubConfig['ADMIN_PASSWORD'];

        // Vérification directe avec les variables d'environnement
        if ($username === $envLogin && $passwordRaw === $envPassword) {
            // SÉCURITÉ : Régénération de l'ID de session (anti-fixation)
            $session->regenerate();

            // Création de la session
            $session->set([
                'nom' => 'Administrateur',
                'username' => $username,
                'role' => 'admin',
                'isLoggedIn' => true,
            ]);

            return redirect()->to(base_url('admin/dashboard'));
        }

        // En cas d'échec
        return redirect()->back()->withInput()->with('error', 'Identifiants invalides.');
    }

    /**
     * Déconnecte l'utilisateur.
     */
    public function logout()
    {
        session()->destroy();

        // Gestion de l'URL de retour
        $returnUrl = $this->request->getGet('return') ?? '/';

        return redirect()->to(base_url($returnUrl))->with('success', 'Vous avez été déconnecté.');
    }
}

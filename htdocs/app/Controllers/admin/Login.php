<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Controllers\Root;
use App\Models\Public\Donnees;
use App\Models\Public\UtilisateurModel;  // Ajout du modèle utilisateur

class Login extends BaseController
{
    protected $donneesModel;
    protected $userModel;
    protected $root;

    public function __construct()
    {
        $this->donneesModel = new Donnees();
        $this->userModel = new UtilisateurModel();  // Instanciation
        $this->root = new Root();
    }

    /**
     * Affiche le formulaire de connexion
     */
    public function index()
    {
        // Si l'admin est déjà connecté, on le redirige directement vers le dashboard
        if (session()->get('isLoggedIn') && session()->get('role') === 'admin') {
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
     * Gère la tentative d'authentification
     */
    public function authenticate()
    {
        $session = session();

        $username = $this->request->getPost('identifiant');
        $passwordRaw = $this->request->getPost('password');
        $passwordEnv = password_hash(env('ADMIN_PASSWORD'), PASSWORD_DEFAULT);

        // 1. Recherche via le Modèle (plus propre)
        $user = $this->userModel->where('username', $username)->first();

        if ($user) {
            // 2. Vérification du mot de passe
            if (password_verify($passwordRaw, $passwordEnv)) {
                // 3. SÉCURITÉ : Vérification du Rôle admin
                if ($user['role'] !== 'admin') {
                    return redirect()->back()->withInput()->with('error', 'Accès refusé : Droits insuffisants.');
                }

                // 4. SÉCURITÉ : Régénération de l'ID de session (anti-fixation)
                $session->regenerate();

                // Création de la session
                $session->set([
                    'user_id' => $user['id'],
                    'nom' => $user['nom'],
                    'username' => $user['username'],
                    'role' => $user['role'],  // Important de stocker le rôle
                    'isLoggedIn' => true,
                ]);

                return redirect()->to(base_url('admin'));  // Ou 'admin/dashboard' selon tes routes
            }
        }

        // En cas d'échec (utilisateur inconnu OU mauvais mot de passe)
        return redirect()->back()->withInput()->with('error', 'Identifiants invalides.');
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function logout()
    {
        session()->destroy();

        // Gestion de l'URL de retour
        $returnUrl = $this->request->getGet('return') ?? '/';

        return redirect()->to(base_url($returnUrl))->with('success', 'Vous avez été déconnecté.');
    }
}

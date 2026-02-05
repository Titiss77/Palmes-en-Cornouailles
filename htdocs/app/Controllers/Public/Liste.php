<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;
use App\Models\Public\Donnees;
use App\Models\Public\UtilisateurModel; // Ajout du modèle utilisateur
use App\Controllers\Root;

class Liste extends BaseController
{
    protected $donneesModel;
    protected $userModel;
    protected $root;

    public function __construct()
    {
        $this->donneesModel = new Donnees();
        $this->userModel    = new UtilisateurModel(); // Instanciation
        $this->root         = new Root();
    }

    /**
     * Affiche le formulaire de connexion
     */
    public function index()
    {
        // Si l'admin est déjà connecté, on le redirige directement vers le dashboard
        if (session()->get('isLoggedIn') && session()->get('role') === 'user') {
            return redirect()->to(base_url('/'));
        }

        $data = [
            'root'      => $this->root->getRootStyles(),
            'titrePage' => 'Connexion Licenciés',
            'cssPage'   => 'Public/contact.css',
            'general'   => $this->donneesModel->getGeneral(),
        ];

        return view('Public/v_listeLogin', $data);
    }

    /**
     * Gère la tentative d'authentification
     */
    public function authenticate()
    {
        $general = $this->donneesModel->getGeneral()['lienDrive'];
        
        $username    = $this->request->getPost('identifiant');
        $passwordRaw = $this->request->getPost('password');

        // 1. Recherche via le Modèle (plus propre)
        $user = $this->userModel->where('username', $username)->first();

        if ($user) {
            // 2. Vérification du mot de passe
            if (password_verify($passwordRaw, $user['password'])) {
                return redirect()->to($general);
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
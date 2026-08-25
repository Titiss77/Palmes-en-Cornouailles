<?php

declare(strict_types=1);

namespace App\Controllers\Public;

use App\Controllers\BaseController;
use App\Controllers\Root;
use App\Models\Public\Donnees;

class Liste extends BaseController
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
        // Si l'adhérent est déjà connecté, on le redirige directement vers l'accueil
        if (session()->get('isLoggedIn') && 'user' === session()->get('role')) {
            return redirect()->to(base_url('/'));
        }

        $data = [
            'root' => $this->root->getRootStyles(),
            'titrePage' => 'Connexion Licenciés',
            'cssPage' => 'Public/contact.css',
            'general' => $this->donneesModel->getGeneral(),
        ];

        return view('Public/v_listeLogin', $data);
    }

    /**
     * Gère la tentative d'authentification.
     */
    public function authenticate()
    {
        $general = $this->donneesModel->getGeneral()['lienDrive'];

        $username = $this->request->getPost('identifiant');
        $passwordRaw = $this->request->getPost('password');

        // Au lieu de : $envLogin = env('USER_LOGIN');
        // On lit le fichier dédié :
        $clubConfig = parse_ini_file(ROOTPATH.'club.ini');

        $envUserLogin = $clubConfig['USER_LOGIN'];
        $envUserPassword = $clubConfig['USER_PASSWORD'];

        // Vérification
        if ($username === $envUserLogin && $passwordRaw === $envUserPassword) {
            // On peut créer une session pour l'adhérent s'il doit rester connecté
            $session = session();
            $session->regenerate();
            $session->set([
                'username' => $username,
                'role' => 'user',
                'isLoggedIn' => true,
            ]);

            return redirect()->to($general);
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

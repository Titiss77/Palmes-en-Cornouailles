<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // On vérifie si l'utilisateur n'est PAS connecté
        if (!session()->get('isLoggedIn')) {
            // On redirige TOUT vers la page de login
            // On peut ajouter .withInput() pour garder l'URL demandée en mémoire si besoin
            return redirect()->to(base_url('login'))->with('error', 'Accès restreint. Veuillez vous connecter.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
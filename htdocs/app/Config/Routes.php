<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// --- ROUTES PUBLIQUES ---
$routes->get('/', 'Public\Home::index');
$routes->get('groupes', 'Public\Home::groupes');
$routes->get('actu/(:segment)', 'Public\Home::actu/$1');
$routes->get('calendriers', 'Public\Home::calendriers');
$routes->get('boutique', 'Public\Home::boutique');
$routes->get('contact', 'Public\Contact::index');
$routes->post('contact/envoyer', 'Public\Contact::envoyer');
$routes->get('contact/confirmer/(:any)', 'Public\Contact::confirmer/$1');
$routes->get('liste', 'Public\Liste::index');
$routes->post('login/auth/liste', 'Public\Liste::authenticate');
$routes->get('logout/liste', 'Public\Liste::logout');

$routes->get('login', 'admin\Login::index');
$routes->post('login/auth', 'admin\Login::authenticate');
$routes->get('logout', 'admin\Login::logout');

$routes->get('mentions-legales', 'Public\Home::mentions_legales');
$routes->get('politique-confidentialite', 'Public\Home::confidentialite');

// --- GROUPE admin SÉCURISÉ ---
$routes->group('admin', ['filter' => 'auth', 'namespace' => 'App\Controllers\admin'], function ($routes) {
    
    // 1. Tableau de bord & Config
    $routes->get('/', 'Dashboard::index');
    $routes->get('contact', 'Dashboard::contact');
    $routes->get('root', 'Dashboard::root');
    $routes->get('general', 'General::index');
    $routes->post('general/update', 'General::update');

    // 2. ACTUALITÉS (Routes spécifiques d'abord)
    $routes->get('actualites/import', 'Actualites::import');
    $routes->post('actualites/processImport', 'Actualites::processImport');
    $routes->get('actualites/(:num)/delete', 'Actualites::delete/$1');
    $routes->get('actualites/(:num)/deleteImage', 'Actualites::deleteImage/$1');
    // On garde 'except' => 'show' pour éviter l'erreur si la méthode show() n'existe pas
    $routes->resource('actualites', ['controller' => 'Actualites', 'except' => 'show']);

    // 3. CALENDRIERS (Gestion PDF + CRUD)
    $routes->get('calendriers/pdf/new', 'Calendriers::formPdf');       // Formulaire PDF
    $routes->post('calendriers/pdf/generate', 'Calendriers::generatePdf'); // Action PDF
    $routes->get('calendriers/(:num)/delete', 'Calendriers::delete/$1');
    $routes->get('calendriers/(:num)/deleteImage', 'Calendriers::deleteImage/$1');
    $routes->resource('calendriers', ['controller' => 'Calendriers', 'except' => 'show']);

    // 4. BOUTIQUES
    $routes->get('boutiques/(:num)/delete', 'Boutiques::delete/$1');
    $routes->resource('boutiques', ['controller' => 'Boutiques', 'except' => 'show']);

    // 5. MEMBRES
    $routes->get('membres/(:num)/delete', 'Membres::delete/$1');
    $routes->get('membres/(:num)/deleteImage', 'Membres::deleteImage/$1');
    $routes->resource('membres', ['controller' => 'Membres']);

    // 6. AUTRES RESSOURCES (Groupes, Piscines, Materiel, etc.)
    $routes->get('groupes/(:num)/delete', 'Groupes::delete/$1');
    $routes->get('groupes/(:num)/deleteImage', 'Groupes::deleteImage/$1');
    $routes->resource('groupes', ['controller' => 'Groupes']);

    $routes->get('piscines/(:num)/delete', 'Piscines::delete/$1');
    $routes->get('piscines/(:num)/deleteImage', 'Piscines::deleteImage/$1');
    $routes->resource('piscines', ['controller' => 'Piscines']);

    $routes->get('materiel/(:num)/delete', 'Materiel::delete/$1');
    $routes->get('materiel/(:num)/deleteImage', 'Materiel::deleteImage/$1');
    $routes->resource('materiel', ['controller' => 'Materiel']);

    $routes->get('disciplines/(:num)/delete', 'Disciplines::delete/$1');
    $routes->get('disciplines/(:num)/deleteImage', 'Disciplines::deleteImage/$1');
    $routes->resource('disciplines', ['controller' => 'Disciplines']);

    $routes->get('partenaires/(:num)/delete', 'Partenaires::delete/$1');
    $routes->get('partenaires/(:num)/deleteImage', 'Partenaires::deleteImage/$1');
    $routes->resource('partenaires', ['controller' => 'Partenaires']);

    $routes->get('utilisateurs/(:num)/delete', 'Utilisateurs::delete/$1');
    $routes->get('utilisateurs/(:num)/deleteImage', 'Utilisateurs::deleteImage/$1');
    $routes->resource('utilisateurs', ['controller' => 'Utilisateurs']);
});
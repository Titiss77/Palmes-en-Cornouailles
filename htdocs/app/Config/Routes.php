<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// --- ROUTES PUBLIQUES ---
$routes->get('/', 'Public\Home::index');
$routes->get('groupes', 'Public\Home::groupes');
$routes->get('palmares', 'Public\Home::palmares');
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

// app/Config/Routes.php

$routes->get('mentions-legales', 'Public\Home::mentions_legales');
$routes->get('politique-confidentialite', 'Public\Home::confidentialite');

// --- GROUPE admin SÉCURISÉ ---
$routes->group('admin', ['filter' => 'auth', 'namespace' => 'App\Controllers\admin'], function ($routes) {
    // 1. Tableau de bord
    $routes->get('/', 'Dashboard::index');

    $routes->get('contact', 'Dashboard::contact');
    $routes->get('root', 'Dashboard::root');

    // 2. Configuration Générale (Page unique)
    $routes->get('general', 'General::index');
    $routes->post('general/update', 'General::update');

    $routes->get('actualites/(:num)/delete', 'Actualites::delete/$1');
    $routes->get('actualites/(:num)/deleteImage', 'Actualites::deleteImage/$1');

    $routes->get('boutiques/(:num)/delete', 'Boutiques::delete/$1');
    $routes->resource('boutiques', ['controller' => 'Boutiques', 'except' => 'show']);

    $routes->get('membres/(:num)/delete', 'Membres::delete/$1');
    $routes->get('membres/(:num)/deleteImage', 'Membres::deleteImage/$1');

    $routes->get('groupes/(:num)/delete', 'Groupes::delete/$1');
    $routes->get('groupes/(:num)/deleteImage', 'Groupes::deleteImage/$1');

    $routes->get('calendriers/(:num)/delete', 'Calendriers::delete/$1');
    $routes->get('calendriers/(:num)/deleteImage', 'Calendriers::deleteImage/$1');

    $routes->get('piscines/(:num)/delete', 'Piscines::delete/$1');
    $routes->get('piscines/(:num)/deleteImage', 'Piscines::deleteImage/$1');

    $routes->get('materiel/(:num)/delete', 'Materiel::delete/$1');
    $routes->get('materiel/(:num)/deleteImage', 'Materiel::deleteImage/$1');

    $routes->get('disciplines/(:num)/delete', 'Disciplines::delete/$1');
    $routes->get('disciplines/(:num)/deleteImage', 'Disciplines::deleteImage/$1');

    $routes->get('partenaires/(:num)/delete', 'Partenaires::delete/$1');
    $routes->get('partenaires/(:num)/deleteImage', 'Partenaires::deleteImage/$1');

    $routes->get('utilisateurs/(:num)/delete', 'Utilisateurs::delete/$1');
    $routes->get('utilisateurs/(:num)/deleteImage', 'Utilisateurs::deleteImage/$1');

    $routes->get('actualites/import', 'Actualites::import');
    $routes->post('actualites/processImport', 'Actualites::processImport');
    $routes->get('actualites/(:num)/delete', 'Actualites::delete/$1');
    $routes->get('actualites/(:num)/deleteImage', 'Actualites::deleteImage/$1');

    $routes->get('palmares/(:num)/delete', 'Palmares::delete/$1');
    $routes->get('palmares/(:num)/deleteImage', 'Palmares::deleteImage/$1');
    $routes->resource('palmares', ['controller' => 'Palmares']);

    $routes->resource('actualites', ['controller' => 'Actualites']);
    $routes->resource('boutiques', ['controller' => 'Boutiques']);
    $routes->resource('membres', ['controller' => 'Membres']);
    $routes->resource('groupes', ['controller' => 'Groupes']);
    $routes->resource('calendriers', ['controller' => 'Calendriers']);
    $routes->resource('piscines', ['controller' => 'Piscines']);
    $routes->resource('materiel', ['controller' => 'Materiel']);
    $routes->resource('partenaires', ['controller' => 'Partenaires']);

    $routes->resource('disciplines', ['controller' => 'Disciplines']);
    $routes->resource('utilisateurs', ['controller' => 'Utilisateurs']);
});
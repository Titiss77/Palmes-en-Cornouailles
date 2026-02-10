<?php

namespace App\Controllers\admin;

use App\Models\admin\ActualiteModel;
use CodeIgniter\Controller;

class Actualites extends BaseAdminController
{
    protected $actuModel;

    public function __construct()
    {
        $this->actuModel = new ActualiteModel();
    }

    // -------------------------------------------------------------------------
    //  MÉTHODES UTILITAIRES (NETTOYAGE & SLUG)
    // -------------------------------------------------------------------------

    /**
     * Nettoie une chaîne pour en faire un slug (URL) propre
     */
    private function nettoyer_chaine($chaine)
    {
        // 1. On s'assure d'avoir de l'UTF-8 propre (normalisation)
        if (!mb_check_encoding($chaine, 'UTF-8')) {
            $chaine = mb_convert_encoding($chaine, 'UTF-8', 'Windows-1252');
        }

        // 2. Translitérer : convertit les accents (é -> e, à -> a)
        // setlocale aide iconv à comprendre les caractères régionaux
        setlocale(LC_ALL, 'en_US.utf8');
        $chaine = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $chaine);

        // 3. Supprimer tout ce qui n'est pas alphanumérique ou tiret
        $chaine = preg_replace('/[^a-zA-Z0-9 -]/', '', $chaine);

        // 4. Minuscules et tirets
        $chaine = strtolower(trim($chaine));
        $chaine = str_replace(' ', '-', $chaine);
        $chaine = preg_replace('/-+/', '-', $chaine);  // Évite les tirets multiples

        return $chaine;
    }

    /**
     * Génère un slug unique (ajoute -1, -2 si nécessaire)
     */
    private function genererSlugUnique($slugBase)
    {
        $slug = $slugBase;
        $compteur = 1;

        // Tant que le slug existe dans la base, on incrémente
        while ($this->actuModel->where('slug', $slug)->countAllResults() > 0) {
            $slug = $slugBase . '-' . $compteur;
            $compteur++;
        }

        return $slug;
    }

    // -------------------------------------------------------------------------
    //  CRUD STANDARD
    // -------------------------------------------------------------------------

    public function index()
    {
        $data = $this->getCommonData('Gestion Actualités', 'admin/page.css');
        $data['actualites'] = $this->actuModel->getActualitesWithRelations();
        return view('admin/actualites/index', $data);
    }

    public function new()
    {
        $data = $this->getCommonData('Nouvelle Actualité', 'admin/page.css');
        return view('admin/actualites/create', $data);
    }

    public function create()
    {
        if (!$this->validate(['titre' => 'required|min_length[3]|max_length[150]', 'description' => 'required'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $titre = $this->request->getPost('titre');
        $slug = $this->genererSlugUnique($this->nettoyer_chaine($titre));

        $data = [
            'titre' => $titre,
            'slug' => $slug,
            'description' => $this->request->getPost('description'),
            'date_evenement' => $this->request->getPost('date_evenement') ?: null,
            'statut' => $this->request->getPost('statut'),
            'type' => 'actualite',
            'id_auteur' => session()->get('user_id') ?? 1,
            'image_id' => $this->handleImageUpload('image', 'actualites')
        ];

        $this->actuModel->insert($data);
        return redirect()->to('/admin/actualites')->with('success', 'Actualité créée avec succès.');
    }

    public function edit($id = null)
    {
        $data = $this->getCommonData('Modifier Actualité', 'admin/page.css');
        $item = $this->actuModel->getActualitesWithRelations($id);

        if (!$item)
            return redirect()->to('/admin/actualites')->with('error', 'Article introuvable.');

        $data['item'] = $item;
        return view('admin/actualites/edit', $data);
    }

    public function update($id = null)
    {
        if (!$this->validate(['titre' => 'required|min_length[3]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $titre = $this->request->getPost('titre');

        // Note: On ne met généralement pas à jour le slug pour ne pas casser les liens SEO,
        // mais si vous le souhaitez, vous pouvez décommenter :
        // $slug = $this->genererSlugUnique($this->nettoyer_chaine($titre));

        $data = [
            'titre' => $titre,
            // 'slug'        => $slug,
            'slug' => url_title($titre, '-', true),  // Version simple si update
            'description' => $this->request->getPost('description'),
            'date_evenement' => $this->request->getPost('date_evenement') ?: null,
            'statut' => $this->request->getPost('statut'),
        ];

        $imageId = $this->handleImageUpload('image', 'actualites', $titre);
        if ($imageId) {
            $data['image_id'] = $imageId;
        }

        $this->actuModel->update($id, $data);
        return redirect()->to('/admin/actualites')->with('success', 'Actualité mise à jour.');
    }

    public function delete($id = null)
    {
        $actualite = $this->actuModel->getActualitesWithRelations($id);
        if ($actualite) {
            if (!empty($actualite['image_path'])) {
                $path = FCPATH . 'uploads/' . $actualite['image_path'];
                if (file_exists($path))
                    unlink($path);

                if (!empty($actualite['image_id'])) {
                    $db = \Config\Database::connect();
                    $db->table('images')->where('id', $actualite['image_id'])->delete();
                }
            }
            $this->actuModel->delete($id);
            return redirect()->to('/admin/actualites')->with('success', 'Suppression réussie.');
        }
        return redirect()->to('/admin/actualites')->with('error', 'Introuvable.');
    }

    public function deleteImage($id = null)
    {
        $article = $this->actuModel->getActualitesWithRelations($id);
        if (!$article || empty($article['image_id']))
            return redirect()->back()->with('error', 'Aucune image.');

        $this->actuModel->update($id, ['image_id' => null]);

        $db = \Config\Database::connect();
        $db->table('images')->where('id', $article['image_id'])->delete();

        if (file_exists(FCPATH . 'uploads/' . $article['image_path'])) {
            unlink(FCPATH . 'uploads/' . $article['image_path']);
        }

        return redirect()->back()->with('success', 'Image supprimée.');
    }

    // -------------------------------------------------------------------------
    //  IMPORT CSV (CORRIGÉ ET ROBUSTE)
    // -------------------------------------------------------------------------

    public function import()
    {
        $data = $this->getCommonData('Importer des Actualités', 'admin/import.css');
        return view('admin/actualites/import', $data);
    }

    public function processImport()
    {
        // 1. Validation
        if (!$this->validate([
            'fichier_csv' => 'uploaded[fichier_csv]|ext_in[fichier_csv,csv,txt]|max_size[fichier_csv,2048]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('fichier_csv');

        if ($file->isValid() && !$file->hasMoved()) {
            // 2. Lecture brute et conversion UTF-8
            // C'est ici que la magie opère pour corriger les accents
            $filepath = $file->getTempName();
            $content = file_get_contents($filepath);

            // Détection de l'encodage (Windows-1252 est le défaut d'Excel)
            $encoding = mb_detect_encoding($content, ['UTF-8', 'Windows-1252', 'ISO-8859-1'], true);

            if (!$encoding || $encoding !== 'UTF-8') {
                // On convertit tout le contenu en UTF-8 proprement
                $content = mb_convert_encoding($content, 'UTF-8', $encoding ?: 'Windows-1252');
            }

            // 3. Traitement via un flux mémoire (plus besoin du fichier temporaire)
            $handle = fopen('php://memory', 'r+');
            fwrite($handle, $content);
            rewind($handle);  // Retour au début du flux

            $count = 0;
            $rowIdx = 0;

            while (($data = fgetcsv($handle, 0, ';')) !== FALSE) {
                $rowIdx++;

                // Ignorer les lignes vides ou entêtes
                if (count($data) < 2)
                    continue;
                if ($rowIdx === 1 && strtolower(trim($data[0])) === 'titre')
                    continue;

                $titre = $data[0] ?? 'Sans titre';
                $description = $data[1] ?? '';
                $rawDate = $data[2] ?? null;

                $description = stripslashes($description);
                $titre = stripslashes($titre);

                $dateEvenement = date('Y-m-d');  // Par défaut : aujourd'hui

                if (!empty($rawDate)) {
                    // CAS 1 : Format numérique Excel (ex: 46047)
                    if (is_numeric($rawDate)) {
                        $unixDate = ($rawDate - 25569) * 86400;
                        $dateEvenement = date('Y-m-d', $unixDate);
                    }
                    // CAS 2 : Format Français avec slash (ex: 07/02/2026)
                    elseif (strpos($rawDate, '/') !== false) {
                        // On essaie d'abord le format complet JJ/MM/AAAA
                        $dt = \DateTime::createFromFormat('d/m/Y', $rawDate);

                        // Si ça échoue, on essaie JJ/MM/AA (année courte)
                        if (!$dt) {
                            $dt = \DateTime::createFromFormat('d/m/y', $rawDate);
                        }

                        if ($dt) {
                            $dateEvenement = $dt->format('Y-m-d');
                        }
                    }
                    // CAS 3 : Format Standard ISO (ex: 2026-02-07)
                    else {
                        try {
                            $dt = new \DateTime($rawDate);
                            $dateEvenement = $dt->format('Y-m-d');
                        } catch (\Exception $e) {
                            // En cas d'erreur, on garde la date du jour
                        }
                    }
                }

                // Génération du SLUG UNIQUE
                $slugBase = $this->nettoyer_chaine($titre);
                $slugFinal = $this->genererSlugUnique($slugBase);

                // Insertion
                $this->actuModel->insert([
                    'titre' => $titre,
                    'slug' => $slugFinal,
                    'description' => $description,
                    'date_evenement' => $dateEvenement,
                    'statut' => 'publie',
                    'type' => 'actualite',
                    'id_auteur' => session()->get('user_id') ?? 1
                ]);

                $count++;
            }

            fclose($handle);
            return redirect()->to('/admin/actualites')->with('success', "$count actualités importées avec succès.");
        }

        return redirect()->back()->with('error', "Erreur lors de l'upload.");
    }
}
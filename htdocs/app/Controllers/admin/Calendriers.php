<?php

namespace App\Controllers\admin;

use App\Models\admin\CalendriersModel;

use Dompdf\Dompdf;
use Dompdf\Options;

class Calendriers extends BaseAdminController
{
    protected $calModel;

    public function __construct()
    {
        $this->calModel = new CalendriersModel();
    }

    // 1. LISTE
    public function index()
    {
        $data = $this->getCommonData('Gestion des Calendriers', 'admin/page.css');
        $data['calendriers'] = $this->calModel->getCalendriersWithRelations();

        return view('admin/calendriers/index', $data);
    }

    // 2. FORMULAIRE DE CRÉATION
    public function new()
    {
        $data = $this->getCommonData('Nouveau Document', 'admin/page.css');
        return view('admin/calendriers/create', $data);
    }

    // 3. TRAITEMENT DE CRÉATION
    public function create()
    {
        if (!$this->validate([
            'categorie' => 'required',
            'date' => 'required|max_length[100]',  // Sert de titre/saison
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload (Image ou PDF) dans le dossier 'calendriers'
        // BaseadminController gère l'insertion en BDD "images"
        $imageId = $this->handleImageUpload('image', 'calendriers');

        $data = [
            'categorie' => $this->request->getPost('categorie'),
            'date' => $this->request->getPost('date'),
            'image_id' => $imageId
        ];

        $this->calModel->insert($data);

        return redirect()->to('/admin/calendriers')->with('success', 'Document ajouté avec succès.');
    }

    // 4. FORMULAIRE D'ÉDITION
    public function edit($id = null)
    {
        $data = $this->getCommonData('Modifier Document', 'admin/page.css');
        $item = $this->calModel->getCalendriersWithRelations($id);

        if (!$item) {
            return redirect()->to('/admin/calendriers')->with('error', 'Document introuvable.');
        }

        $data['item'] = $item;
        return view('admin/calendriers/edit', $data);
    }

    // 5. TRAITEMENT DE MISE À JOUR
    public function update($id = null)
    {
        if (!$this->validate([
            'categorie' => 'required',
            'date' => 'required|max_length[100]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageId = $this->handleImageUpload('image', 'calendriers');

        $data = [
            'categorie' => $this->request->getPost('categorie'),
            'date' => $this->request->getPost('date'),
        ];

        if ($imageId) {
            $data['image_id'] = $imageId;
        }

        $this->calModel->update($id, $data);

        return redirect()->to('/admin/calendriers')->with('success', 'Document mis à jour.');
    }

    // 6. SUPPRESSION
    public function delete($id = null)
    {
        $item = $this->calModel->getCalendriersWithRelations($id);

        if ($item) {
            // Nettoyage fichier et entrée BDD Image
            if (!empty($item['image_path'])) {
                $cheminFichier = FCPATH . 'uploads/' . $item['image_path'];
                if (file_exists($cheminFichier)) {
                    unlink($cheminFichier);
                }
                if (!empty($item['image_id'])) {
                    $db = \Config\Database::connect();
                    $db->table('images')->where('id', $item['image_id'])->delete();
                }
            }

            $this->calModel->delete($id);
            return redirect()->to('/admin/calendriers')->with('success', 'Document supprimé.');
        }

        return redirect()->to('/admin/calendriers')->with('error', 'Introuvable.');
    }

    // 7. SUPPRESSION FICHIER SEUL
    public function deleteImage($id = null)
    {
        $item = $this->calModel->getCalendriersWithRelations($id);

        if (!$item || empty($item['image_id'])) {
            return redirect()->back();
        }

        $imageId = $item['image_id'];
        $imagePath = $item['image_path'];

        $this->calModel->update($id, ['image_id' => null]);

        $db = \Config\Database::connect();
        $db->table('images')->where('id', $imageId)->delete();

        if (!empty($imagePath)) {
            $fullPath = FCPATH . 'uploads/' . $imagePath;
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        return redirect()->back()->with('success', 'Fichier supprimé.');
    }

    public function formPdf()
    {
        $data = $this->getCommonData('Générer PDF', 'admin/page.css');
        return view('admin/calendriers/form_pdf', $data);
    }

    // 2. TRAITER L'UPLOAD ET GÉNÉRER LE PDF
    public function generatePdf()
    {
        // Validation basique
        if (!$this->validate([
            'csv_file' => 'uploaded[csv_file]|ext_in[csv_file,csv,txt]|max_size[csv_file,2048]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Récupération du fichier uploadé
        $file = $this->request->getFile('csv_file');

        if ($file->isValid() && !$file->hasMoved()) {
            // C'EST ICI LA CORRECTION :
            // On utilise le chemin temporaire du fichier uploadé
            $filepath = $file->getTempName();

            // Lecture des données
            $events = $this->getEventsFromCsv($filepath);

            // Si le CSV est vide ou illisible
            if (empty($events)) {
                return redirect()->back()->with('error', 'Impossible de lire les événements du CSV.');
            }

            // Grouper par MOIS
            $eventsByMonth = [];
            foreach ($events as $event) {
                // Gestion de la date (Format attendu CSV: JJ/MM/AAAA ou AAAA-MM-JJ)
                $rawDate = $event['date'];
                $timestamp = false;

                if (strpos($rawDate, '/') !== false) {
                    $dt = \DateTime::createFromFormat('d/m/Y', $rawDate);
                    if ($dt)
                        $timestamp = $dt->getTimestamp();
                } else {
                    $timestamp = strtotime($rawDate);
                }

                if ($timestamp) {
                    $moisAnnee = $this->nomMoisFr(date('n', $timestamp)) . ' ' . date('Y', $timestamp);
                    $eventsByMonth[$moisAnnee][] = $event;
                }
            }

            // Configuration DomPDF
            $options = new Options();
            $options->set('defaultFont', 'Helvetica');
            $options->set('isRemoteEnabled', true);
            $dompdf = new Dompdf($options);

            // Génération HTML
            $html = view('admin/calendriers/pdf_template', [
                'eventsByMonth' => $eventsByMonth,
                'title' => 'Calendrier des Compétitions'
            ]);

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            ob_end_clean();

            // Téléchargement direct
            return $dompdf->stream('Calendrier_Competitions.pdf', ['Attachment' => true]);
        }

        return redirect()->back()->with('error', "Erreur lors de l'upload du fichier.");
    }

    // Fonction utilitaire de lecture (inchangée, mais appelée avec le bon chemin maintenant)
    private function getEventsFromCsv($filepath)
    {
        $data = [];
        // On vérifie que le fichier existe bien à l'emplacement temporaire
        if (file_exists($filepath) && ($handle = fopen($filepath, 'r')) !== FALSE) {
            // Détection du séparateur (Point-virgule souvent pour Excel FR)
            $separator = ';';

            // On passe la première ligne (entêtes)
            fgetcsv($handle, 0, $separator);

            while (($row = fgetcsv($handle, 0, $separator)) !== FALSE) {
                // On saute les lignes vides
                if (count($row) < 2)
                    continue;

                // Mapping manuel selon votre CSV "Calendrier.csv"
                // Ordre supposé : Date ; Lieu ; Bassin ; Niveau ; Nom
                $data[] = [
                    'date' => $row[0] ?? '',
                    'lieu' => $row[1] ?? '',
                    'bassin' => $row[2] ?? '',
                    'niveau' => $row[3] ?? '',
                    'nom' => $row[4] ?? '',
                ];
            }
            fclose($handle);
        }
        return $data;
    }

    private function nomMoisFr($numMois)
    {
        $mois = [1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'];
        return $mois[(int) $numMois];
    }
}
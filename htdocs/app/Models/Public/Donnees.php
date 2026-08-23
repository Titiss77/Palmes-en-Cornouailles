<?php

namespace App\Models\Public;

use CodeIgniter\Model;

class Donnees extends Model
{
    public function getGeneral()
    {
        $result = $this
            ->db
            ->table('general g')
            ->join('images i', 'g.image_id = i.id', 'left')
            ->join('images ig', 'g.image_groupe_id = ig.id', 'left')
            ->join('images il', 'g.logoffessm_id = il.id', 'left')
            ->select('i.path as image, ig.path as image_groupe, il.path as logoffessm')
            ->select('g.nomClub, g.mailClub, g.adresse, g.description, g.philosophie, g.nombreNageurs, g.projetSportif, g.lienFacebook, g.lienInstagram, g.lienffessm, g.lienDrive')
            ->select('ROUND(g.nombreHommes / g.nombreNageurs * 100, 1) as pourcentH')
            ->select('ROUND((g.nombreNageurs - g.nombreHommes) / g.nombreNageurs * 100, 1) as pourcentF')
            ->get()
            ->getRowArray();

        // Si la table est vide, on renvoie des fausses données
        if (empty($result)) {
            return [
                'image' => 'default_general.jpg',
                'image_groupe' => 'default_group.jpg',
                'logoffessm' => 'default_logo.jpg',
                'nomClub' => 'Nom du Club',
                'description' => 'Ceci est une description par défaut car la base de données est vide.',
                'philosophie' => 'Philosophie par défaut.',
                'nombreNageurs' => 0,
                'projetSportif' => 'Projet sportif par défaut',
                'lienFacebook' => '#',
                'lienInstagram' => '#',
                'lienffessm' => '#',
                'lienDrive' => '#',
                'pourcentH' => 50,
                'pourcentF' => 50
            ];
        }

        return $result;
    }

    private function getMembresParFonction(string $titreFonction)
    {
        $result = $this
            ->db
            ->table('membres m')
            ->join('images i', 'm.image_id = i.id', 'left')
            ->select('m.nom, i.path as photo')
            ->join('membre_fonction mf', 'm.id = mf.membre_id')
            ->join('fonctions f', 'mf.fonction_id = f.id')
            ->where('f.titre', $titreFonction)
            ->get()
            ->getResultArray();

        return $result;
    }

    public function getPresident()
    {
        $result = $this
            ->db
            ->table('membres m')
            ->join('images i', 'm.image_id = i.id', 'left')
            ->select('m.nom, i.path as photo')
            ->join('membre_fonction mf', 'm.id = mf.membre_id')
            ->join('fonctions f', 'mf.fonction_id = f.id', 'left')
            ->where('f.titre', 'Président')
            ->get()
            ->getRowArray();

        // Si aucun président trouvé, on renvoie une fausse donnée
        if (empty($result)) {
            return [
                'nom' => 'Personne',
                'photo' => 'default_president.jpg'
            ];
        }

        return $result;
    }

    public function getCoachs()
    {
        return $this->getMembresParFonction('Coach');
    }

    public function getCoachsFormation()
    {
        return $this->getMembresParFonction('Coach en formation');
    }

    public function getDisciplines()
    {
        $result = $this
            ->db
            ->table('disciplines d')
            ->join('images i', 'd.image_id = i.id', 'left')
            ->select('d.nom, d.description, i.path as image')
            ->get()
            ->getResultArray();

        return $result;
    }

    public function getPiscines()
    {
        $result = $this
            ->db
            ->table('piscines p')
            ->join('images i', 'p.image_id = i.id', 'left')
            ->select('p.nom, p.adresse, p.type_bassin, i.path as photo')
            ->get()
            ->getResultArray();

        return $result;
    }

    public function getCalendriers()
    {
        $result = $this
            ->db
            ->table('calendriers c')
            ->join('images i', 'c.image_id = i.id', 'left')
            ->select('c.categorie, c.date, i.path as image')
            ->where('c.categorie !=', 'competitions')
            ->orderBy('c.categorie', 'ASC')
            ->get()
            ->getResultArray();

        return $result;
    }

    public function getCalendrier()
    {
        $result = $this
            ->db
            ->table('calendriers c')
            ->join('images i', 'c.image_id = i.id', 'left')
            ->select('c.categorie, c.date, i.path as image')
            ->where('c.categorie', 'competitions')
            ->get()
            ->getResultArray();

        return $result;
    }

    public function getBureau()
    {
        $result = $this
            ->db
            ->table('membres m')
            ->join('images i', 'm.image_id = i.id', 'left')
            ->select('m.*, i.path as photo, GROUP_CONCAT(f.titre SEPARATOR ", ") AS fonctions')
            ->join('membre_fonction mf', 'mf.membre_id = m.id')
            ->join('fonctions f', 'f.id = mf.fonction_id')
            ->where('f.titre !=', 'Coach')
            ->where('f.titre !=', 'Coach en formation')
            ->groupBy('m.id')
            ->get()
            ->getResultArray();

        return $result;
    }

    public function getBoutique()
    {
        $result = $this->db->table('boutique')->select('nom, url, description, tranchePrix')->get()->getResultArray();

        return $result;
    }

    public function getLiensAutres()
    {
        $result = $this->db->table('general')->select('lienDecatPro')->get()->getRowArray();

        if (empty($result)) {
            return ['lienDecatPro' => '#'];
        }

        return $result;
    }

    public function getActualites()
    {
        $actus = $this
            ->db
            ->table('actualites a')
            ->join('images i', 'a.image_id = i.id', 'left')
            ->join('membres m', 'a.id_auteur = m.id')
            ->select('a.id, a.titre, a.slug, a.type, a.description, i.path as image, i.alt, a.date_evenement, a.created_at, m.nom as auteur')
            ->where(['a.statut' => 'publie', 'a.type' => 'actualite'])
            ->orderBy('a.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $today = date('Y-m-d');
        $actusFiltres = [];

        foreach ($actus as $actu) {
            if (!empty($actu['date_evenement']) && $actu['date_evenement'] < $today) {
                // On met à jour l'archivage uniquement si c'est une vraie donnée (id > 0)
                if (isset($actu['id']) && $actu['id'] > 0) {
                    $this
                        ->db
                        ->table('actualites')
                        ->where('id', $actu['id'])
                        ->update(['statut' => 'archive']);
                }
                continue;
            }
            $actusFiltres[] = $actu;
        }

        // Si après filtrage il ne reste rien, on peut aussi renvoyer du faux contenu si désiré,
        // ou laisser le tableau vide. Ici, je laisse le tableau filtré.
        return $actusFiltres;
    }

    public function getUneActualites($slug)
    {
        $result = $this
            ->db
            ->table('actualites a')
            ->join('images i', 'a.image_id = i.id', 'left')
            ->select('a.titre, a.slug, a.type, a.description, i.path as image, i.alt, a.date_evenement, a.created_at, m.nom as auteur')
            ->join('membres m', 'a.id_auteur = m.id')
            ->where(['a.statut' => 'publie', 'a.slug' => $slug])
            ->get()
            ->getResultArray();

        return $result;
    }

    public function getPalmares($id = null)
    {
        $result = $this
            ->db
            ->table('palmares p')
            ->select('p.*, images.path as image_path, images.alt as image_alt')
            ->join('images', 'images.id = p.image_id', 'left')
            ->orderBy('date_epreuve', 'DESC')
            ->orderBy('classement', 'ASC')
            ->get()
            ->getResultArray();

        $palmaresFiltres = [];
        $dateLimite = date('Y-m-d', strtotime('-3 months'));

        foreach ($result as $item) {
            $dateEpreuve = $item['date_epreuve'];
            if (!empty($dateEpreuve) && $dateEpreuve < $dateLimite) {
                if (isset($item['id']) && $item['id'] > 0) {
                    if (isset($item['statut']) && $item['statut'] !== 'archive') {
                        $this
                            ->db
                            ->table('palmares')
                            ->where('id', $item['id'])
                            ->update(['statut' => 'archive']);
                    }
                }
                continue;
            }
            $palmaresFiltres[] = $item;
        }

        return $palmaresFiltres;
    }
}
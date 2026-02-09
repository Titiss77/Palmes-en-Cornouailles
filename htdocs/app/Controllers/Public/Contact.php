<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;
use App\Controllers\Root;
use App\Models\Public\Donnees;
use App\Models\Public\GroupeModel;
use App\Models\Public\InscriptionModel;

class Contact extends BaseController
{
    protected $donneesModel;
    protected $inscrModel;
    protected $groupeModel;
    protected $root;

    public function __construct()
    {
        $this->donneesModel = new Donnees();
        $this->inscrModel = new InscriptionModel();
        $this->groupeModel = new GroupeModel();
        $this->root = new Root();
    }

    /**
     * Helper to render views with global data
     */
    private function _render(string $view, array $pageData = [])
    {
        $globalData = [
            'root' => $this->root->getRootStyles(),
            'general' => $this->donneesModel->getGeneral(),
        ];
        return view($view, array_merge($globalData, $pageData));
    }

    public function index()
    {
        $data = [
            'titrePage' => 'Inscriptions & Contact',
            'cssPage' => 'Public/contact.css',
            'materiel' => $this->inscrModel->getMateriel(),
            'membres' => $this->donneesModel->getBureau(),
            'groupes' => $this->groupeModel->getGroupes(),
        ];

        return $this->_render('Public/v_contact', $data);
    }

    public function envoyer()
    {
        // 1. Limiteur de débit (Rate Limiting) par IP
        $throttler = \Config\Services::throttler();
        // Autorise 2 messages toutes les 3600 secondes (1 heure) par IP
        if ($throttler->check(md5($this->request->getIPAddress()), 2, 3600) === false) {
            return redirect()->back()->with('error', "Trop de tentatives. Veuillez réessayer dans une heure.");
        }

        // 2. Honeypot (Anti-spam robot simple)
        if (!empty($this->request->getPost('honeypot'))) {
            return redirect()->back()->with('error', 'Spam détecté.');
        }

        // 3. Validation des champs
        if (!$this->validate([
            'email' => 'required|valid_email',
            'message' => 'required|min_length[10]',
            'destinataire' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Veuillez vérifier vos informations.');
        }

        // 4. Récupération des données
        $emailUser = esc($this->request->getPost('email'));
        $roleDestinataire = $this->request->getPost('destinataire');
        $messageBrut = $this->request->getPost('message');

        // Récupération de l'email réel du club via le modèle
        $destEmail = $this->inscrModel->getMail($roleDestinataire);

        // 5. Préparation des données pour la vue de l'email
        $emailData = [
            'email_user' => $emailUser,
            'destinataireNom' => ucfirst($roleDestinataire),
            'messageContenu' => nl2br(esc($messageBrut)),
            'dateEnvoi' => date('d/m/Y à H:i')
        ];

        // 6. Envoi DIRECT au club (on utilise la vue receive_contact)
        $sujet = 'Contact Site : ' . $emailUser;
        $corpsEmail = view('emails/receive_contact', $emailData);

        if ($this->_sendEmail($destEmail, $sujet, $corpsEmail, $emailUser)) {
            return redirect()->back()->with('success', 'Votre message a bien été transmis au club !');
        } else {
            return redirect()->back()->with('error', "Le service d'envoi est temporairement indisponible.");
        }
    }

    // Supprimer ou ignorer la fonction confirmer() car elle n'est plus utile
    
    private function _sendEmail($to, $subject, $message, $replyTo = null)
    {
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message);

        if ($replyTo) {
            $email->setReplyTo($replyTo);
        }

        if ($email->send()) {
            return true;
        } else {
            log_message('error', $email->printDebugger(['headers']));
            return false;
        }
    }
}
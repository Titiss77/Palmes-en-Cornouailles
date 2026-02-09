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
        // 1. Limitation par IP (Rate Limiting)
        $throttler = \Config\Services::throttler();
        // Clé basée sur l'IP (hachée pour le RGPD)
        $key = md5($this->request->getIPAddress());
        
        // Autorise 2 envois toutes les 3600 secondes (1 heure)
        if ($throttler->check($key, 3, 3600) === false) {
            return redirect()->back()->with('error', "Trop de messages envoyés. Veuillez réessayer dans une heure.");
        }

        // 2. Anti-spam Honeypot
        if (!empty($this->request->getPost('honeypot'))) {
            return redirect()->back()->with('error', 'Spam détecté.');
        }

        // 3. Validation
        if (!$this->validate([
            'email' => 'required|valid_email',
            'message' => 'required|min_length[10]',
            'destinataire' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Veuillez vérifier vos informations.');
        }

        // 4. Préparation de l'envoi direct
        $emailUser = esc($this->request->getPost('email'));
        $roleDest = $this->request->getPost('destinataire');
        
        // Récupération de l'email du club correspondant au rôle choisi
        $destEmail = $this->inscrModel->getMail($roleDest);

        $emailData = [
            'email_user'     => $emailUser,
            'destinataireNom'=> ucfirst($roleDest),
            'messageContenu' => nl2br(esc($this->request->getPost('message'))),
            'dateEnvoi'      => date('d/m/Y à H:i')
        ];

        // 5. Envoi immédiat au club
        $sujet = 'Nouveau message de contact : ' . $emailUser;
        $messageHtml = view('emails/receive_contact', $emailData);

        if ($this->_sendEmail($destEmail, $sujet, $messageHtml, $emailUser)) {
            return redirect()->back()->with('success', 'Votre message a bien été transmis au club !');
        } else {
            return redirect()->back()->with('error', "Le service d'envoi est temporairement indisponible.");
        }
    }

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

    private function _render(string $view, array $pageData = [])
    {
        $globalData = [
            'root' => $this->root->getRootStyles(),
            'general' => $this->donneesModel->getGeneral(),
        ];
        return view($view, array_merge($globalData, $pageData));
    }
}
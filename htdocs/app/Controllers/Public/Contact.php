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
        // 1. Validation
        if (!empty($this->request->getPost('honeypot'))) {
            return redirect()->back()->with('error', 'Spam détecté.');
        }

        if (!$this->validate([
            'email' => 'required|valid_email',
            'message' => 'required|min_length[10]',
            'destinataire' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Veuillez vérifier vos informations.');
        }

        // 2. Preparation
        $emailUser = esc($this->request->getPost('email'));
        $token = bin2hex(random_bytes(32));

        // Insert into DB
        $db = \Config\Database::connect();
        $db->table('pending_contacts')->insert([
            'email_user' => $emailUser,
            'destinataire' => $this->request->getPost('destinataire'),
            'message' => $this->request->getPost('message'),
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // 3. Prepare Email Data
        $infosGeneral = $this->donneesModel->getGeneral();

        $emailData = [
            'nomClub' => $infosGeneral['nomClub'] ?? 'Palmes en Cornouailles',
            'lien' => base_url("contact/confirmer/$token"),
            'urlAccueil' => base_url(),
            'domainName' => parse_url(base_url(), PHP_URL_HOST)
        ];

        // 4. Send Email
        // Note: Using the 'emails/confirm_contact' view (Code provided below)
        if ($this->_sendEmail($emailUser, 'Confirmation de votre message - PEC', view('emails/confirm_contact', $emailData))) {
            return redirect()->back()->with('success', 'Mail de confirmation envoyé ! Vérifiez vos spams.');
        } else {
            return redirect()->back()->with('error', "Le service d'envoi est temporairement indisponible.");
        }
    }

    public function confirmer($token)
    {
        $db = \Config\Database::connect();

        $pending = $db->table('pending_contacts')->where('token', $token)->get()->getRowArray();

        if (!$pending) {
            return redirect()->to('/contact')->with('error', 'Lien expiré ou invalide.');
        }

        // Get actual destination email from Database based on the role (e.g., 'president')
        $destEmail = $this->inscrModel->getMail($pending['destinataire']);

        // Prepare Data for the Club Admin
        $emailData = [
            'email_user' => $pending['email_user'],
            'destinataireNom' => ucfirst($pending['destinataire']),
            'messageContenu' => nl2br(esc($pending['message'])),
            'dateEnvoi' => date('d/m/Y à H:i'),
            'token' => $pending['token']
        ];

        // Send Email to Club Admin
        // Note: Using the 'emails/receive_contact' view (Code provided below)
        if ($this->_sendEmail($destEmail, 'Contact Site : ' . $pending['email_user'], view('emails/receive_contact', $emailData), $pending['email_user'])) {
            // Cleanup on success
            $db->table('pending_contacts')->where('id', $pending['id'])->delete();
            return redirect()->to('/contact')->with('success', 'Message transmis au club !');
        } else {
            return redirect()->back()->with('error', "Le service d'envoi est temporairement indisponible.");
        }
    }

    /**
     * Private Wrapper to handle Email sending logic
     */
    private function _sendEmail($to, $subject, $message, $replyTo = null)
    {
        $email = \Config\Services::email();

        // Load config from .env or app/Config/Email.php automatically
        // If you MUST override here, uncomment below, but it is better to use .env

        /*
         * $config = [
         *     'protocol' => 'smtp',
         *     'SMTPHost' => 'smtp.gmail.com',
         *     'SMTPUser' => 'pec.jetable@gmail.com',
         *     'SMTPPass' => getenv('email.smtpPass'), // Load this from .env!
         *     'SMTPPort' => 465,
         *     'SMTPCrypto' => 'ssl',
         *     'mailType' => 'html',
         * ];
         * $email->initialize($config);
         */

        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message);

        if ($replyTo) {
            $email->setReplyTo($replyTo);
        }

        if ($email->send()) {
            return true;
        } else {
            // Log the specific error for Admin only, do not show to user
            log_message('error', $email->printDebugger(['headers']));
            return false;
        }
    }
}
<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail;
    public string $fromName;
    public string $protocol;
    public string $SMTPHost;
    public string $SMTPUser;
    public string $SMTPPass;
    public $SMTPPort; // Supprimer le type "string" ici pour accepter l'auto-overriding
    public string $SMTPCrypto;
    public string $mailType;
    public string $charset  = 'UTF-8';
    public bool $wordWrap   = true;

    public function __construct()
    {
        parent::__construct();

        // Lecture des valeurs du fichier .env avec des valeurs par défaut
        $this->fromEmail  = getenv('email.fromEmail') ?: 'pec.jetable@gmail.com';
        $this->fromName   = getenv('email.fromName')  ?: 'Palmes en Cornouailles';
        $this->protocol   = getenv('email.protocol')  ?: 'smtp';
        $this->SMTPHost   = getenv('email.SMTPHost')  ?: 'smtp.gmail.com';
        $this->SMTPUser   = getenv('email.SMTPUser')  ?: 'pec.jetable@gmail.com';
        $this->SMTPPass   = getenv('email.SMTPPass')  ?: 'etdn grvt ecbq zwfo';
        $this->SMTPCrypto = getenv('email.SMTPCrypto') ?: 'ssl';
        $this->mailType   = getenv('email.mailType')   ?: 'html';

        // Force la conversion en entier pour éviter l'erreur TypeError dans fsockopen()
        $port = getenv('email.SMTPPort') ?: 465;
        $this->SMTPPort = (int) $port;
    }
}
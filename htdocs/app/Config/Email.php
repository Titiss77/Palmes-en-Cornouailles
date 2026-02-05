<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    // adresse mail de tests
    // mail :
    // mot de passe : 
    public string $fromEmail  = 'pec.jetable@gmail.com'; // Ton adresse Gmail
    public string $fromName   = 'Palmes en Cornouailles';
    public string $protocol   = 'smtp';
    
    // Paramètres Gmail
    public string $SMTPHost   = 'smtp.gmail.com';
    public string $SMTPUser   = 'pec.jetable@gmail.com';
    public string $SMTPPass   = 'etdn grvt ecbq zwfo'; // Le code de 16 caractères de Google
    // On laisse la déclaration en string pour éviter l'erreur de type
    public string $SMTPPort   = '465'; 
    public string $SMTPCrypto = 'ssl';
    
    public string $mailType   = 'html';
    public string $charset    = 'UTF-8';
    public bool $wordWrap     = true;

    
    public function __construct()
    {
        parent::__construct();

        // C'EST ICI QUE CA SE JOUE : 
        // On force la conversion en entier pour la fonction fsockopen
        $this->SMTPPort = (int) $this->SMTPPort;
    }
    
}
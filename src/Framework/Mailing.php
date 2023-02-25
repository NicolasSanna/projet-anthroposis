<?php

namespace App\Framework;

use \Exception;
use \stdClass;

class Mailing
{
    private array $bodyVar;

    public function __construct(array|stdClass $bodyVar = [])
    {
        $this->bodyVar = (array) $bodyVar;
    }

    public function sendToAdmin(): void
    {
        $template = file_get_contents(TEMPLATE_DIR . '/' . 'mails/mail-to-admin.html');

        foreach($this->bodyVar as $key => $value)
        {
            $template = str_replace("{{". $key ."}}", $value, $template);
        }
        
        $to = EMAIL_TO;
        
        $subject = "Nouveau membre sur Anthroposis";

        $headers = "Content-Type: text/html; charset=utf-8\r\n";

        $from = EMAIL_FROM;

        $headers .= "From: " . $from;

        try
        {
            mail($to, $subject, $template, $headers);
        }
        catch(Exception $e)
        {
            throw new Exception(sprintf('Une erreur est survenue : %s', $e->getMessage()));
        }
    }

    public function sendToNewUser(): void
    {
        $template = file_get_contents(TEMPLATE_DIR . '/' . 'mails/mail-to-new-user.html');

        foreach($this->bodyVar as $key => $value)
        {
            $template = str_replace("{{". $key ."}}", $value, $template);
        }
        
        $to = $this->bodyVar['email'];
        
        $subject = "Bienvenue !";

        $headers = "Content-Type: text/html; charset=utf-8\r\n";

        $from = EMAIL_FROM;

        $headers .= "From: " . $from;

        try
        {
            mail($to, $subject, $template, $headers);
        }
        catch(Exception $e)
        {
            throw new Exception(sprintf('Une erreur est survenue : %s', $e->getMessage()));
        }
    }

    public function sendToNewAuthor(): void
    {
        $template = file_get_contents(TEMPLATE_DIR . '/' . 'mails/mail-to-new-author.html');

        foreach($this->bodyVar as $key => $value)
        {
            $template = str_replace("{{". $key ."}}", $value, $template);
        }
        
        $to = $this->bodyVar['email'];
        
        $subject = "Changement de rôles";

        $headers = "Content-Type: text/html; charset=utf-8\r\n";

        $from = EMAIL_FROM;

        $headers .= "From: " . $from;

        try
        {
            mail($to, $subject, $template, $headers);
        }
        catch(Exception $e)
        {
            throw new Exception(sprintf('Une erreur est survenue : %s', $e->getMessage()));
        }
    }

    public function sendToAuthorApprobeArticle(): void
    {
        $template = file_get_contents(TEMPLATE_DIR . '/' . 'mails/mail-to-author-approbe-article.html');

        foreach($this->bodyVar as $key => $value)
        {
            $template = str_replace("{{". $key ."}}", $value, $template);
        }
        
        $to = $this->bodyVar['email'];
        
        $subject = "Aprobation d'article";

        $headers = "Content-Type: text/html; charset=utf-8\r\n";

        $from = EMAIL_FROM;

        $headers .= "From: " . $from;

        try
        {
            mail($to, $subject, $template, $headers);
        }
        catch(Exception $e)
        {
            throw new Exception(sprintf('Une erreur est survenue : %s', $e->getMessage()));
        }
    }

    public function sendToAdministratorApprobeArticle(): void
    {
        $template = file_get_contents(TEMPLATE_DIR . '/' . 'mails/mail-to-administrator-approbe-article.html');
        
        $to = EMAIL_TO;
        
        $subject = "Aprobation d'article";

        $headers = "Content-Type: text/html; charset=utf-8\r\n";

        $from = EMAIL_FROM;

        $headers .= "From: " . $from;

        try
        {
            mail($to, $subject, $template, $headers);
        }
        catch(Exception $e)
        {
            throw new Exception(sprintf('Une erreur est survenue : %s', $e->getMessage()));
        }
    }
}
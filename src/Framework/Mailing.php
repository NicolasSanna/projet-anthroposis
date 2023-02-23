<?php

namespace App\Framework;

use \Exception;

class Mailing
{
    private array $bodyVar;

    public function __construct(array $bodyVar)
    {
        $this->bodyVar = $bodyVar;
    }

    public function sendToAdmin()
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
}
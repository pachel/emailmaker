<?php

namespace Pachel\emailMaker\Examples;

use Pachel\emailMaker\Mailer;
use PHPMailer\PHPMailer\PHPMailer;

class devDefaultMailTemplate extends Mailer
{
    protected $MAIL_SENDER = ["ttr@tdfsteel.com","TTR Termelést Támogató Rendszer"];
    protected $MAIL_LANGUAGE = "hu";
    protected $MAIL_CHARSET = PHPMailer::CHARSET_UTF8;
    protected $MAIL_CONTENT_TYPE = PHPMailer::CONTENT_TYPE_TEXT_HTML;

    protected $SMTP_HOST = "domain.com";
    protected $SMTP_PORT = 587;
    protected $SMTP_USER = "your_username";
    protected $SMTP_PASSWORD = "your_password";
    public function __construct()
    {
        parent::__construct();
        $this->addTemplate(__DIR__."/tpl/default.template.html");
    }


}
<?php

namespace Pachel\emailMaker\Examples;

use Pachel\emailMaker\Mailer;
use PHPMailer\PHPMailer\PHPMailer;

class defaultMailTemplate extends Mailer
{
    protected $MAIL_SENDER = ["ttr@tdfsteel.com","TTR Termelést Támogató Rendszer"];
    protected $MAIL_LANGUAGE = "hu";
    protected $MAIL_CHARSET = PHPMailer::CHARSET_UTF8;
    protected $MAIL_CONTENT_TYPE = PHPMailer::CONTENT_TYPE_TEXT_HTML;

    protected $SMTP_HOST = "algonet.net";
    protected $SMTP_PORT = 587;
    protected $SMTP_USER = "tdfsteel_ttr";
    protected $SMTP_PASSWORD = "62ShW9";
    public function __construct()
    {
        parent::__construct();
        $this->addTemplate(__DIR__."/tpl/default.template.html");
    }


}
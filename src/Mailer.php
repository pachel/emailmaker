<?php

namespace Pachel\emailMaker;

use Pachel\dbClass;
use Pachel\emailMaker\Callbacks\mailerCallback;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mailer
{
    /**
     * @var PHPMailer $mailer
     */
    private $mailer;
    protected $SMTP_HOST = "";
    protected $SMTP_PORT = "";
    protected $SMTP_USER = "";
    protected $SMTP_PASSWORD = "";
    protected $MAIL_LANGUAGE = "hu";
    protected $MAIL_SUBJECT = "";
    protected $MAIL_TEMPLATE = "";
    protected $MAIL_SENDER = [];//EMAIL,NAME
    protected $MAIL_REPLY = [];//EMAIL,NAME
    protected $MAIL_CHARSET = PHPMailer::CHARSET_UTF8;
    protected $MAIL_CONTENT_TYPE = PHPMailer::CONTENT_TYPE_TEXT_HTML;
    protected $SMTP_AUTH = true;

    public function __construct()
    {
        $this->mailer = new PHPMailer();
        $this->mailer->Host = $this->SMTP_HOST;
        $this->mailer->Port = $this->SMTP_PORT;
        $this->mailer->Username = $this->SMTP_USER;
        $this->mailer->Password = $this->SMTP_PASSWORD;

        //$this->mailer->addReplyTo((isset($class->_reply) && !empty($class->_reply) ? $class->_reply[0] : $class->_parent->_reply[0]), (!empty($class->_reply) ? $class->_reply[1] : $class->_parent->_reply[1]));
        //$this->mailer->setFrom((isset($class->_from) && !empty($class->_from) ? $class->_from[0] : $class->_parent->_from[0]), (!empty($class->_from) ? $class->_from[1] : $class->_parent->_from[1]));
        $this->mailer->setFrom($this->MAIL_SENDER[0],$this->MAIL_SENDER[1]);
        if(empty($this->MAIL_REPLY)){
            $this->mailer->addReplyTo($this->MAIL_SENDER[0],$this->MAIL_SENDER[1]);
        }
        else{
            $this->mailer->addReplyTo($this->MAIL_REPLY[0],$this->MAIL_REPLY[1]);
        }

        $this->mailer->CharSet = $this->MAIL_CHARSET;
        $this->mailer->ContentType = $this->MAIL_CONTENT_TYPE;
        $this->mailer->isSMTP();
        $this->mailer->SMTPDebug = SMTP::DEBUG_OFF;
        $this->mailer->SMTPAuth = $this->SMTP_AUTH;
        $this->mailer->Subject = $this->MAIL_SUBJECT;
        $this->mailer->setLanguage($this->MAIL_LANGUAGE);
    }

    /**
     * @param array|string $email
     * @param string|null $name
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function addAddress($email, $name = null)
    {
        if (is_array($email)) {
            foreach ($email as $item) {
                $this->mailer->addAddress($item[0], $item[1]);
            }
        } else {
            $this->mailer->addAddress($email, $name);
        }
    }

    public function addAttachment($path, $name = null)
    {
        $this->mailer->addAttachment($path, $name);
    }

    public function sendNow()
    {

        return $this->mailer->send();
        //echo $this->MAIL_TEMPLATE;
    }

    protected function addTemplate($template_file, $name = null)
    {
        if(!file_exists($template_file)){
            new \Exception(Messages::$TEMPLATE_NOT_EXISTS);
        }
        if(is_null($name)){
            $this->MAIL_TEMPLATE = file_get_contents($template_file);
            $this->mailer->msgHTML($this->MAIL_TEMPLATE);
            return;
        }
        $this->MAIL_TEMPLATE = str_replace($name,file_get_contents($template_file),$this->MAIL_TEMPLATE);
        $this->mailer->msgHTML($this->MAIL_TEMPLATE);
    }
    protected function addEmbeddedImage($path,$cid,$name = null){
        $this->mailer->addEmbeddedImage($path,$cid,$name);
    }
    public function replaceContent($search,$replace){
        $this->MAIL_TEMPLATE = str_replace($search,$replace,$this->MAIL_TEMPLATE);
        $this->mailer->msgHTML($this->MAIL_TEMPLATE);
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return $this->{$name}(...$arguments);
        }
    }


}
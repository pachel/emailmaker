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

    private $params = [];

    /**
     * @var baseEmailTemplate $_parent
     */
    private $_parent;

    private $_template;
    public function __construct($class)
    {
        $this->mailer = new PHPMailer();
        //$this->_template = $class;
       // $this->_parent = $parent;
        $config = $class->_parent->_config;


        $this->mailer->Host = $config["smtp_host"];
        $this->mailer->Port = $config["smtp_port"];
        $this->mailer->Username = $config["smtp_user"];
        $this->mailer->Password = $config["smtp_password"];

        $this->mailer->addReplyTo((isset($class->_reply) && !empty($class->_reply)?$class->_reply[0]:$class->_parent->_reply[0]),(!empty($class->_reply)?$class->_reply[1]:$class->_parent->_reply[1]));
        $this->mailer->setFrom((isset($class->_from) && !empty($class->_from)?$class->_from[0]:$class->_parent->_from[0]),(!empty($class->_from)?$class->_from[1]:$class->_parent->_from[1]));
        $this->mailer->msgHTML($class->_content);
        $this->mailer->CharSet = PHPMailer::CHARSET_UTF8;
        $this->mailer->ContentType = PHPMailer::CONTENT_TYPE_TEXT_HTML;
        $this->mailer->isSMTP();
        $this->mailer->SMTPDebug = SMTP::DEBUG_OFF;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Subject = $class->_subject;
        $this->mailer->setLanguage("hu");


    }

    /**
     * @param array|string $email
     * @param string|null $name
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function addAddress($email,$name=null){
        if(is_array($email)){
            foreach ($email AS $item){
                $this->mailer->addAddress($item[0],$item[1]);
            }
        }
        else{
            $this->mailer->addAddress($email,$name);
        }
    }
    public function addAttachment($path,$name=null){
        $this->mailer->addAttachment($path,$name=null);
    }
    public function sendNow(){
        return $this->mailer->send();
    }
    public function __call($name, $arguments)
    {
        if(method_exists($this,$name)){
            return $this->{$name}(...$arguments);
        }
    }
}
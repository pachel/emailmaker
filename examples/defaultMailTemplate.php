<?php

namespace Pachel\emailMaker\Examples;

use Pachel\emailMaker\baseEmailTemplate;

class defaultMailTemplate extends baseEmailTemplate
{
    protected $_template = __DIR__ . "/tpl/default.template.html";
    protected $_content = "content";


    protected $_from = ["email@yourdomain.com","Your Name"];
    protected $_reply = ["email@yourdomain.com","Your Name"];
    protected $_config = [
        "queue" => __DIR__ . "/../tmp/mailqueue/",
        "mail_per_run" => 5,
        "smtp_host"=>"yourdomain.com",
        "smtp_user"=>"username",
        "smtp_password"=>"password",
        "smtp_port"=>587
    ];
}
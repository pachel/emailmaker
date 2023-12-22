<?php

namespace Pachel\emailMaker\Examples;

use Pachel\emailMaker\baseEmailTemplate;

class tesztMail extends baseEmailTemplate
{
    protected $_template = __DIR__."/tpl/first.template.html";
    protected $_subject = "Teszt mail";
    protected $_templateClass = defaultMailTemplate2::class;
    public $name;

}
<?php

namespace Pachel\emailMaker\Examples;

class tesztMail extends defaultMailTemplate
{
    protected $MAIL_SUBJECT = "Teszt mail";

    public function __construct()
    {
        parent::__construct();
        $this->addTemplate(__DIR__."/tpl/first.template.html","#content#");
    }
}
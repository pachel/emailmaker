<?php

namespace Pachel\emailMaker\Examples;

class tesztMailDev extends devDefaultMailTemplate
{
    protected $MAIL_SUBJECT = "Teszt mail";

    public function __construct()
    {
        parent::__construct();
        $this->addTemplate(__DIR__."/tpl/first.template.html","#content#");
    }
}
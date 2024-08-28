<?php
namespace Pachel\emailMaker\Examples;

use Pachel\emailMaker\Mailer;

require_once __DIR__."/../vendor/autoload.php";

$template = new tesztMailDev();

$template->addAddress([["laszlo.toth@tdfsteel.com","Tóth László"]]);
$template->replaceContent("#name#","Tóth László");
if($template->sendNow()){
    echo "elküldve";
}
else{

    echo "HIBA";
}

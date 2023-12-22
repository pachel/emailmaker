<?php
namespace Pachel\emailMaker\Examples;

require_once __DIR__."/../vendor/autoload.php";

$template = new tesztMail();
$template->name = "Tóth László";
$mail = $template->mailer();
$mail->addAddress("pachel82@gmail.com","Tóth László");
if($mail->sendNow()){
    echo "elküldve";
}
else{
    echo "HIBA";
}

/*
abstract class Q
{
    private $classTree = [];
    protected function getParent()
    {
        $parent = get_parent_class($this);
        $vars = get_class_vars($parent);

        $reflect = new ReflectionClass($this);
        $props = $reflect->getProperties(ReflectionProperty::IS_PROTECTED);
        var_dump($props);

    }
    public function compose(){

        $this->getParent();
    }
    public function __get($name)
    {
        return $this->{$name};
    }
}

class A extends Q
{

    protected $_base_template = "s1";
    protected $content;
}

class B extends A
{
    protected $_template = "sas";
}

$d = new B();
$d->compose();

echo $d->_base_template;
*/
<?php

namespace Pachel\emailMaker;

class baseEmailTemplate
{
    /**
     * Template fájl neve
     * @var string $_template
     */
    protected $_template;
    /**
     * A template-ben található kicserélendő szöveg
     * @var string $_content
     */
    protected $_content = "";

    /**
     * Ha van, akkor az alap template class neve
     * @var string $_templateClass
     */
    protected $_templateClass;
    /**
     * @var array{
     *     queue:string,
     *     mail_per_run:string,
     *     smtp_host:string,
     *     smtp_user:string,
     *     smtp_password:string,
     *     smtp_port:int
     * } $_config
     */
    protected $_config;
    protected $_subject;
    protected $_charset = "UTF-8";
    protected $_content_type = "text/html";
    protected $_from;
    protected $_reply;
    private $_defConfig = [
        "queue",
        "mail_per_run",
        "smtp_host",
        "smtp_user",
        "smtp_password",
        "smtp_port"
    ];
    private $_parent;
    public function __construct()
    {
      //  if(empty($this->_config)) throw new \Exception(Messages::$CONFIG_NOT_CONFIGURED);
      //  if(!$this->checkConfig()) throw new \Exception(Messages::$CONFIG_IS_NOT_VALID);
       if(!file_exists($this->_template)) throw new \Exception(Messages::$TEMPLATE_NOT_EXISTS);
       if(empty($this->_content)){
           $this->_content = "";
       }

    }
    private function checkConfig(){
        foreach ($this->_defConfig AS $value){
            if(!isset($this->_config[$value])){
                return false;
            }
        }
        return true;
    }
    private function makeContent(){
        $vars = get_class_vars(get_class($this));
        $to_replace = [];
        $replace = [];

        foreach ($vars AS $index => $var){
            if($index == "_templateClass"){
                $this->_parent = new $var();
                continue;
            }
            elseif (preg_match("/^_/",$index)){
                continue;
            }
            $to_replace[] = "#".$index."#";
            $replace[] = $this->{$index};
        }

        $this->_content = str_replace($to_replace,$replace,file_get_contents($this->_template));
        $this->_content = str_replace("#".$this->_parent->_content."#",$this->_content,file_get_contents($this->_parent->_template));
    }
    public function mailer(){
        $this->makeContent();
        return new Mailer($this);
    }
    public function __get($name)
    {

        if(property_exists($this,$name)){
            return $this->{$name};
        }
    }
    public function __call($name, $arguments)
    {
        if(method_exists($this,$name)){
            return $this->{$name}(...$arguments);
        }
    }
}
/*
 "queue" => __DIR__."/../tmp/mailqueue/",
        "mail_per_run" => 5,
        "from"=>["ttr@tdfsteel.com","TTR - Termelés Támogató Rendszer"],
        "reply"=>["ttr@tdfsteel.com","TTR - Termelés Támogató Rendszer"],
        "smtp_host"=>"algonet.net",
        "smtp_user"=>"tdfsteel_ttr",
        "smtp_password"=>"62ShW9",
        "smtp_port"=>587,
 */
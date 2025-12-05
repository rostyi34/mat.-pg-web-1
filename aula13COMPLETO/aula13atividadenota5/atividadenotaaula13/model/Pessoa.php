<?php
namespace Model;
class Pessoa {
    private $nome;
    private $sobrenome;
    private $idade;
    private $email;
    public function __construct($nome="", $sobrenome="", $idade=0, $email=""){
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->idade = $idade;
        $this->email = $email;
    }
    public function getNome(){ return $this->nome; }
    public function setNome($v){ $this->nome = $v; }
    public function getSobrenome(){ return $this->sobrenome; }
    public function setSobrenome($v){ $this->sobrenome = $v; }
    public function getIdade(){ return $this->idade; }
    public function setIdade($v){ $this->idade = $v; }
    public function getEmail(){ return $this->email; }
    public function setEmail($v){ $this->email = $v; }
    public function nomeCompleto(){ return $this->nome . " " . $this->sobrenome; }
    public function toJSON(){ return json_encode(["nome"=>$this->nome, "sobrenome"=>$this->sobrenome, "idade"=>$this->idade, "email"=>$this->email], JSON_PRETTY_PRINT); }
}
?>
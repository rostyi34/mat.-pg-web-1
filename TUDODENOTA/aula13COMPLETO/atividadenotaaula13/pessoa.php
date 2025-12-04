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
    
    // Getters e Setters
    public function getNome(){ return $this->nome; }
    public function setNome($v){ $this->nome = $v; }
    public function getSobrenome(){ return $this->sobrenome; }
    public function setSobrenome($v){ $this->sobrenome = $v; }
    public function getIdade(){ return $this->idade; }
    public function setIdade($v){ $this->idade = $v; }
    public function getEmail(){ return $this->email; }
    public function setEmail($v){ $this->email = $v; }
    
    // Métodos de Operação
    public function nomeCompleto(){ return $this->nome . " " . $this->sobrenome; }
    
    public function toJSON(){ 
        // Usa get_object_vars para incluir os atributos privados na serialização JSON
        return json_encode(get_object_vars($this), JSON_PRETTY_PRINT); 
    }
}
?>
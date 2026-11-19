<?php

 abstract class Funcionario {
    private string $nome;
    private string $email;
    private float $salario;
 

    public function __contruct(
       string $nome,
       string $email,
       float $salario
 ) 
     {
    $this->setNome($nome);
    $this->setEmail($email);
    $this->setSalario($salario);
 }
       //para nome
     public function getNome(): string
      {
        return $this-> nome;
      }
      
    public function setNome(string $nome) : void {     //se retornar vazio
               if(trim($nome)==""){
                throw new invalidArgumentExeption("Nome obrigatorio");
               }
               $this->nome = trim($nome);
    }
    //para email
     public function getEmail(): string
      {
        return $this-> nome;
      }

    public function setEmail(string $email) : void {     //se retornar vazio
               if(trim($email)==""){
                throw new invalidArgumentExeption("Email obrigatorio");
               }
               $this->email = trim($email);
    }
    
 }
?>
<?php
//Funcionario Comum

require_once __DIR__ . "/Funcionario.php";
//    de operado a comum
class Gerente extends Funcionario
     {
        public function executarFuncao():string
              {
                return "O Gerente trabalha no gerenciamento da producao";
              }
        public function getCargo(): string
              {
                return "gerente";
              }
        //public function calcularBonus():float
         //    {
                
           //  }
     }


?>
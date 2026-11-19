<?php
//Funcionario Comum

require_once __DIR__ . "../Funcionario.php";
//    de operado a comum
class FuncionarioComum extends Funcionario
     {
        public function executarFuncao():string
              {
                return "O funcionario comum trabalha na producao";
              }
        public function getCargo(): string
              {
                return "funcionarioComum";
              }
        //public function calcularBonus():float
         //    {
                
           //  }
     }


?>
<?php

class Endereco {
   
   /** @var PDO */
   private $con;

   private $cep;
   private $logradouro;
   private $bairro;
   private $cod_cidade;

   public function __construct($con){
      $this->con = $con;
   }
   public function __get($valor){
      return $this->$valor;
   }

   public function __set($propriedade, $valor){
      $this->$propriedade = $valor;
   }
   public function insert(){
      try{

         $stmt = $this->con->prepare("INSERT INTO `Endereco`(`cep`, `logradouro`, `bairro`, `cod_cidade`) VALUES(?,?,?,?)");
         $stmt->bindParam(1, $this->cep);
         $stmt->bindParam(2, $this->logradouro);
         $stmt->bindParam(3, $this->bairro);
         $stmt->bindParam(4, $this->cod_cidade);

         $stmt->execute();

         return true;
      }catch (Exception $err){
         return $err;
      }
      
   }
   public function addressExists(){

      try {
         $stmt = $this->con->prepare("SELECT * FROM `dbclientes`.`endereco` WHERE cep = ?");
         $stmt->bindParam(1, $this->cep);
         $stmt->execute();

         $row = $stmt->fetch(PDO::FETCH_OBJ);
         
         if(empty($row)){
            return true;
         }
         return false;
         
      } catch (Exception $err) {
         throw $err;
      }
   }
   
   
}

?>
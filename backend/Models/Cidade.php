<?php

class Cidade {
   /** @var PDO */
   private $con;
   
   private $cidade;
   private $cod_estado;

   public function __construct($con)
   {
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
         $stmt = $this->con->prepare("INSERT INTO `Cidade`(`cidade`, `cod_estado`) VALUES(?,?)");
         $stmt->bindParam(1, $this->cidade);
         $stmt->bindParam(2, $this->cod_estado);

         $stmt->execute();

         return true;
      }catch (Exception $err){
         return $err;
      }
         
   }
   public function cityExists(){
      try {
         
         $stmt = $this->con->prepare("SELECT * FROM `dbclientes`.`cidade` WHERE cidade = ? and cod_estado = ?");
         $stmt->bindParam(1, $this->cidade);
         $stmt->bindParam(2, $this->cod_estado);
         
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
   public function findIdOfCity(){
      try {

        $stmt = $this->con->prepare("SELECT `cod_cidade` FROM `dbclientes`.`cidade` WHERE `cidade` = ?");
        $stmt->bindParam(1, $this->cidade);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_OBJ);

        return $row->cod_cidade;

      }catch (Exception $err){
        throw $err;
      }
  }
   
}

?>
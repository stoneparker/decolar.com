<?php

class Cliente{

    /** @var PDO */
    private $con;

    private $id_cliente;
    private $nome;
    private $sobrenome;
    private $numero;
    private $sexo;
    private $data_nascimento;
    private $cpf;
    private $rg;
    private $guarda_religiosa;
    private $obs;
    private $telefone;
    private $email;
    private $cep;

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
            $stmt = $this->con->prepare("INSERT INTO `dbclientes`.`cliente` (`nome`,
            `sobrenome`, `numero`, `sexo`, `data_nascimento`, `cpf`, `rg`, `guarda_religiosa`, `obs`, `telefone`, `email`, `cep`)
             VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
   
   
           $stmt->bindParam(1, $this->nome);
           $stmt->bindParam(2, $this->sobrenome);
           $stmt->bindParam(3, $this->numero);
           $stmt->bindParam(4, $this->sexo);
           $stmt->bindParam(5, $this->data_nascimento);
           $stmt->bindParam(6, $this->cpf);
           $stmt->bindParam(7, $this->rg);
           $stmt->bindParam(8, $this->guarda_religiosa);
           $stmt->bindParam(9, $this->obs);
           $stmt->bindParam(10, $this->telefone);
           $stmt->bindParam(11, $this->email);
           $stmt->bindParam(12, $this->cep);
   
           $stmt->execute();
        }catch(Exception $err){
            return $err;
        }
        
    }
    public function selectAll(){
        try {

            $response = '';
            $stmt = $this->con->prepare("SELECT * FROM `dbclientes`.`cliente`");
            $stmt->execute();
            
            while ($row = $stmt->fetch(PDO::FETCH_OBJ )) {

                //Construindo o corpo da tabela
                $response = $response . "<tr>";

                $response = $response . "<th scope'row'>" .$row->id_cliente. "</th>";
                $response = $response . "<td>" .$row->nome. "</td>";
                $response = $response . "<td>" .$row->sobrenome. "</td>";
                $response = $response . "<td>" .$row->numero. "</td>";
                $response = $response . "<td>" .$row->sexo. "</td>";
                $response = $response . "<td>" .date("d/m/y", strtotime($row->data_nascimento)). "</td>";
                $response = $response . "<td>" .$row->cpf. "</td>";
                $response = $response . "<td>" .$row->rg. "</td>";
                $response = $response . "<td>" .$row->guarda_religiosa. "</td>";
                $response = $response . "<td>" .$row->obs. "</td>";
                $response = $response . "<td>" .$row->telefone. "</td>";
                $response = $response . "<td>" .$row->email. "</td>";
                $response = $response . "<td>" .$row->cep. "</td>";

                $response = $response . "<td><i onclick=deleteClient(this,event) class='fas fa-trash-alt'></i></td> </tr>";

                
            }
            
            return $response;

        } catch (Exception $err) {
            return $err;
        }
    }

    public function clientExists(){
        try {
            $stmt = $this->con->prepare("SELECT * FROM `dbclientes`.`cliente` WHERE cpf = ? OR rg = ? OR email = ?");
            $stmt->bindParam(1, $this->cpf);
            $stmt->bindParam(2, $this->rg);
            $stmt->bindParam(3, $this->email);

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
    public function delete(){
        try {
            $stmt = $this->con->prepare("DELETE FROM `dbclientes`.`cliente` WHERE id_cliente = ?");
            $stmt->bindParam(1, $this->id_cliente);
            $stmt->execute();

        } catch (Exception $err) {
            return $err;
        }
    }
}

?>
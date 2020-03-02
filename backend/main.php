<?php

require './utils/connection.php';

//Obtendo acesso as classes
require './Models/Cliente.php';
require './Models/Cidade.php';
require './Models/Endereco.php';

class Main {

   /** @var PDO */
   private $con;

   private $method;
   private $content;

   private $response;

   public function __construct($con)
   {
      $this->con = $con;
   }

   public function indentifyMethodAndVars($method, $strvars){
      
      $this->content = $strvars;
      $this->content = (array) ($this->content);
      $this->method = $method;

      switch ($this->method) {
         case 'POST':
            $this->response = $this->postClient();
           break;
         case 'GET':
            $this->response = $this->getClient();
           break;
         case 'DELETE':
            $this->response = $this->deleteClient();
           break;
      }

      return $this->response;
   }

   private function postClient(){
      //Instanciando as classes
      $cidade = new Cidade($this->con);
      $endereco = new Endereco($this->con);
      $cliente = new Cliente($this->con);

      //Propriedades do cliente
      $cliente->__set('nome', $this->content['nome']);
      $cliente->__set('sobrenome', $this->content['sobrenome']);
      $cliente->__set('numero', $this->content['numero']);
      $cliente->__set('sexo', $this->content['sexo']);
      $cliente->__set('data_nascimento', $this->content['data_nascimento']);
      $cliente->__set('cpf', $this->content['cpf']);
      $cliente->__set('rg', $this->content['rg']);
      $cliente->__set('guarda_religiosa', $this->content['guarda_religiosa']);
      $cliente->__set('obs', $this->content['obs']);
      $cliente->__set('telefone', $this->content['telefone']);
      $cliente->__set('email', $this->content['email']);
      $cliente->__set('cep', $this->content['cep']);

      //Propriedades da cidade
      $cidade->__set('cidade', $this->content['cidade']);
      $cidade->__set('cod_estado', $this->content['cod_estado']);

      //Inserindo a cidade
      if($cidade->cityExists() && ($cliente->clientExists())){
         $cidade->insert();
      }

      //Propriedades do endereço
      $endereco->__set('cep', $this->content['cep']);
      $endereco->__set('logradouro', $this->content['logradouro']);
      $endereco->__set('bairro', $this->content['bairro']);
      $endereco->__set('cod_cidade', ($cliente->clientExists()) ? $cidade->findIdOfCity() : null);

      //Inserindo o endereço
      if($endereco->addressExists() && ($cliente->clientExists())){
         $endereco->insert();
      }
      
      //Inserindo o cliente
      if($cliente->clientExists()){
         $cliente->insert();
         return 'OK';
      }

      return 'Error: Client already exists';
   }

   private function getClient(){
      $cliente = new Cliente($this->con);

      return $cliente->selectAll();
      
   }
   private function deleteClient(){
      $cliente = new Cliente($this->con);

      echo 'Ta vindo';
      
      //Passando o id
      $cliente->__set('id_cliente', $_REQUEST['id_cliente']);
      $cliente->delete();

      return 'OK';
   }
   

   
}

?>
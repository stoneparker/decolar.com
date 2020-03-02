<?php

require './utils/connection.php';

//Obtendo acesso as classes
require './Models/Cliente.php';
require './Models/Cidade.php';
require './Models/Endereco.php';


//Instanciando as classes
$cidade = new Cidade($con);
$endereco = new Endereco($con);
$cliente = new Cliente($con);

//Set da cidade
$cidade->__set('cidade', $_POST['cidade']);
$cidade->__set('cod_estado', $_POST['cod_estado']);

//Set do endereço
$endereco->__set('cep', $_POST['cep']);
$endereco->__set('logradouro', $_POST['logradouro']);
$endereco->__set('bairro', $_POST['bairro']);
$endereco->__set('cod_cidade', $_POST['cod_cidade']);

//Set do cliente
$cliente->__set('nome', $_POST['nome']);
$cliente->__set('sobrenome', $_POST['sobrenome']);
$cliente->__set('senha', $_POST['senha']);
$cliente->__set('numero', $_POST['numero']);
$cliente->__set('sexo', $_POST['sexo']);
$cliente->__set('data_nascimento', $_POST['data_nascimento']);
$cliente->__set('cpf', $_POST['cpf']);
$cliente->__set('rg', $_POST['rg']);
$cliente->__set('guarda_religiosa', $_POST['guarda_religiosa']);
$cliente->__set('obs', $_POST['obs']);
$cliente->__set('telefone', $_POST['telefone']);
$cliente->__set('email', $_POST['email']);
$cliente->__set('cep', $_POST['cep']);

//Realizando inserts
$cidade->insert();
$endereco->insert();
$cliente->insert();

echo 'Processo feito';

var_dump($_POST);

?>
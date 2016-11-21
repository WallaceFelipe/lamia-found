<?php

require_once("Conexao.class.php");

class Usuario {
    
    private $id;
    private $cpf;

    public $login;
    public $nome;
    public $email;
    public $dataNascimento;

    public $endereco;
    public $cidade;
    public $estado;
    public $pais;
    
    public $tipo;
    public $categoria = null;

    function __construct($identificador) {
        $conexao = new Conexao();
        $dados = $conexao->select('*')->from('usuario')->where("id = '$identificador'")->limit('1')->executeNGet();

        $this->id = $dados['id'];
        $this->cpf = $dados['cpf'];
        $this->login = $dados['login'];
        $this->nome = $dados['nome'];
        $this->email = $dados['email'];
        $this->dataNascimento = $dados['datanascimento'];
        $this->endereco = $dados['endereco'];
        $this->cidade = $dados['cidade'];
        $this->estado = $dados['estado'];
        $this->pais = $dados['pais'];
        $this->tipo = $dados['tipo'];

        if ($dados['ativo'] == 0) {
            $conexao->update('usuario', array('ativo'=>'1'), $identificador, 'id');
        }

        if ($this->tipo == 'avaliadordeprojeto') {
            $categoria = $conexao->select('categoria')->from('avaliadordeprojetos')->where("idusuario = '$this->id'")->executeNGet();
            $this->categoria = $categoria[0]['categoria']; 
        }
    }

    function getTipo(){
        return $this->tipo;
    }

    function getId() {
        return $this->id;
    }
    
    function getCpf() {
        return $this->cpf;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function getData() {
        $data = explode("-", $this->dataNascimento);
        $aux = $data[0];
        $data[0] = $data[2];
        $data[2] = $aux;
        return join("-", $data); 
    }

}
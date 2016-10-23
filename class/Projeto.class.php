<?php 
	include("class/conexao.php");
	class Projeto{
	
   private $id;
	private $nome;
	private $categoria;
	private $status; 
	private $duracaoprevista;
	public $valor;
	public $prazomaximo; //Prazo maximo para execução
	public $valorminimo; //Valor minimo permitido para financiamento
	public $valormaximo; //Valor maximo permitido para financiamento
	
		public function __construct(){}
		
		public function __set(){
			$this->data[$name] = $value;		
		}
		
		public function __get($name){
			 echo "Getting '$name'\n";
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;		
		}
		
		public function create($nome,$categoria,$duracaoprevista,$valor){
			$conexao = new Conexao();			
			return $conexao->insert('projeto', array('nome'=>$nome,
			'categoria'=>$categoria,'status'=>'candidato',
			'duracaoprevista'=>$duracaoprevista,'valor'=>$valor)); 
		}
		
	}
	
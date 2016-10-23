<?php 
	include("class/conexao.php");
	class Projeto{
	
   private $id;
   private $codigo;
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
		
		public function create($codigo,$nome,$categoria,$duracaoprevista,$valor){
			$conexao = new Conexao();		
			return $conexao->insert('projeto', array('nome'=>$nome,
																  'codigo'=>$codigo,
																  'categoria'=>$categoria,
																  'status'=>'candidato',
																  'duracaoprevista'=>$duracaoprevista,
																  'valor'=>$valor)); 
		}
	   
	   public function read($codigo=NULL,$nome=NULL,$categoria){
				$conexao  = new Conexao();
				if($codigo!=NULL){				
					$projetos = $conexao->select('nome,categoria,valor,duracaoprevista')
										  ->from('projeto')
										  ->where('codigo = '.$codigo)
										  ->limit(1)
										  ->executeNGet(); 
					$json ='{"projetos" : [{'.
													' "nome" : "'.projetos['nome'].'"'.
													' "categoria" : "'.projetos['categoria'].'"'.
													' "valor" : "'.projetos['valor'].'"'.
													' "duracaoprevista" : "'.projetos['duracaoprevista'].'"'.
												'} ]}';
					return $json;
				}
				
				if($nome!=NULL){				
					$projetos = $conexao->select('nome,categoria,valor,duracaoprevista')
										  ->from('projeto')
										  ->where('nome = '.$nome)
										  ->limit(1)
										  ->executeNGet(); 
					$json ='{"projetos" : [{'.
													' "nome" : "'.projetos['nome'].'"'.
													' "categoria" : "'.projetos['categoria'].'"'.
													' "valor" : "'.projetos['valor'].'"'.
													' "duracaoprevista" : "'.projetos['duracaoprevista'].'"'.
												'} ]}';
					return $json;
				}
				$projetos = $conexao->select('nome,categoria,valor,duracaoprevista')
										  ->from('projeto')
										  ->where('categoria = '.$categoria)
										  ->executeNGet(); 
				$json ='{"projetos" : [';
				foreach($projetos as $projeto){
					$json +='{ "nome" : "'.projeto['nome'].'"'.
							   ' "categoria" : "'.projeto['categoria'].'"'.
							   ' "valor" : "'.projeto['valor'].'"'.
							   ' "duracaoprevista" :"'.projeto['duracaoprevista'].'"'.
							  '}'; 	 				
				}
				$json += ']}'	
		}
		
		public function update($codigo,$nome=NULL, $categoria=NULL,$duracaoprevista=NULL,$valor=NULL){
			$update_values = array();
			
			if($nome!=NULL) array_push($update_values,'nome',$nome);
			if($categoria != NULL) array_push($update_values,'categoria',$categoria);
			if($duracaoprevista != NULL) array_push($update_values,'duracaoprevista',$duracaoprevista);
			if($valor != NULL) array_push($update_values,'valor',$valor);		
			
			$conexao = new Conexao();
			$conexao->update('projeto', $update_values,$codigo);	
		}
		
	}
	
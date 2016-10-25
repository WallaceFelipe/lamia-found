<?php 
	require_once("Conexao.class.php");
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
		
		public function __set($name,$value){
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
		
		public function sql_create($codigo,$nome,$categoria,$duracaoprevista,$valor){
			$conexao = new Conexao();		
			return $conexao->insert('projeto', array('nome'=>$nome,
																  'codigo'=>$codigo,
																  'categoria'=>$categoria,
																  'status'=>'candidato',
																  'duracaoprevista'=>$duracaoprevista,
																  'valor'=>$valor)); 
		}
	   
	   public function sql_read($codigo='',$nome='',$categoria=''){
				$conexao  = new Conexao();
				$projetos;
				if($codigo!=''){				
					$projetos = $conexao->select('*')
										  ->from('projeto')
										  ->where("codigo = '".$codigo."'")
										  ->executeNGet(); 					
				}
				else if($nome!=''){				
					$projetos = $conexao->select('*')
										  ->from('projeto')
										  ->where("nome = '".$nome."'")
										  ->executeNGet(); 
					
				}
				else if($categoria!=''){
					$projetos = $conexao->select('*')
											  ->from('projeto')
											  ->where("categoria = '".$categoria."'")
											  ->executeNGet(); 
				}
				else{
					$projetos = $conexao->select('*')
											  ->from('projeto')
											  ->executeNGet();
					}
				return $projetos;	
		
			}
		
		
		public function sql_update($codigo,$nome='',
					 $cat='',$duracaoprevista='',$valor=''){
			$update_values = array();
			
			if($nome!='') $update_values['nome'] = $nome;
			if($cat != '') $update_values['categoria'] = $cat;
			if($duracaoprevista != '') $update_values['duracaoprevista'] = $duracaoprevista;
			if($valor != '') $update_values['valor'] = $valor;		
			
			$conexao = new Conexao();
			$conexao->update('projeto', $update_values,$codigo);	
		}
		
		public function sql_delete($codigo='') {
			$conexao = new Conexao();
			if($codigo!='')$conexao->execute("DELETE FROM projeto WHERE codigo = '".$codigo."'");
		}
		
	}
?>
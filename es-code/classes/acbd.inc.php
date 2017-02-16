    <?PhP
class acbd extends mysqli{
	protected $qid		= 0;
	private function avqid($quidl){
		if($quidl==0){
			return $this->qid;
			return $this->qid;
		}
		return $quidl;
	}
	function __construct(){
		$this->ligacao		= new mysqli(BD_SERVIDOR, BD_UTILIZADOR, BD_PALAVRA, BD, BD_PORTA);
		if($this->ligacao->connect_error){
			echo "Erro: ",$this->ligacao->connect_error(),"<br />Erro N&ordm;: ",$this->ligacao->connect_errno();
		}
		$this->ligacao->set_charset("utf8");
		$this->qid	= 0;
		return $this->ligacao;
	}
	function __destruct(){
		if($this->ligacao != FALSE){
			if($this->ligacao->close()){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
	public function query($query){
		$this->qid++;
		$this->dados[$this->qid]	= $this->ligacao->query($query);
		if($this->dados[$this->qid]){
			return $this->qid;
		}else{
			return FALSE;
		}
	}
	public function tem_linhas($quidl = 0){
		$quidl	= $this->avqid($quidl);
		if($quidl == FALSE){
			return FALSE;
		}
		if($this->dados[$quidl]->num_rows>0){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	public function num_linhas($quidl = 0){
		$quidl	= $this->avqid($quidl);
		if($quidl == FALSE){
			return FALSE;
		}
		return $this->dados[$quidl]->num_rows;
	}
	public function set_linha($quidl = 0, $linha = 0){
		$quidl	= $this->avqid($quidl);
		return $this->dados[$quidl]->data_seek($linha);
	}
	public function dados($quidl = 0){
		$quidl	= $this->avqid($quidl);
		return $this->dados[$quidl]->fetch_row();
	}
	public function ultimo_id(){
		$idReg	= $this->ligacao->insert_id;
		return $idReg;
	}
	public function limpa($quidl = 0){
		$quidl	= $this->avqid($quidl);
		if($this->dados[$quidl]->free_result()){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	public function escape_string($string){
		return $this->ligacao->real_escape_string($string);
	}
	public function num_erro(){
		$erro	= $this->ligacao->errno;
		return $erro;
	}
	public function autocommit($value = 1){
		$this->ligacao->autocommit($value);
	}
	public function commit($flags = NULL, $name = NULL){
		$this->ligacao->commit($flags, $name);
	}
}
<?php
class gerecht_opties extends tmap {
	
	public $id;
	public $naam;
	

	public $gerecht_opties_array = array();
	public $lijst;
	
	public function create(){
		$this->naam 		= $_POST["naam"];
		$this->table_string = get_class($this);
		$this->column_arr 	= array('id', 'naam');
		$this->value_arr 	= array(NULL, mysql_real_escape_string($this->naam));
		$this->nieuw();
	}
	
	public function read(){
		$this->column_arr 	= array('*');
		$this->table_arr 	= array('gerecht_opties go');
		$this->sort_arr 	= array('go.naam');
		$this->lijst 		= $this->lezen();
	}
	
	public function readLine($id){
		$this->column_arr 	= array('*');
		$this->table_arr 	= array('gerecht_opties go');
		$this->where_arr 	= array('go.id' => $id);
		$this->lijst 		= $this->lezen();
	}
	
	public function update(){
		$this->id 			= $_POST["id"];
		$this->naam 		= $_POST["naam"];
		$this->table_string = get_class($this);
		$this->set_arr		= array('naam' => $this->naam);
		$this->where_arr	= array('id' => $this->id);
		$this->wijzigen();
	}
	
	public function delete(){
		$this->gerecht_opties_array 	= $_POST["id"];
		$arr 				= $this->gerecht_opties_array;
		$this->table_arr 	= array(get_class($this));
		foreach($arr as $value) {
			$verwijderstring 	= " id = " . $value;
			$this->where_string = $verwijderstring;
			$this->verwijderen();
		}
	}
}
?>
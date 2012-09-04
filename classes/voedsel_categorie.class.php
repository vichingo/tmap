<?php

class voedsel_categorie extends tmap {
	public $vc_arr = array();
	public $lijst;
	
	public $id;
	public $naam;

	
	public function create(){
		$naam = $_POST["naam"];
		$this->table_string = get_class($this);
		$this->column_arr = array('id', 'naam');
		$this->value_arr = array(NULL, $naam);
		$this->nieuw();
	}
	
	public function read(){
		$this->column_arr = array('vc.id','vc.naam categorie');
		//$this->column_string = '*';
		$this->table_arr = array('voedsel_categorie vc');
		$this->lijst = $this->lezen();
	}
	
	public function readLine($referentie){
		$this->column_arr 		= array('vc.id',
										'vc.naam categorie');
		$this->table_arr 		= array('voedsel_categorie vc');
		$this->where_arr		= array('vc.id' => $referentie);
		$this->lijst 			= parent::lezen();
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
		$this->vc_array = $_POST["id"];
		$arr = $this->vc_array;
		$this->table_arr = array(get_class($this));
		foreach($arr as $key=>$value) {
			$verwijderstring = "id = " . $value;
			$this->where_string = $verwijderstring;
			$this->verwijderen();
		}
	}
}
//		echo "<pre>";
//			var_dump($arr);
//		echo "</pre>";
?>
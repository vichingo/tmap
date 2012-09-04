<?php
class optie_variant extends tmap {
	
	public $id;
	public $naam;
	public $optie_id;
	public $matrix;
	
	public $optie_variant_array = array();
	public $lijst;
	
	

	
	public function create(){
		$this->naam 			= $_POST["variatie"];
		$this->optie_id 		= $_POST["optie_id"];
		$this->matrix 			= $_POST["matrix"];
		$cleaned_matrix 		= str_replace(",", ".", $this->matrix);
		$this->table_string 	= get_class($this);
		$this->column_arr 		= array('id', 'naam', 'optie_id' ,'matrix');
		$this->value_arr 		= array(NULL, $this->naam, $this->optie_id, $cleaned_matrix);
		$this->nieuw();
	}
	
	public function read(){
		$this->column_arr 		= array('ov.id', 'ov.naam variatie', 'ov.matrix', 'ov.optie_id', 'go.naam optie_naam');
		$this->table_arr 		= array('optie_variant ov', 'gerecht_opties go');
		$this->where_arr 		= array('ov.optie_id' => 'go.id');
		$this->sort_arr 		= array('go.naam', 'ov.matrix');
		$this->lijst 			= parent::lezen();
	}
	
	public function readLine($id){
		$this->column_arr 		= array('ov.id', 'ov.naam variatie', 'ov.matrix', 'ov.optie_id', 'go.naam optie_naam');
		$this->table_arr 		= array('optie_variant ov', 'gerecht_opties go');
		$this->where_arr 		= array('ov.optie_id' => 'go.id', 'ov.id' => $id);
		$this->lijst 			= $this->lezen();
	}
	
	public function update(){
		$this->id 				= $_POST["id"];
		$this->naam 			= $_POST["variatie"];
		$this->optie_id 		= $_POST["optie_id"];
		$this->matrix 			= $_POST["matrix"];
		$cleaned_matrix 		= str_replace(",", ".", $this->matrix);
		$this->table_string 	= get_class($this);
		$this->set_arr			= array('naam' => $this->naam, 'optie_id' => $this->optie_id ,'matrix' => $cleaned_matrix);
		$this->where_arr		= array('id' => $this->id);
		$this->wijzigen();
	}
	
	public function delete(){
		$this->optie_variant_array 	= $_POST["id"];
		$arr 					= $this->optie_variant_array;
		$this->table_arr 		= array(get_class($this));
		foreach($arr as $value) {
			$verwijderstring 	= " id = " . $value;
			$this->where_string = $verwijderstring;
			$this->verwijderen();
		}
	}
}
?>
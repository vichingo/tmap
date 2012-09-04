<?php
 class gerecht_bestanddeel extends tmap {
 	
 	public $id;
 	public $bestanddeel_id;
 	public $gerecht_id;
 	public $op_basis;
 
 	public $gerecht_bestanddeel_array = array();
	public $lijst;

	public function create(){
		$this->gerecht_id 					= $_POST["gerecht_id"];
		$this->op_basis 					= $_POST["op_basis"];
		$gb_arr 							= $_POST["bestanddeel_id"];
		foreach($gb_arr as $value) {
			$this->table_string 			= 'gerecht_bestanddeel';
			$this->column_arr 				= array('id', 'bestanddeel_id', 'gerecht_id', 'op_basis');
			$this->value_arr 				= array(NULL, $value, $this->gerecht_id, $this->op_basis );
			parent::nieuw();
		}
	}
	
	public function read(){
		
		/*
		 * SELECT gb.`id`, g.`id`, g.`naam`, b.`id`, b.`naam`, gb.`op_basis`
		 * FROM gerecht_bestanddeel gb, gerecht g, bestanddeel b
		 * WHERE g.id=gb.gerecht_id AND b.id=gb.bestanddeel_id;
		 *
		 */
		$this->column_arr 		= array('gb.id gerechtBestanddeelId',
										'g.id gerechtId',
										'g.naam gerechtNaam',
										'b.id bestanddeelId',
										'b.naam bestanddeelNaam',
										'gb.op_basis');
		$this->table_arr 		= array('gerecht_bestanddeel gb', 'gerecht g', 'bestanddeel b');
		$this->where_arr		= array('g.id' => 'gb.gerecht_id', 'b.id' => 'gb.bestanddeel_id');
		$this->sort_arr			= array('g.naam');
		$this->lijst 			= parent::lezen();
	}
	
	public function readLine($referentie){
		$this->column_arr 		= array('gb.id gerechtBestanddeelId',
										'g.id gerechtId',
										'g.naam gerechtNaam',
										'b.id bestanddeelId',
										'b.naam bestanddeelNaam',
										'gb.op_basis');
		$this->table_arr 		= array('gerecht_bestanddeel gb', 'gerecht g', 'bestanddeel b');
		$this->where_arr		= array('gb.id' => $referentie, 'g.id' => 'gb.gerecht_id', 'b.id' => 'gb.bestanddeel_id');
		$this->lijst 			= parent::lezen();
	}
	
	public function update(){
		$this->id				= $_POST["id"];
		$this->bestanddeel_id 	= $_POST["bestanddeel_id"];
		$this->gerecht_id 		= $_POST["gerecht_id"];
		$this->op_basis 		= $_POST["op_basis"];
		foreach($_POST["bestanddeel_id"] as $value){
			$this->table_string 	= get_class($this);
			$this->set_arr			= array('bestanddeel_id' => $value, 'gerecht_id' => $this->gerecht_id ,'op_basis' => $this->op_basis);
			$this->where_arr		= array('id' => $this->id);
			parent::wijzigen();
		}
		
	}
	
	public function delete(){
		$arr 	= $_POST["id"];
		$this->table_arr 					= array(get_class($this));
		foreach($arr as $value) {
			$verwijderstring 				= " id = " . $value;
			$this->where_string 			= $verwijderstring;
			parent::verwijderen();
		}
	}
}
?>
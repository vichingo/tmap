<?php
class leverwijze extends tmap {

	public $id;
	public $naam;

	public function read(){
		$this->column_arr 		= array('*');
		$this->table_arr 		= array('leverwijze lt');
		$this->sort_arr			= array('lt.naam');
		$this->lijst 			= parent::lezen();
	}

	public function readLine($id){
		$this->column_arr 		= array('*');
		$this->table_arr 		= array('leverwijze lt');
		$this->where_arr		= array('lt.id'=> $id);
		$this->lijst 			= parent::lezen();
	}
}
?>
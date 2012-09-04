<?php

class lokatie extends tmap {

	public $id;
	public $alpha;
	public $longitude;
	public $latitude;
	public $code;
	public $name;
	public $provincie_id;
	public $lokatie_zonenummer_id;



	public function read(){
		$this->column_arr 		= array('*');
		$this->table_arr 		= array('lokatie l');
		$this->sort_arr 		= array('code');
		$this->lijst 			= parent::lezen();
	}

	public function readLine($id){
		$this->column_arr 		= array('*');
		$this->table_arr 		= array('lokatie l');
		$this->where_arr 		= array('l.id'=> $id);
		$this->lijst 			= $this->lezen();
	}
}
?>
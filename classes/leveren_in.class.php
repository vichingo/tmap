<?php

class leveren_in extends tmap {

	public $lokatie_id;
	public $resto_id;
	public $leveringkost;



	public function read(){
		$this->column_arr = array('*');
		$this->table_arr = array('leveren_in');
		$this->lijst = $this->lezen();
	}
	public function readLine($id){
		$this->column_arr = array('*');
		$this->table_arr = array('leveren_in');
		$this->where_arr = array('id' => $id);
		$this->lijst = $this->lezen();
	}

}

?>
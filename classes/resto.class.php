<?php
class resto extends tmap {

	public $naam;
	public $taal;
	public $lokatie_adres;
	public $lokatie_id;
	public $leveringkosten_minimaal;


	public function read(){
		$this->column_arr = array('*');
		$this->table_arr = array('resto r');
		$this->sort_arr = array('r.naam');
		$this->lijst = $this->lezen();
	}

	public function readLine($id){
		$this->column_arr = array('*');
		$this->table_arr = array('resto r');
		$this->where_arr = array('r.id' => $id);
		$this->lijst = $this->lezen();
	}

}
?>
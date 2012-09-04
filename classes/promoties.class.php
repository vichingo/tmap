<?php
class faqs extends tmap {

	public $onderwerp;
	public $bericht;


	public function read(){
		$this->column_arr = array('*');
		$this->table_arr = array('promoties p');
		$this->sort_arr = array('p.id');
		$this->lijst = $this->lezen();
	}

	public function readLine($id){
		$this->column_arr = array('*');
		$this->table_arr = array('faqs f');
		$this->where_arr = array('f.id' => $id);
		$this->lijst = $this->lezen();
	}


}
?>
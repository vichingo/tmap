<?php
class faqs extends tmap {

	public $vraag;
	public $antwoord;
	public $volgorde;


	public function read(){
		$this->column_arr = array('*');
		$this->table_arr = array('faqs f');
		$this->sort_arr = array('f.volgorde');
		$this->lijst = $this->lezen();
	}

	public function readLine($id){
		$this->column_arr = array('*');
		$this->table_arr = array('faqs f');
		$this->where_arr = array('f.id' => $id);
		$this->lijst = $this->lezen();
	}
	public function changeOrder($volgorde, $item_id){
		$this->table_arr 	= array('faqs');
		$this->set_arr		= array('volgorde' => $volgorde);
		$this->where_arr	= array('id' => $item_id);
		$this->wijzigen();
	}

}
?>
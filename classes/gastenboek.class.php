<?php
class gastenboek extends tmap {

	public $naam;
	public $email;
	public $bericht;
	public $post_tijd;
	public $ip;


	public function read($direction){
		$this->column_arr = array('*');
		$this->table_arr = array('gastenboek gb');
		$this->sort_arr = array('gb.post_tijd '.$direction);
		$this->lijst = $this->lezen();
	}

	public function readLine($id){
		$this->column_arr = array('*');
		$this->table_arr = array('gastenboek gb');
		$this->where_arr = array('gb.id' => $id);
		$this->lijst = $this->lezen();
	}


}
?>
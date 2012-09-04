<?php
class menu extends tmap {

	public $id;
	public $naam;
	public $menu_code;
	
	public $menu_array = array();
	public $lijst;
	
	public function create(){
		$this->naam 		= $_POST["naam"];
		$this->menu_code	= $_POST["menu_code"];
		$this->table_string = get_class($this);
		$this->column_arr 	= array('id', 'naam', 'menu_code');
		$this->value_arr 	= array(NULL, mysql_real_escape_string($this->naam), mysql_real_escape_string($this->menu_code));
		$this->nieuw();
	}
	
	public function read(){
		$this->column_arr 	= array('*');
		$this->table_arr 	= array('menu m');
		$this->sort_arr 	= array('m.menu_code');
		$this->lijst 		= $this->lezen();
	}
	
	public function readLine($id){
		$this->column_arr 	= array('*');
		$this->table_arr 	= array('menu m');
		$this->where_arr 	= array('m.id' => $id);
		$this->lijst 		= $this->lezen();
	}
	
	public function update(){
		$this->id 			= $_POST["id"];
		$this->naam 		= $_POST["naam"];
		$this->menu_code 	= $_POST["menu_code"];
		$this->table_string = get_class($this);
		$this->set_arr		= array('naam' => $this->naam, 'menu_code' => $this->menu_code);
		$this->where_arr	= array('id' => $this->id);
		$this->wijzigen();
	}
	
	public function delete(){
		$this->menu_array 	= $_POST["id"];
		$arr 				= $this->menu_array;
		$this->table_arr 	= array(get_class($this));
		foreach($arr as $value) {
			$verwijderstring 	= " id = " . $value;
			$this->where_string = $verwijderstring;
			$this->verwijderen();
		}
	}
}
?>
<?php
class gerecht extends tmap {

	public $id;
	public $naam;
	public $code;
	public $basisprijs;
	public $omschrijving;
	public $image;
	public $menu_id;


	public $gerecht_array = array();
	public $lijst;

	public function create(){
		$this->naam 				= $_POST["naam"];
		$this->code 				= $_POST["code"];
		$dirty_basisprijs			= $_POST["basisprijs"];
		$this->basisprijs 			= number_format($dirty_basisprijs, 2, '.','');
		$this->omschrijving 		= $_POST["omschrijving"];
		$this->menu_id				= $_POST["menu_id"];
		$this->image 				= $_POST["image"];
		$this->table_string 		= get_class($this);
		$this->column_arr 			= array('id', 'menu_id', 'naam', 'code' ,'basisprijs' ,'omschrijving', 'image');
		$this->value_arr 			= array(NULL, $this->menu_id, $this->naam, $this->code, $this->basisprijs, $this->omschrijving, $this->image );
		parent::nieuw();
	}

	public function read(){
		$this->column_arr 		= array('g.id', 'g.menu_id', 'g.naam', 'g.code', 'g.omschrijving', 'g.basisprijs', 'g.image', 'm.naam menunaam');
		$this->table_arr 		= array('gerecht g', 'menu m');
		$this->where_arr 		= array('g.menu_id' => 'm.id');
		$this->sort_arr 		= array('g.code');
		$this->lijst 			= parent::lezen();
	}

	public function readLine($id){
		$this->column_arr 		= array('*');
		$this->table_arr 		= array('gerecht g');
		$this->where_arr 		= array('g.id' => $id);
		$this->lijst 			= parent::lezen();
	}

	public function update(){
		$this->id				= $_POST["id"];
		$this->naam 			= $_POST["naam"];
		$this->code 			= $_POST["code"];
		$dirty_basisprijs			= $_POST["basisprijs"];
		$this->basisprijs 			= number_format($dirty_basisprijs, 2, '.','');
		$this->omschrijving 	= $_POST["omschrijving"];
		$this->menu_id			= $_POST["menu_id"];
		$this->image 			= $_POST["image"];
		$this->table_string 	= get_class($this);
		$this->set_arr			= array('naam' => $this->naam, 'code' => $this->code ,'basisprijs' => $this->basisprijs, 'omschrijving' => $this->omschrijving, 'menu_id' => $this->menu_id, 'image' => $this->image);
		$this->where_arr		= array('id' => $this->id);
		parent::wijzigen();
	}

	public function delete(){
		$this->gerecht_array 	= $_POST["id"];
		$arr 					= $this->gerecht_array;
		$this->table_arr 		= array(get_class($this));
		foreach($arr as $value) {
			$verwijderstring 	= " id = " . $value;
			$this->where_string = $verwijderstring;
			parent::verwijderen();
		}
	}
}

?>
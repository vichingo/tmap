<?php

class bestanddeel extends tmap
{
	public $naam;
	public $code;
	public $prijs;
	public $voedsel_categorie_id;



	public $bestanddeel_array = array();
	public $lijst;




	public function create(){
		$this->naam = ucfirst($_POST["naam"]);
		$this->code = $_POST["code"];
		$dirty_prijs = $_POST["prijs"];
		$this->prijs = number_format($dirty_prijs, 2, '.','');
		$this->voedsel_categorie_id = $_POST["voedsel_categorie_id"];
		$this->table_string = get_class($this);
		$this->column_arr = array('id', 'naam', 'code' ,'prijs' ,'voedsel_categorie_id');
		$this->value_arr = array(NULL, $this->naam, $this->code, $this->prijs, $this->voedsel_categorie_id );
		$this->nieuw();
	}

	public function read(){
		$this->column_arr = array('bd.id', 'bd.naam bestanddeel', 'bd.code', 'bd.prijs', 'bd.voedsel_categorie_id','vc.naam categorie');
		$this->table_arr = array('bestanddeel bd', 'voedsel_categorie vc'); //bestanddeel bd, voedsel_categorie vc
		$this->where_arr = array('bd.voedsel_categorie_id' => 'vc.id');
		$this->sort_arr = array('bd.naam');
		$this->lijst = $this->lezen();
	}

	public function readLine($id){
		$this->column_arr = array('bd.id', 'bd.naam bestanddeel', 'bd.code', 'bd.prijs', 'bd.voedsel_categorie_id','vc.naam categorie');
		$this->table_arr = array('bestanddeel bd', 'voedsel_categorie vc'); //bestanddeel bd, voedsel_categorie vc
		$this->where_arr = array('bd.voedsel_categorie_id' => 'vc.id', 'bd.id' => $id);
		$this->lijst = $this->lezen();
	}

	public function update(){
		$this->id = $_POST["id"];
		$this->naam = ucfirst($_POST["naam"]);
		$this->code = $_POST["code"];
		$dirty_prijs = $_POST["prijs"];
		$this->prijs = number_format($dirty_prijs, 2, '.','');
		$this->voedsel_categorie_id = $_POST["voedsel_categorie_id"];
		$this->table_string = get_class($this);
		$this->set_arr	= array('naam' => $this->naam, 'code' => $this->code ,'prijs' => $this->prijs ,'voedsel_categorie_id' => $this->voedsel_categorie_id);
		$this->where_arr	= array('id' => $this->id);
		$this->wijzigen();
	}

	public function delete(){
		$this->bestanddeel_array = $_POST["id"];
		$arr = $this->bestanddeel_array;
		$this->table_arr = array(get_class($this));
		foreach($arr as $value) {
			$verwijderstring = " id = " . $value;
			$this->where_string = $verwijderstring;
			$this->verwijderen();
		}
	}
}




//		echo "<pre>";
//			var_dump($arr);
//		echo "</pre>";
?>
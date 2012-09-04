<?php

class klant extends tmap {


	public $achternaam;
	public $voornaam;
	public $straat;
	public $straat_nummer;
	public $nummer_bus;
	public $lokatie_id;
	public $tel_vast;
	public $tel_gsm;
	public $email;
	public $wachtwoord;
	public $aanmaakdatum;
	public $geblokkeerd;
	public $promotie;


	public function read(){
		$this->table_arr		= array(get_class($this));
		$this->column_arr		= array('*');
		$this->sort_arr			= array('achternaam');
		$this->lijst = parent::lezen();
	}

	public function readLine($referentie){
		$this->column_arr 		= array('*');
		$this->table_arr 		= array('klant k');
		$this->where_arr		= array('k.id' => $referentie);
		$this->lijst 			= parent::lezen();
	}


	// speciale methodes
	public function updateNaRegistratie($klant_id){
		$velden = $_POST;
		$set_velden = array();

		$this->table_arr	= array("klant");
		foreach($velden as $key=>$value){
			$set_velden[$key] = $value;
		}
		$this->set_arr		= $set_velden;
		$this->where_arr	= array('id'=> $klant_id );
		$this->wijzigen();
		echo $this->u_Query;
	}
}
?>
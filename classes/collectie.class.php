<?php

class collectie extends tmap {

	public function klantBestellingen($klant_id)
	{
		$this->table_arr 	= array(	 'bestelling b'
										,'klant_bestelling k'
										,'klant k1');
		$this->column_arr	= array(	 'k1.id'
										,'b.besteltijd'
										,'b.levertijd'
										,'b.bestelling_nummer'
										,'b.leverwijze_id'
										,'b.totaal_prijs'
										);
		$this->where_arr	= array (	 'k1.id'=>'k.klant_id'
										,'b.id'=>'k.bestelling_id'
										);
		$this->group_arr	= array (	 'b.id'
										);
		$this->having_arr	= array (	 'k1.id'=>$klant_id
										);
		//$this->lezen();
		$this->lijst		= $this->lezen();
	}

}
?>
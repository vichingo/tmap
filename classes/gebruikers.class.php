<?php
class gebruikers extends tmap {
	
	public $id;
	public $naam;
	public $login_naam;
	public $login_wachtwoord;
	public $sesam;
	
	
	public $lijst;

	public function create(){
		$this->naam 			= $_POST['naam'];
		$this->login_naam 		= $_POST['login_naam'];
		$this->login_wachtwoord = $_POST['login_wachtwoord'];
		
		$this->table_arr		= array(get_class($this));
		$this->column_arr		= array('id','naam','login_naam','login_wachtwoord', 'sesam');
		$this->value_arr		= array(NULL,
										$this->naam ,
										$this->login_naam,
										hash('sha1', $this->login_wachtwoord),
										$this->login_wachtwoord);
		parent::nieuw();
	}
	
	public function read(){
		
		/*
		 * mysql_query('select * from users where username = "' .
		 * 	$_POST['username'] . '" and password = "' .
		 * 	md5($_POST['password'] . '"'));
		 */
				
		$this->table_arr		= array(get_class($this));
		$this->column_arr		= array('*');
		$this->sort_arr			= array('login_naam');
		$this->lijst = parent::lezen();
	}
	
	public function readLine($id){
		$this->column_arr		= array('*');
		$this->table_arr 		= array('gebruikers gbr');
		$this->where_arr 		= array('gbr.id' => $id);
		$this->lijst = $this->lezen();
	}
	
	public function update(){
		$this->id						= $_POST["id"];
		$this->naam						= $_POST["naam"];
		$this->login_naam 				= $_POST['login_naam'];
		$this->login_wachtwoord 			= $_POST['login_wachtwoord'];
		$this->table_string = get_class($this);
		$this->set_arr		= array('naam' => $this->naam,
									'login_naam'=> $this->login_naam,
									'login_wachtwoord' => hash('sha1', $this->login_wachtwoord),
									'sesam' => $this->login_wachtwoord);
		$this->where_arr	= array('id' => $this->id);
		$this->wijzigen();
	}
	
	public function delete(){
		$arr 	= $_POST["id"];
		$this->table_arr 					= array(get_class($this));
		foreach($arr as $value) {
			$verwijderstring 				= " id = " . $value;
			$this->where_string 			= $verwijderstring;
			parent::verwijderen();
		}
	}
}
?>
<?php

class tmap extends db {


	public $user 			= "tmap_admin";
	public $pass			= "milo";
	public $dbname			= "tmap";

	public $scp_arr 		= array();

	public $del_array = array();
	public $lijst;
	public $conn;


	private function get_subclass_vars(){
		$subclass_properties_arr = array();
		$obj_vars = get_object_vars($this);
		foreach($obj_vars as $key=>$value){
			if(!property_exists(get_parent_class($this), $key)){
				$subclass_properties_arr[$key] = $_POST[$key];
				if ($_POST[$key] == '' ){
					$subclass_properties_arr[$key] = $value;
				}
			}
		}

			echo '<pre>';
				var_dump($subclass_properties_arr);
			echo '</pre>';
		$this->scp_arr = $subclass_properties_arr;
		return;
	}

	public function create(){
		$this->get_subclass_vars();
		$len = count($this->scp_arr);
		$c_column_arr = array();
		array_push($c_column_arr, 'id');
		$c_values_arr = array();
		array_push($c_values_arr, NULL);
		foreach($this->scp_arr AS $key=>$value){
			array_push($c_column_arr, $key);
			array_push($c_values_arr, $value);
		}

		$this->table_string = get_class($this);
		$this->column_arr = $c_column_arr;
		$this->value_arr = $c_values_arr;
		$this->nieuw();
	}

	public function update($wherefield, $wherevalue){
		$this->get_subclass_vars();
		$len = count($this->scp_arr);
		$c_set_arr = array();
		foreach($this->scp_arr AS $key=>$value){
			$c_set_arr[$key] = $value;
		}

		$this->table_string	= get_class($this);
		$this->set_arr 		= $c_set_arr;
		$this->where_arr	= array($wherefield => $wherevalue);
		$this->wijzigen();
	}

	public function delete($idArr){
		$this->del_array = $idArr;
		$arr = $this->del_array;
//		echo '<pre>';
//				var_dump($idArr);
//		echo '</pre>';
		$this->table_arr = array(get_class($this));
		foreach($arr as $value) {
			$verwijderstring = " id = " . $value;
			$this->where_string = $verwijderstring;
			$this->verwijderen();
		}
	}

	public function escapeString($string){
		$str = mysqli_real_escape_string($this->conn, $string);
		return $str;
	}

}
?>
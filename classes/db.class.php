<?php
class db
{
	private $host 			= "localhost";
	private $b_host			= "192.168.1.37";
	public  $user			= "root";
	public 	$pass			= "";
	public 	$dbname			= "tmap";
	private $con 			= FALSE;
	public  $conn 			= '';
	private $selected_db 	= '';

	private $c_resultaat 	= NULL;
	private $r_resultaat 	= NULL;

	private $r_arr 			= array();

	private $u_resultaat 	= NULL;
	private $d_resultaat 	= NULL;


	/*
	 * Publieke eigenschappen
	 *
	 * voor lange queries gebuik ik een array, voor de korte een string
	 *
	 */

	public $pagingSize		= NULL;

	public $full_query_string	= NULL;

	public $table_arr 		= array();
	public $table_string 	= NULL;

	public $column_arr 		= array();
	public $column_string 	= NULL;

	public $value_arr 		= array();
	public $value_string 	= NULL;

	public $set_arr 		= array();
	public $set_string 		= NULL;

	public $where_arr 		= array();
	public $where_string 	= NULL;

	public $group_arr 		= array();
	public $group_string 	= NULL;

	public $sort_arr 		= array();
	public $sort_string 	= NULL;

	public $having_arr		= array();
	public $having_string	= NULL;

	public $against_arr 	= array();
	public $against_string 	= NULL;

	public $against_alias 	= NULL;

	public $aantalRijen 	= 0;
	public $aantalKolommen 	= 0;

	public $kolomNamen 		= array();

	public $c_Query 		= NULL;
	public $r_Query 		= NULL;
	public $u_Query 		= NULL;
	public $d_Query 		= NULL;

	public $last_id;

	function __construct()
	{
		if(!$this->con)
		{
			// verander host naar b_host @home!!!
			$mijnconn = mysqli_connect($this->host, $this->user, $this->pass, $this->dbname);
			if ($mijnconn) {
				$this->conn = $mijnconn;
				$select_db = mysqli_select_db($mijnconn, $this->dbname);
				if ($select_db) {
					$this->con = true;
					$this->selected_db = $select_db;
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return true;
		}
	}

	/*
	 * Destruct is niet nodig
	 *
	 * function __destruct()
	 {
		if($this->con)
		{
		if(mysqli_close($this->conn))
		{
		$this->con = false;
		return true;
		} else
		{
		return false;
		}
		}
		}*/

	private function addTables( $table_arr ) {
		$tables = '';
		$aantalTabellen = count($table_arr);
		$i=1;
		foreach( $table_arr as $key=>$value ) {
			if ($i > 1){
				$tables	.= ", " . $value;
			} else {
				$tables .= $value;
			}
			$i++;
		}
		return $tables;
	}
	private function addColumns( $column_arr ) {
		$columns = '';
		$aantalKolommen = count($column_arr);
		$i=1;
		foreach( $column_arr as $value ) {
			if ($i > 1){
				$columns .= ", ". $value;
			} else {
				$columns .= $value;
			}
			$i++;
		}
		return $columns;
	}
	private function addValues( $value_arr ) {
		$values = ' ';
		$aantalWaarden = count($value_arr);
		$i=1;
		foreach( $value_arr as $value ) {
			if ($i > 1){
				$values .= ", '". mysqli_real_escape_string($this->conn,$value). "'";
			} else {
				$values .= "'". mysqli_real_escape_string($this->conn,$value) . "'";
			}
			$i++;
		}
		$values .= '';
		return $values;
	}
	private function addSets( $set_arr ) {
		$sets = ' ';
		$aantalSets = count($set_arr);
		$i=1;
		foreach( $set_arr as $key=>$value ) {
			if ($i > 1){
				$sets .= ", " . $key . " = '". mysqli_real_escape_string($this->conn,$value). "'";
			} else {
				$sets .= $key . " = '". mysqli_real_escape_string($this->conn,$value) . "'";
			}
			$i++;
		}
		return $sets;
	}

	private function addHaving( $having_arr ) {
		$having = '';
		$aantalKolommen = count($having_arr);
		$i=1;
		foreach( $having_arr as $key=>$value) {
			if ($i > 1){
				$having .= " AND " . $key . " = " . mysqli_real_escape_string($this->conn,$value);
			} else {
				$having .= $key . " = " . mysqli_real_escape_string($this->conn,$value);
			}
			$i++;
		}
		return $having;
	}

	private function addWhere( $where_arr ) {
		$where = '';
		$aantalKolommen = count($where_arr);
		$i=1;
		foreach( $where_arr as $key=>$value) {
			// De match waarde van de sleutel moet ALTIJD!! in uppercase
			if ($key == 'MATCH'){
				$where	.= $key . " (";
				if (is_array($value)){
					$matchvelden = $value;
					$aantal = 1;
					foreach($matchvelden as $veld){
						if ($aantal > 1){
							$where .= ", " . $veld;
						} else {
							$where .= $veld;
						}
						$aantal++;
					}

				}
				$where .= ")";
			} else {
				if ($i > 1){
					$where .= " AND " . $key . " = " . mysqli_real_escape_string($this->conn,$value);
				} else {
					$where .= $key . " = " . mysqli_real_escape_string($this->conn,$value);
				}
				$i++;
			}

		}
		return $where;
	}
	private function addGroup( $group_arr ) {
		$group = '';
		$aantalKolommen = count($group_arr);
		$i=1;
		foreach( $group_arr as $key=>$value) {
			if ($i > 1){
				$group .= ", " . mysqli_real_escape_string($this->conn,$value);
			} else {
				$group .= mysqli_real_escape_string($this->conn,$value);
			}
			$i++;
		}
		return $group;
	}
	/*
	 * sort array syntax: array( 'tabelnaam [tabelnaam alias]')
	 */
	private function addSort( $sort_arr ) {
		$sort = ' ';
		$aantalKolommen = count($sort_arr);
		$i=1;
		foreach( $sort_arr as $value) {
			if ($i > 1){
				$sort .= ', ' .$value;
			} else {
				$sort .= $value;
			}
			$i++;
		}
		return $sort;
	}
	private function addAgainst( $against_arr ) {
		$against = '';
		foreach($against_arr as $key=>$value){
			$zoekstring = $key;
			$search_modifier = $value;
			$against .= " ('" . $zoekstring . "' " . $search_modifier . ")";
		}

		return $against;
	}
	//builders

	/**
	 * De C(reate) in CRUD
	 *
	 * @param string $tabelnaam naam van de tabel waarin het nieuwe item moet worden toegevoegd.
	 * @return string
	 */
	public function nieuw(){

		/*
		 * INSERT INTO tbl_name (a,b,c) VALUES(1,2,3)
		 */
		$kolom_arr		= $this->column_arr;
		$kolom_lijn 	= $this->column_string;

		$tabel_arr		= $this->table_arr;
		$tabel_lijn		= $this->table_string;

		$waarde_arr		= $this->value_arr;
		$waarde_lijn	= $this->value_string;

		$createQuery	 = "INSERT INTO ";
		$createQuery	.= $tabel_arr? $this->addColumns($tabel_arr) . ' ': $tabel_lijn . ' ';
		$createQuery	.= "(";
		$createQuery	.= $kolom_arr? $this->addColumns($kolom_arr) . ' ': $kolom_lijn . ' ';
		$createQuery	.= ") VALUES (";
		$createQuery	.= $waarde_arr? $this->addValues($waarde_arr) . ' ': $waarde_lijn . ' ';
		$createQuery	.= ")";

		$this->c_Query 	= $createQuery;
		$resultaat 		= mysqli_query($this->conn,$createQuery);
		$this->last_id 	= mysqli_insert_id($this->conn);


		if($resultaat){
			return $resultaat;
		} else {
			return false;
		}
	}


	/**
	 * De R(ead) in CRUD
	 *
	 * @param bool $paging voor sortering via order by toe
	 * @return string
	 */
	public function lezen($paging = FALSE, $having = FALSE)
	{
		//				SELECT
		//		    [ALL | DISTINCT | DISTINCTROW ]
		//		      [HIGH_PRIORITY]
		//		      [STRAIGHT_JOIN]
		//		      [SQL_SMALL_RESULT] [SQL_BIG_RESULT] [SQL_BUFFER_RESULT]
		//		      [SQL_CACHE | SQL_NO_CACHE] [SQL_CALC_FOUND_ROWS]
		//		    select_expr [, select_expr ...]
		//		    [FROM table_references
		//		    [WHERE where_condition]
		//		    [GROUP BY {col_name | expr | position}
		//		      [ASC | DESC], ... [WITH ROLLUP]]
		//		    [HAVING where_condition]
		//		    [ORDER BY {col_name | expr | position}
		//		      [ASC | DESC], ...]
		//		    [LIMIT {[offset,] row_count | row_count OFFSET offset}]
		//		    [PROCEDURE procedure_name(argument_list)]
		//		    [INTO OUTFILE 'file_name'
		//		        [CHARACTER SET charset_name]
		//		        export_options
		//		      | INTO DUMPFILE 'file_name'
		//		      | INTO var_name [, var_name]]
		//		    [FOR UPDATE | LOCK IN SHARE MODE]]
		$volledige_query_string	= $this->full_query_string;

		$kolom_arr		= $this->column_arr;
		$kolom_lijn 	= $this->column_string;

		$tabel_arr		= $this->table_arr;
		$tabel_lijn		= $this->table_string;

		$waar_arr		= $this->where_arr;
		$waar_lijn		= $this->where_string;

		$groep_arr		= $this->group_arr;
		$groep_lijn		= $this->group_string;

		$sorteer_arr	= $this->sort_arr;
		$sorteer_lijn	= $this->sort_string;

		$tegen_arr		= $this->against_arr;
		$tegen_lijn		= $this->against_string;

		// opbouw query
		$readQuery 	 = "SELECT ";
		$readQuery	.= $kolom_arr? $this->addColumns($kolom_arr) . ' ': $kolom_lijn . ' ';
		$readQuery  .= "FROM ";
		$readQuery	.= $tabel_arr? $this->addTables($tabel_arr) . ' ': $tabel_lijn . ' ';
		/*
		 * Maken we gebruik van een where clausule?
		 */
		if ($waar_arr || $waar_lijn){

			$readQuery	.= "WHERE ";
			$readQuery	.= $waar_arr? $this->addWhere($waar_arr) . ' ': $waar_lijn . ' ';
		}
		/*
		 * Maken we gebruik van sorting via de database?
		 */

		// # If you use GROUP BY, output rows are sorted according to the GROUP BY columns as if you had an
		// ORDER BY for the same columns. To avoid the overhead of sorting that GROUP BY produces, add ORDER BY NULL:
		//
		// SELECT a, COUNT(b) FROM test_table GROUP BY a ORDER BY NULL;
		//
		// # MySQL extends the GROUP BY clause so that you can also specify ASC and DESC
		// after columns named in the clause:
		//
		// SELECT a, COUNT(b) FROM test_table GROUP BY a DESC;
		//
		// # MySQL extends the use of GROUP BY to allow selecting fields that
		// are not mentioned in the GROUP BY clause.
		// If you are not getting the results that you expect from your query,
		// please read the description of GROUP BY found in.

		$hebben_arr 	= $this->having_arr;
		$hebben_lijn	= $this->having_string;

		if (!empty($groep_arr) || !empty($groep_lijn)){

			$readQuery	.= 'GROUP BY ';
			$readQuery	.= $groep_arr? $this->addGroup($groep_arr) . ' ': $groep_lijn . ' ';
		}

		if ($having){
			$readQuery	.= 'HAVING ';
			$readQuery	.= $hebben_arr? $this->addHaving($hebben_arr) . ' ': $hebben_lijn . ' ';
		}


		if (!empty($sorteer_arr) || !empty($sorteer_lijn)){

			$readQuery	.= 'ORDER BY ';
			$readQuery	.= $sorteer_arr? $this->addSort($sorteer_arr) . ' ': $sorteer_lijn . ' ';
		}

		if (!empty($tegen_arr) || !empty($tegen_lijn)){

			$readQuery	.= 'AGAINST ';
			if($tegen_arr){
				$readQuery .= $this->addAgainst($tegen_arr) . ' ';
				if($against_alias) {
					$readQuery .= 'AS ' . $against_alias . ' ';
				}
			} else {
				$readQuery .= $tegen_lijn . ' ';
			}
		}


		/*
		 * #Do not use HAVING for items that should be in the WHERE clause. For example, do not write the following:
		 * SELECT col_name FROM tbl_name HAVING col_name > 0;
		 * Write this instead:
		 * SELECT col_name FROM tbl_name WHERE col_name > 0;
		 * #The HAVING clause can refer to aggregate functions, which the WHERE clause cannot:
		 * SELECT user, MAX(salary) FROM users
		 *   GROUP BY user HAVING MAX(salary) > 10;
		 *
		 */

		if($paging){

			$start = ($_REQUEST['start'] != '') ? $_REQUEST['start'] : 0;
			$limit = ($_REQUEST['limit'] != '') ? $_REQUEST['limit'] : $this->pagingSize;

			$readQuery	.= $tel_query . " LIMIT " . $start . ", " . $limit;
		}

		if($volledige_query_string)
		{
			$this->r_Query = $volledige_query_string;
			$resultaat = mysqli_query($this->conn, $volledige_query_string);
		} else {
			$this->r_Query = $readQuery;
			$resultaat = mysqli_query($this->conn, $readQuery);
		}

		$this->last_id 	= mysqli_insert_id($this->conn);

		if(!$resultaat){
			echo mysqli_error($this->conn) . " en " . mysqli_errno($this->conn);
			return false;
		} else {
			// maak kolom en rij count
			$this->aantalKolommen	= mysqli_num_fields($resultaat);
			$this->aantalRijen		= mysqli_num_rows($resultaat);

			for ($i = 0; $i < $this->aantalKolommen; $i++){
				$meta = mysqli_fetch_field($resultaat);
				array_push($this->kolomNamen, $meta->name);
			}
			while($row=mysqli_fetch_object($resultaat)){ //mysqli_fetch_assoc
				array_push($this->r_arr, $row);
			}
			return $this->r_arr;
		}
	}


	/**
	 *
	 * De U(pdate) in CRUD
	 * @return unknown_type
	 */
	public function wijzigen(){
		// where is altijd true
		//UPDATE tutorials_tbl
		//SET tutorial_title='Learning JAVA'
		//WHERE tutorial_id=3;


		$volledige_query_string	= $this->full_query_string;

		$tabel_arr		= $this->table_arr;
		$tabel_lijn		= $this->table_string;

		$stel_arr		=$this->set_arr;
		$stel_lijn		=$this->set_string;

		$updateQuery	 = "UPDATE ";
		$updateQuery	.= $tabel_arr? $this->addTables($tabel_arr) . ' ': $tabel_lijn . ' ';
		$updateQuery	.= "SET ";
		$updateQuery	.= $stel_arr? $this->addSets($stel_arr) . ' ': $stel_lijn . ' ';

		$waar_arr		= $this->where_arr;
		$waar_lijn		= $this->where_string;

		$updateQuery	.= "WHERE ";
		$updateQuery	.= $waar_arr? $this->addWhere($waar_arr) . ' ': $waar_lijn . ' ';


		if($volledige_query_string)
		{
			$this->u_Query = $volledige_query_string;
			$resultaat = mysqli_query($this->conn, $volledige_query_string);
		} else {
			$this->u_Query = $updateQuery;
			$resultaat = mysqli_query($this->conn, $updateQuery);
		}



		if($resultaat){
			return $resultaat;
		} else {
			return false;
		}
	}

	/**
	 *
	 * De D(elete) in CRUD
	 *
	 * @param $innerjoin default op FALSE
	 * @return string
	 */
	public function verwijderen($innerjoin = FALSE){
		/*
		 *
		 * DELETE db1.a1, db2.a2
		 * FROM db1.t1 AS a1
		 * INNER JOIN db2.t2 AS a2
		 * WHERE a1.id=a2.id;
		 *
		 */
		$kolom_arr	= $this->column_arr;
		$kolom_lijn = $this->column_string;

		$tabel_arr	= $this->table_arr;
		$tabel_lijn	= $this->table_string;

		$waar_arr	= $this->where_arr;
		$waar_lijn	= $this->where_string;

		$deleteQuery	 = "DELETE ";

		if ($kolom_arr){
			$deleteQuery	.= $kolom_arr? $this->addColumns($kolom_arr) . ' ': ' ';
		} else if ($kolom_lijn){
			$deleteQuery	.= $kolom_lijn . ' ';
		} else {
			$deleteQuery	.='';
		}
		$deleteQuery  	.= "FROM ";
		$deleteQuery	.= $tabel_arr? $this->addTables($tabel_arr) . ' ': $tabel_lijn . ' ';

		//INNERJOIN Next om te ontwerpen


		$deleteQuery	.= "WHERE ";
		$deleteQuery	.= $waar_arr? $this->addWhere($waar_arr) . ' ': $waar_lijn . ' ';

		$this->d_Query = $deleteQuery;
		$resultaat = mysqli_query($this->conn, $deleteQuery);

		if($resultaat){
			return $resultaat;
		} else {
			return false;
		}
	}


	public function makeJson(){

		$callback = $_REQUEST['callback'];

		empty($this->r_arr) ? $this->lezen() : '';

			$obj = new stdClass();
			$obj->success = true;
			$obj->results = count($this->r_arr);
			$obj->records = $this->r_arr;
			if($callback){
				return $callback ."(". json_encode($obj).");";
			} else {
				return json_encode($obj);
			}
	}

	public function showQuery($query){
		echo "<pre>";
		echo $query;
		echo "</pre>";
	}
}
?>
<?php
/**
 *
 * @author milo
 * @version 1.0
 *
 * Class om algemene zaken mee te regelen
 *
 */
class tardis {


	/**
	 *
	 * @param $lengte pin lengte
	 * @return string
	 */
	static function maakPin($lengte = 5) {
		// maakt een willekeurig afanumerieke string met een voorafingestelde lengte
		$aZ09 = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
		$out ='';
		for($c=0;$c < $lengte;$c++) {
			$out .= $aZ09[mt_rand(0,count($aZ09)-1)];
		}
		return $out;
	}


	public function array_to_object($array = array())  {
		if (!empty($array)) {
			$obj = false;
			foreach ($array as $key => $val) {
				$obj -> {$key} = $val;
			}
			return $obj;
		}
		return false;
	}

	static function array_search_key($needle_key, $array) {
		$arr = array();
		foreach($array AS $key=>$value){
			if(substr($key, 0, 5) == $needle_key){
				if(is_array($value)){
					foreach ($value AS $waarde) {
						$uitkomst = $waarde;
					}
				}
				//array_push($arr, array($key,$waarde));
				$arr[$key] = $waarde;
			}
		}
		return $arr;
	}


	static function isFloat($n){
		return ( $n == strval(floatval($n)) )? floatval($n) : false;
	}


	static function afstand($lat1, $lon1, $lat2, $lon2, $unit) {

//	  	$distance = (3958*3.1415926*sqrt(($lat2-$lat1)*($lat2-$lat1) + cos($lat2/57.29578)*cos($lat1/57.29578)*($lon2-$lon1)*($lon2-$lon1))/180);
//
//	  	return ceil($distance);

		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") {
			return ceil($miles * 1.609344);
		} else if ($unit == "N") {
			return ceil($miles * 0.868976242);
		} else {
			return ceil($miles);
		}
	}
}
?>
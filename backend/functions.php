<?php
/* This file to enable Parsing Data From XML To Array */

function objectsIntoArray($arrObjData, $arrSkipIndices = array()){
	$arrData = array();
	// if input is object, convert into array
	if (is_object($arrObjData)) {
		$arrObjData = get_object_vars($arrObjData);
	}

	if (is_array($arrObjData)) {
		foreach ($arrObjData as $index => $value) {
			if (is_object($value) || is_array($value)) {
				$value = objectsIntoArray($value, $arrSkipIndices); // recursive call
			}
			if (in_array($index, $arrSkipIndices)) {
				continue;
			}
			$arrData[$index] = $value;
		}
	}
	return $arrData;
}

// untuk tyoe request POST
function input_filter($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// untuk input data GET
function get_filter($data){
	$ft = filter_input(INPUT_GET, $data, FILTER_SANITIZE_ENCODED);
	return $ft;
}

function get_variabel_filter($get_key){
	$search_html = filter_input(INPUT_GET, $get_key, FILTER_SANITIZE_SPECIAL_CHARS);
	return $search_html;
}


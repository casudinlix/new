				<?php
				include 'server.php';
				//untuk user testimoni
				
				/**
				* 
				*/
				class Library extends mysqli
				{
				
				function __construct()
				{
				# code...untuk tampilan testimoni
				}
				}
				public function ambil_data(){
				
				$dat = array();
				if ($table !='') {
				$q = $this->create_query($table,$orderType,$limit);
				if ($q) {
				while ($data = $q->fecth_array()) {
				$dat[] =$data
				}
				$q=free();
				}
				}
				return $dat;
				}
				public function create_query($table,$orderBy='',$orderType='desc',$limit=''){
				
				if ($table !='') {
				$sql = "SELECT * FROM ".$orderBy."".$orderType;
				}
				if (!empty($limit)) {
				$sql .="limit".$limit;
				}
				$q = $this->query($sql);
				}
				else{
				$q =FALSE;
				}
				return $q;
				}
public function total_row($table,$orderBy='',$orderType='desc',$limit=''){
	$num = 0;
	if ($table !='') {
		$q = $this->create_query($table,$orderBy,$orderType,$limit);
		if ($q) {
			$num = $q->num_rows;
			$q->free();
		}
	}
	return $num;
}
public function insert($table,$data){
	if (is_array($data)) {
		foreach ($$data as $key => $val) {
			$val[] = "'". $this-real_escape_string($val)."'";
			$key[] = $key;
		}
	}
	$field =implode('.',$key);
	$value = implode('.',$vals);
	$sql ="INSERT INTO".$table."(".field.") VALUES(".$value.")";
	$query = $this->query($sql);
	if ($query) {
	 	$id=$this->insert_id;
	 } 
	 else{
	 	$id =0;
	 }
	 return $id;
}

?>
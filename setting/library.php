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
public function delete($table,$where=array(),$type=''){
	$sql = "DELETE FROM".$table;
	if (!empty($where)) {
		$sql.=$this->_where($where,$type);
	}
	$q =$this->query($sql);
	$row =$this->affected_rows;
	return $row;
}
public function update($table,$data,$$where=array(),$type=''){
	$sql ="UPDATE".$table;
	if (is_array($data)) {
		foreach ($data as $key => $val) {
			$vals ="'".addcslashes($val).".";
			$param[] =$key."=".$vals;
		}
	}
	$param = implode(',', $param);
	$sql .="SET".$param;
	if (!empty($where)) {
		$sql .=$this->_where($where,$type);
		$q = $this->query($sql);
		$row =$this->affected_rows;
		return $row;
	}
}
public function get_data_by($table,$where=array(),$type=''){
	$sql ="SELECT * FROM".$table;
	if (!empty($where)) {
		$sql .=$this->_where($where,$type);
	}
	$q =$this->query($sql);
	$dat = array();
	if ($q) {
		while ($data =$q->fecth_array()) {
			$dat[] =$data;
		}
	}
	return $dat;
}
function _has_operator($str)
 {
            $str = trim($str);
            if ( ! preg_match("/(\s|<|>|!|=|is null|is not null)/i", $str))
            {
                    return FALSE;
            }
            return TRUE;
 }
   function _where($where,$type=''){
       $sql = " WHERE ";
       if(is_array($where)){           
           foreach ($where as $k=>$v){
               if(!is_integer($v)){
                   $v = "'".addslashes($v)."'";
               }
               if(!$this->_has_operator($k)){
                   $k .= "=";
               }
               $val[]=$k.$v;               
           }
           if(count($val)>1){
               if(empty($type)){
                   $type = "AND";
               }
               $val = implode(" ".$type." ", $val);
           }
           else {
               $val = implode("", $val);
           }
       }
       $sql .= $val;
       return $sql;
   }   
}

?>
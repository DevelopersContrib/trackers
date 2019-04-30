<?php
class MembersData extends CI_Model {
	private $table = "members";
	private $pk = "member_id";
	private $date = null;
	

	public function checkexist($field,$value,$field2=null,$value2=null){
     $returnValue = false;
     if ($field2 && $value2){
     	$query = $this->db->query("SELECT count(*) as count FROM `$this->table` WHERE `$field` = '".$value."' AND  `$field2` = '".$value2."'");
     }else {
      $query = $this->db->query("SELECT count(*) as count FROM `$this->table` WHERE `$field` = '".$value."' ");
     }  
      if ($query->num_rows() > 0){
        foreach ($query->result() as $row)
         {
           $count =  $row->count;
         }
     }
     if ($count > 0){
        $returnValue = true;   
     }
    return $returnValue;
	}
	
	
	public function getinfo($find,$field1,$value1,$field2='',$value2=''){
	      $v = "";
	      if (($field2 != '') && ($value2 != '')){
	      	$query = $this->db->query("SELECT `$find` as val FROM `$this->table` WHERE `$field1` = '".$value1."' AND  `$field2` = '".$value2."'");
	      }else {
	      	$query = $this->db->query("SELECT `$find` as val FROM `$this->table` WHERE `$field1` = '".$value1."' ");
	      }
	      if ($query->num_rows() > 0){
	        foreach ($query->result() as $row)
	         {
	           $v =  $row->val;
	         }
	     }
	     
	    return $v;
	  }
	  
  public function getinfobyid($field,$id){
     $returnValue = ""; 
     $query = $this->db->query("SELECT `$field` as val from $this->table where $this->pk=$id");
      if ($query->num_rows() > 0){
        foreach ($query->result() as $row)
         {
           $returnValue =  $row->val;
         }
       }
      return $returnValue;
    }
	
  function getbyattribute($key,$value,$key2=null, $value2=null){
  	if (($key2) && ($value2)){
  		 return  $this->db->query("SELECT * FROM $this->table where `$key` = '".$value."' AND `$key2` = '".$value2."'");
  	}else {
  		return  $this->db->query("SELECT * FROM $this->table where `$key` = '".$value."'");
  	  
  	}
  }
  
  
   function getcountbyattribute($key,$value,$key2=null,$value2=null){
  	if ($key2 && $value2){
  		  $query = $this->db->query("Select count(*) as total from $this->table where `$key` = '".$value."' AND `$key2` = '".$value2."'");
  	}  else {
   	   $query = $this->db->query("Select count(*) as total from $this->table where `$key` = '".$value."' ");
  	}
     if ($query->num_rows() > 0){
        foreach ($query->result() as $row)
         {
           $total =  $row->total;
         }
      }
      return $total;
  }
  
  function update($id,$data){
     $query = $this->db->query("Select * from `$this->table` where $this->pk = '$id'"); 
	 if ($query->num_rows() > 0){
	     $this->db->where($this->pk, $id);
	     $this->db->update($this->table, $data);
		 return $id;
	 } else {
	 	if ($this->date){
	 	  $this->db->set($this->date, 'NOW()', FALSE);
	 	}
	 	$this->db->insert($this->table, $data);
	 	return $this->db->insert_id();
	 }
   }
  
   
	function delete($field,$value){
		return $this->db->delete($this->table, array($field => $value)); 
	}
 }
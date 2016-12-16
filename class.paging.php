<?php

class paginate{
     private $db;
 	 private $records_per_page;
     private $query;
     private $select;
     private $sort_by;
     private $total_no_of_records = null;
     
     function __construct(PDO $DB_con,$select,$sort_by=null,$records_per_page=10){
         $this->db = $DB_con;
         $this->records_per_page = $records_per_page;
         $this->select = $select;
         $this->sort_by = $sort_by;
         
         $this->query = $this->select;
         
         if ($sort_by != null) {
         	$this->query .= " order by ".$sort_by;
         }
     }
 
     
     public function total() {
     	if ($this->total_no_of_records == null) {
	     	$stmt = $this->db->prepare($this->query);
	     	$stmt->execute();
	     	$this->total_no_of_records = $stmt->rowCount();
     	}
     	
     	return $this->total_no_of_records;
     }
     
     public function currentPage(){
     	$current_page = isset($_GET["page"])?$_GET["page"]:1;
     	return $current_page;
     }
     
     public function firstItem(){
     		return $this->records_per_page * ($this->currentPage() - 1) + 1;
     }
     
     public function lastItem(){
     	return $this->records_per_page * ($this->currentPage()) > $this->total() ? $this->total() : $this->records_per_page * ($this->currentPage());
     }
     
     public function dataRows(){

     	$stmt = $this->db->prepare($this->pagingQuery());
     	$stmt->execute();
     	
     	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
     	
     	return $rows;
     }
	 
	 public function pagingQuery() {
	
	 		$starting_position= $this->firstItem() - 1;
	        
	        $query2=$this->query." limit $starting_position,$this->records_per_page";
		       
	        return $query2;
	 }
	 
	 public function buildUrl($page){
	 	$urlParts = parse_url($_SERVER['REQUEST_URI']);
	 	$urlParams = array();
	 	if(isset($urlParts["query"]) && !empty($urlParts["query"])) {
	 		parse_str($urlParts["query"], $urlParams);
	 	}
	 	
	 	$urlParams["page"] = $page;
	 	
	 	$query = http_build_query($urlParams);
	 	
	 	return $urlParts["path"]."?".$query.(isset($urlParts["fragment"])?"#".$urlParts["fragment"]:"");
	 	
	 }
	 public function links(){
	  
	  
	        $html = "<ul class='pagination'>";
	        
	        
	        
	        
	        if($this->total() > $this->records_per_page){
	        	
	            $total_no_of_pages=ceil($this->total()/$this->records_per_page);
	            $current_page=1;
	            
	          
	            $current_page = $this->currentPage();
	            
	            if($current_page!=1){
	               $previous =$current_page-1;
	               $html .= "<li><a data-page='1' href='".$this->buildUrl(1)."'>First</a> </li>";
	               $html .= "<li><a data-page='$previous' href='".$this->buildUrl($previous)."'>Previous</a></li>";
	            }
	            
	            for($i=1;$i<=$total_no_of_pages;$i++){
		            $html .= "<li ".(($i==$current_page)?"class='active'":"")."><a  data-page='$i' href='".$this->buildUrl($i)."'>".$i."</a></li>";
	  			}
	  		 
			   if($current_page!=$total_no_of_pages){
			        
			   		$next=$current_page+1;
			        
			        $html .= "<li><a  data-page='$next' href='".$this->buildUrl($next)."'>Next</a></li>";
			        $html .= "<li><a  data-page='$total_no_of_pages' href='".$this->buildUrl($total_no_of_pages)."'>Last</a></li>";
			   }
	   		
	  		}
	  		
	  		$html .= "</ul>";
	  		
	  		return $html;
	}
}
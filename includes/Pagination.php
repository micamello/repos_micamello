<?php 
class Pagination { 

  private $totalrows; 
  private $rowsperpage; 
  private $website; 
  private $page; 
  private $sql; 
         
  public function __construct($total, $rowsperpage, $website) {         
    $this->totalrows = $total;
    $this->website = $website; 
    $this->rowsperpage = $rowsperpage; 
  } 
     
  public function setPage($page) { 
    if (!$page) { $this->page=1; } else  { $this->page = $page; } 
  } 
     
  public function getLimit() { 
    return ($this->page - 1) * $this->rowsperpage; 
  } 
      
  private function getLastPage() { 
    return ceil($this->totalrows / $this->rowsperpage); 
  } 
     
  public function showPage() { 
    $pagination = ""; 
    $lpm1 = $this->getLastPage() - 1; 
    $page = $this->page; 
    $prev = $this->page - 1; 
    $next = $this->page + 1; 
             
    $pagination = '<ul class="pagination pagineo">';     
         
    if ($this->getLastPage() > 1) { 
      if ($page > 1){                  
        $pagination .= '<li class="page-item"><a class="page-link" href="'.$this->website.'/'.$prev.'/"><<</a></li>'; 
      }    
      else{                 
        $pagination .= '<li class="page-item disabled"><a class="page-link" href="javascript:void(0);"><<</a></li>';
      } 
             
      if ($this->getLastPage() < 9) {          
        for ($counter = 1; $counter <= $this->getLastPage(); $counter++) { 
          if ($counter == $page){                 
            $pagination .= '<li class="page-item active"><a class="page-link" href="javascript:void(0);">'.$counter.'</a></li>'; 
          }    
          else{             
            $pagination .= '<li class="page-item"><a class="page-link" href="'.$this->website.'/'.$counter.'/">'.$counter.'</a></li>';
          }    
        } 
      } 
             
      elseif($this->getLastPage() >= 9){        
        if($page < 4){          
          for ($counter = 1; $counter < 5; $counter++){ 
          //for ($counter = 1; $counter < 6; $counter++){ 
            if ($counter == $page){             
              $pagination .= '<li class="page-item active"><a class="page-link" href="javascript:void(0);">'.$counter.'</a></li>'; 
            }    
            else{                 
              $pagination .= '<li class="page-item"><a class="page-link" href="'.$this->website.'/'.$counter.'/">'.$counter.'</a></li>';
            }    
          }           
          $pagination .= '<li class="page-item"><a class="page-link" href= "javascript:void(0);">...</a></li>';
          $pagination .= '<li class="page-item"><a class="page-link" href="'.$this->website.'/'.$lpm1.'/">'.$lpm1.'</a></li>';       
          $pagination .= '<li class="page-item"><a class="page-link" href="'.$this->website.'/'.$this->getLastPage().'/">'.$this->getLastPage().'</a></li>';         
        } 
        elseif($this->getLastPage() - 3 > $page && $page > 1){           
          $pagination .= '<li class="page-item"><a class="page-link" href="'.$this->website.'/1/">1</a></li>';         
          $pagination .= '<li class="page-item"><a class="page-link" href="'.$this->website.'/2/">2</a></li>';           
          $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);">...</a></li>';
          for ($counter = $page - 1; $counter <= $page + 1; $counter++){ 
            if ($counter == $page){             
              $pagination .= '<li class="page-item active"><a class="page-link" href="javascript:void(0);">'.$counter.'</a></li>'; 
            }    
            else{                 
              //$pagination .= '<li class="page-item"><a class="page-link" href="'.$this->website.'/'.$counter.'/">'.$counter.'</a></li>';
            }    
          }           
          $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);">...</a></li>';
          $pagination .= '<li class="page-item"><a class="page-link" href="'.$this->website.'/'.$lpm1.'/">'.$lpm1.'</a></li>';         
          $pagination .= '<li class="page-item"><a class="page-link" href="'.$this->website.'/'.$this->getLastPage().'/">'.$this->getLastPage().'</a></li>';         
        } 
        else{             
          $pagination .= '<li class="page-item"><a class="page-link" href="'.$this->website.'/1/">1</a></li>';         
          $pagination .= '<li class="page-item"><a class="page-link" href="'.$this->website.'/2/">2</a></li>';           
          $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);">...</a></li>';
          //for ($counter = $this->getLastPage() - 4; $counter <= $this->getLastPage(); $counter++){ 
          for ($counter = $this->getLastPage() - 3; $counter <= $this->getLastPage(); $counter++){   
            if ($counter == $page){             
                $pagination .= '<li class="page-item active"><a class="page-link" href="javascript:void(0);">'.$counter.'</a></li>'; 
            }    
            else{                 
              $pagination .= '<li class="page-item"><a class="page-link" href="'.$this->website.'/'.$counter.'/">'.$counter.'</a></li>';
            }    
          } 
        } 
      } 
      
      //if ($page < $counter - 1){          
      if ($page < $counter - 1){            
        $pagination .= '<li class="page-item"><a class="page-link" href="'.$this->website.'/'.$next.'/">>></a></li>'; 
      }    
      else{        
        $pagination .= '<li class="page-item disabled"><a class="page-link" href="javascript:void(0);">>></a></li>';             
      }
    }

    if ($this->getLastPage() == 1) {       
      $pagination .= '<ul class="pagination pagineo">';   
      $pagination .= '<li class="page-item disabled"><a class="page-link" href="javascript:void(0);"><<</a></li>';
      $pagination .= '<li class="page-item active"><a class="page-link" href="javascript:void(0);">'.$this->getLastPage().'</a></li>'; 
      $pagination .= '<li class="page-item disabled"><a class="page-link" href="javascript:void(0);">>></a></li>';   
    } 
    
    $pagination .= '</ul>';      
                     
    return $pagination; 
  } 
} 
?>
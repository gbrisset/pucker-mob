<?php 
//Top Shared Writers
    $writers_arr = $ManageDashboard->getTopShareWritesRankHeader($current_month);
    $your_rank = 0;
   if(isset($writers_arr) && $writers_arr){
    foreach ($writers_arr as $writer) {
       
       if($writer['contributor_id'] == $contributor_id ){
          break;
       }
       $your_rank++;
     } 
    }

?>
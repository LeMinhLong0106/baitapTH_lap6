<?php

function paginarion($number, $page, $additional){
    if($number > 1){		
        echo '<ul style="justify-content: center" class="pagination">';
            
            //ko nhấn được Previous khi ở trang đầu
                if($page > 1){
                    echo '<li class="page-item ">
                    <a class="page-link" href="?page='.($page-1).$additional.'">Previous</a>
                    </li>';
                }
                else{
                    echo '<li class="page-item disabled ">
                    <a class="page-link" href="?page='.($page-1).$additional.'">Previous</a>
                    </li>';
                }
            $avaPage = [1, $page-1, $page, $page+1, $number];
            $isFirst = $isLast = false;

            for ($i = 0; $i<$number; $i++){
                if(!in_array($i+1, $avaPage)){
                    if(!$isFirst && $page > 3){
                        echo '<li class="page-item">
                        <a class="page-link" href="?page='.($page-2).$additional.'">...</a>
                        </li>';
                        $isFirst = true;
                    }
                    if(!$isLast && $i > $page){
                        echo '<li class="page-item">
                        <a class="page-link" href="?page='.($page+2).$additional.'">...</a>
                        </li>';
                        $isLast = true;
                    }
                    continue;
                }
                // active trang hiện tại
                if($page == ($i+1)){
                    echo '<li class="page-item active">
                    <a class="page-link" href="#">'.($i+1).'</a>
                    </li>';
                }
                else{
                    echo '<li class="page-item">
                    <a class="page-link" href="?page='.($i+1).$additional.'">'.($i+1).'</a>
                    </li>';
                }
                
            }
            //ko nhấn đc Next khi ở cuối trang
                if($page < $number){
                    echo '<li class="page-item ">
                    <a class="page-link" href="?page='.($page+1).$additional.'">Next</a>
                    </li>';
                }
                else{
                    echo '<li class="page-item disabled ">
                    <a class="page-link" href="?page='.($page+1).$additional.'">Next</a>
                    </li>';
                }
        echo '</ul>';
        }
}
?>

					
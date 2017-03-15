<?php
class CommonUtil
{
  public static function getValue($link, $count, $curPage, $per)
  {
      $showPages = 0;
      $showEnd = 0;
      
      $pages = ceil(($count/$per));
      
      $str = '<div class="pagination pagination-centered" style="margin-top: 20px;">';
      
      if($curPage != 1){
          $str = $str.'<span><a href="'.$link.'?curPage=1">&lt;&lt;</a></span>';
      }
      if($curPage - 1 > 0){
          $str = $str.'<span><a href="'.$link.'?curPage='.($curPage-1).'">&lt;</a></span>';
      }
      
      if($pages <= 5){
          $showPages = 1;
          $showEnd = $pages;
      }else if($pages - $curPage >= 4){
          $showPages = $curPage;
          $showEnd = $curPage+4;
      }else if($pages - $curPage < 4){
          $showPages = $pages - 4;
          $showEnd = $pages;
      }
      for($i=$showPages; $i<=$showEnd; $i++){
          if($i == $curPage){
              $str = $str.'<a href="'.$link.'?curPage='.$curPage.'" style="border: 1px solid #fd4699;color: #fd4699;">'.$i.'</a>';
          }else{
              $str = $str.'<a href="'.$link.'?curPage='.$i.'">'.$i.'</a>';
          }
      }
      
      if($curPage + 1 <= $pages){
          $str = $str.'</span><span><a href="'.$link.'?curPage='.($curPage+1).'">&gt;</a></span>';
      }
      if($curPage!=$pages){
          $str = $str.'<span><a href="'.$link.'?curPage='.($pages).'">&gt;&gt;</a></span>';
      } 
      $str = $str.'</div>';
      
      return $str;
  }
}

?>
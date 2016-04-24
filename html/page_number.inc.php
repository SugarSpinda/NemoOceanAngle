<?php
  $page_count = 0;
  $items_per_page = 10;
  $max_page_btns = 7; // must be odd and >= 5

  $retval = mysql_query($sql, $conn);
  if (!$retval) { die('Could not enter data: ' . mysql_error()); }

  $total_count = mysql_num_rows($retval);
  $offset = 0;
  $page = 1;

  if (!empty($_GET['page'])) {
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    if (false === $page) {
      $page = 1;
    }
  }

  if (0 === $total_count) {
      // maybe show some error since there is nothing in your table
  } else {
     $page_count = (int)ceil($total_count / $items_per_page);
     if($page > $page_count) {
          $page = 1;
     }

    $offset = ($page - 1) * $items_per_page;

    echo '<tr><td colspan="4"><div id="pagebtn">';
    echo '<div class="pagebtnA">';

    if ($page_count <= $max_page_btns) {
      for ($i = 1; $i <= $page_count; $i++) {
        if ($i === $page) {
          echo '<a class="pagenow">'.$i.'</a>';
         } else {
          echo '<a href="'.$this_page.'?page='.$i.'">'.$i.'</a>';
        }
      }
    } else {
      $mid_btns = $max_page_btns - 2;
      $half_page_btns = (int)($max_page_btns / 2) + 1;
      if ($page <= $half_page_btns) {
        for ($i = 1; $i < $max_page_btns; $i++) {
          if ($i === $page) {
            echo '<a class="pagenow">'.$i.'</a>';
           } else {
            echo '<a href="'.$this_page.'?page='.$i.'">'.$i.'</a>';
          }
        }
        echo '...<a href="'.$this_page.'?page='.$page_count.'">'.$page_count.'</a>';
      } else if ($page >= $page_count - ($half_page_btns - 1)) {
        echo '<a href="'.$this_page.'?page=1">1</a>...';
        for ($i = $page_count - $max_page_btns + 2; $i <= $page_count; $i++) {
          if ($i === $page) {
            echo '<a class="pagenow">'.$i.'</a>';
           } else {
            echo '<a href="'.$this_page.'?page='.$i.'">'.$i.'</a>';
          }
        }
      } else {
        echo '<a href="'.$this_page.'?page=1">1</a>...';
        $half_mid_btns = (int)($mid_btns / 2);
        for ($i = $page - $half_mid_btns; $i < $page; $i++) {
            echo '<a href="'.$this_page.'?page='.$i.'">'.$i.'</a>';
        }
        echo '<a class="pagenow">'.$page.'</a>';
        for ($i = $page + 1; $i <= $page + $half_mid_btns; $i++) {
            echo '<a href="'.$this_page.'?page='.$i.'">'.$i.'</a>';
        }
        echo '...<a href="'.$this_page.'?page='.$page_count.'">'.$page_count.'</a>';
      }
    }

    echo '</div>';
    echo '</div></tr></td>';
  }
?>

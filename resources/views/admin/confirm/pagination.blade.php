<?php 
  if ($tb_konfirmasi_premi->count()>0) {
?>
    <li>
      <a href="1" aria-label="Previous" class="active" data-pageid="1">
        <span aria-hidden="true">First</span>
      </a>
    </li>

    <?php 
    $n = ceil($tb_konfirmasi_premi->total() / $tb_konfirmasi_premi->perPage());
    for ($i = 1; $i <= $n; $i++) {
    ?>
    
      <li><a href="{{$i}}" data-pageid="{{$i}}">{{$i}}</a></li>
    <?php 
      } 
    ?>
    <!--
    <li><a href=''>...</a></li>
    -->
    <li>
      <a href="{{$tb_konfirmasi_premi->lastPage()}}" aria-label="Next" data-pageid="{{$tb_konfirmasi_premi->lastPage()}}">
        <span aria-hidden="true">last</span>
      </a>
    </li>
<?php 
  } 
?>

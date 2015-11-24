<?php 
  if ($config_packages->count()>0) {
?>
    <li>
      <a href="1" aria-label="Previous" class="active" data-pageid="1">
        <span aria-hidden="true">First</span>
      </a>
    </li>

    <?php 
    $n = ceil($config_packages->total() / $config_packages->perPage());
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
      <a href="{{$config_packages->lastPage()}}" aria-label="Next" data-pageid="{{$config_packages->lastPage()}}">
        <span aria-hidden="true">last</span>
      </a>
    </li>
<?php 
  } 
?>

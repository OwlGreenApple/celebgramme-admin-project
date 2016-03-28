<?php 
	use Celebgramme\Models\User;
	use Celebgramme\Models\UserMeta;
  if ( $arr->count()==0  ) {
    echo "<tr><td colspan='5' align='center'>Data tidak ada</td></tr>";
  } else {
    //search by username
  $i=($page-1)*15 + 1;
  foreach ($arr as $data_arr) {
?>
    <tr class="row{{$data_arr->id}}">
      <td>
        {{$i}}.
      </td>
      <td align="center">
        <?php 
					$admin = User::where("fullname","=",$data_arr->admin)->first();
					if (!is_null($admin)) {
						$color = UserMeta::getMeta($admin->id,"color");
						echo "<strong><span style='color:".$color."'>".$admin->fullname."</span></strong>";
					} else {
						echo "<strong>".$admin->fullname."</strong>";
					}
				?>
      </td>
      <td align="center">
        <a href="{{url('setting/'.$data_arr->insta_username, $parameters = [], $secure = null)}}" target="_blank">{{$data_arr->insta_username}}</a>
      </td>
      <td align="center" style="width:350px!important;">
				<a href="#" class="see-update">lihat updates </a>
				<?php  
					$colorstatus = 000;
				?> 
				<ul style="display:none;" class="data-updates"> 
					<?php 
					$strings =  explode("~", substr($data_arr->description,12));
					foreach ($strings as $string){
							$pieces = explode("=", $string );	
							if (count($pieces)>1) {
					?>
					<li class="wrap"> 
						<?php 

								  if ($pieces[0]==" status ") {
										$colorstatus="";
										if ($pieces[1]==" started "){ $colorstatus="1212e8"; } else if ( ($pieces[1]==" stopped ") || ($pieces[1]==" deleted ") ) { $colorstatus="ea0000"; }
										echo "<strong>".$pieces[0].": <span style='color:#".$colorstatus."'> ".strtoupper($pieces[1])."</span></strong> ";
									}
									
									else if ($pieces[0]==" status_like ") {
										$colorstatus="";
										if ($pieces[1]==" on "){ $colorstatus="1212e8"; } else if  ($pieces[1]==" off ") { $colorstatus="ea0000"; }
										echo "<strong>".$pieces[0].": <span style='color:#".$colorstatus."'> ".strtoupper($pieces[1])."</span></strong> ";
									}

									else if ($pieces[0]==" status_comment ") {
										$colorstatus="";
										if ($pieces[1]==" on "){ $colorstatus="1212e8"; } else if  ($pieces[1]==" off ") { $colorstatus="ea0000"; }
										echo "<strong>".$pieces[0].": <span style='color:#".$colorstatus."'> ".strtoupper($pieces[1])."</span></strong> ";
									}
									
									else if ($pieces[0]==" follow_source ") {
										$colorstatus="";
										if ($pieces[1]==" hashtags "){ $colorstatus="1212e8"; } else if  ($pieces[1]==" username ") { $colorstatus="ea0000"; }
										echo "<strong>Follow Source: <span style='color:#".$colorstatus."'> ".strtoupper($pieces[1])."</span></strong> ";
									}

									else if ($pieces[0]==" activity_speed ") {
										$colorstatus="";
										if ($pieces[1]==" slow "){ $colorstatus="ea0000"; } else if  ($pieces[1]==" normal ") { $colorstatus="15ca26"; } else if  ($pieces[1]==" fast ") { $colorstatus="1212e8"; }
										echo "<strong>Activity Speed: <span style='color:#".$colorstatus."'> ".strtoupper($pieces[1])."</span></strong> ";
									}
									
									else if ($pieces[0]==" hashtags ") {
										echo "<strong>Hashtags: </strong>".str_replace("#","",$pieces[1]);
									}
									
								else {
									echo "<strong>".$pieces[0].": </strong> ".$pieces[1];
								}
						
							 
							// echo $string;
						?>
					</li>
					<?php } }?>
				</ul>
				<!-- merah =#ea0000   biru = #1212e8  hijau = #15ca26     -->
      </td>
      <td align="center" style="width:100px;">
        {{$data_arr->created}}
      </td>
    </tr>    

<?php 
    $i+=1;
  } 
  }
?>
<script>
  $(document).ready(function(){
  });

</script>		


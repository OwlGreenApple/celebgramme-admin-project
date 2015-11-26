<?php 
  if ( ($tb_ranking->count()==0) && ($username=="") ) {
    echo "<tr><td colspan='25' align='center'>Data belum di generate</td></tr>";
  } else if ( ($tb_ranking->count()==0)&&($username<>"") ) {
    //search by username
    ?>
    <tr>
      <td>
        1
      </td>
      <td style="padding-left:2px; text-align:left">
        {{$arr_rank['username']}}
      </td>
      <td style="text-align:center">
        {{$arr_rank['personal_recruit']}}
      </td>
      
      <td>
        {{$arr_rank['l_pnr_total_prev']}}
      </td>
      <td>
        {{$arr_rank['l_pnr_total_new']}}
      </td>
      <td>
        {{$arr_rank['l_pnr_aktif_new']}}
      </td>
      <td style="color:#FF0000; font-weight:bold">
        {{$arr_rank['l_pnr_total_tot']}}        
      </td>
      <td>
        {{$arr_rank['l_pnr_aktif_prev']}}
      </td>
      <td style="color:#00CC00; font-weight:bold">
        {{$arr_rank['l_pnr_aktif_tot']}}
      </td>
      
      <td>
        {{$arr_rank['r_pnr_total_prev']}}
      </td>
      <td>
        {{$arr_rank['r_pnr_total_new']}}
      </td>
      <td>
        {{$arr_rank['r_pnr_aktif_new']}}
      </td>
      <td style="color:#FF0000; font-weight:bold">
        {{$arr_rank['r_pnr_total_tot']}}
      </td>
      <td>
        {{$arr_rank['r_pnr_aktif_prev']}}
      </td>
      <td style="color:#00CC00; font-weight:bold;">
        {{$arr_rank['r_pnr_aktif_tot']}}
      </td>
      
      <td style="font-weight:bold">
        {{$arr_rank['match_aktif']}}
      </td>
      <td style="text-align:center">
        {{$arr_rank['flushout']}}
      </td>
      <td style="text-align:left">
        {{$arr_rank['ranking']}}
      </td>
      <td style="font-weight:bold; color:#FF0000">
        {{$arr_rank['cf_l']}}
      </td>
      <td style="font-weight:bold; color:#FF0000">
        {{$arr_rank['cf_r']}}
      </td>
      <td style="font-weight:bold; color:#00CC00">
        {{$arr_rank['cf_aktif_l']}}
      </td>
      <td style="font-weight:bold; color:#00CC00">
        {{$arr_rank['cf_aktif_r']}}
      </td>
      <td style="text-align:right">{{number_format($arr_rank['bonus_pv'],0,'','.')}}</td>
      <td>
        <?php if ($arr_rank['match_aktif']<>'0') { ?>
          <font color="0000FF">Qualified</font>
        <?php } else { ?>
          <font color="FF0000">X</font>
        <?php }  ?>
      </td>
      <td>
        <?php if ($arr_rank['status']) { 
          echo "Bonus sdh di proses";
        } else echo "-";
        ?>
      </td>
    </tr>    
    <?php
  }
  $i=($page-1)*15 + 1;
  foreach ($tb_ranking as $arr) {
?>
<!--
    update tb_ranking set cf_l="{{$arr['cf_l']}}",cf_r="{{$arr['cf_r']}}" where username = "{{$arr->username}}" and tgl_to = "2015-07-31";
    -->
    <tr>
      <td>
        {{$i}}
      </td>
      <td style="padding-left:2px; text-align:left">
        {{$arr->username}}
      </td>
      <td style="text-align:center">
        {{$arr->personal_recruit}}
      </td>
      
      <td>
        {{$arr->l_pnr_total_prev}}
      </td>
      <td>
        {{$arr->l_pnr_total_new}}
      </td>
      <td>
        {{$arr->l_pnr_aktif_new}}
      </td>
      <td style="color:#FF0000; font-weight:bold">
        {{$arr->l_pnr_total_tot}}        
      </td>
      <td>
        {{$arr->l_pnr_aktif_prev}}
      </td>
      <td style="color:#00CC00; font-weight:bold">
        {{$arr->l_pnr_aktif_tot}}
      </td>
      
      <td>
        {{$arr->r_pnr_total_prev}}
      </td>
      <td>
        {{$arr->r_pnr_total_new}}
      </td>
      <td>
        {{$arr->r_pnr_aktif_new}}
      </td>
      <td style="color:#FF0000; font-weight:bold">
        {{$arr->r_pnr_total_tot}}
      </td>
      <td>
        {{$arr->r_pnr_aktif_prev}}
      </td>
      <td style="color:#00CC00; font-weight:bold;">
        {{$arr->r_pnr_aktif_tot}}
      </td>
      
      <td style="font-weight:bold">
        {{$arr->match_aktif}}
      </td>
      <td style="text-align:center">
        {{$arr->flushout}}
      </td>
      <td style="text-align:left">
        {{$arr->ranking}}
      </td>
      <td style="font-weight:bold; color:#FF0000">
        {{$arr->cf_l}}
      </td>
      <td style="font-weight:bold; color:#FF0000">
        {{$arr->cf_r}}
      </td>
      <td style="font-weight:bold; color:#00CC00">
        {{$arr->cf_aktif_l}}
      </td>
      <td style="font-weight:bold; color:#00CC00">
        {{$arr->cf_aktif_r}}
      </td>
      <td style="text-align:right">{{number_format($arr->bonus_pv,0,'','.')}}</td>
      <td>
        <?php if ($arr->match_aktif<>'0') { ?>
          <font color="0000FF">Qualified</font>
        <?php } else { ?>
          <font color="FF0000">X</font>
        <?php }  ?>
      </td>
      <td>
        <?php if ($arr->status) { 
          echo "Bonus sdh di proses";
        } else echo "-";
        ?>
      </td>
    </tr>    

<?php 
    $i+=1;
  } 
?>
<script>
  $(document).ready(function(){
    $("#from").datepicker('setDate', new Date('<?php echo $from; ?>'));
    $("#to").datepicker('setDate', new Date('<?php echo $to; ?>'));
  });

</script>		


@extends('layout.main')

@section('content')
<script type="text/javascript">
  var chart = '';
</script>
  <div class="page-header">
    <h1>Price Chart</h1>
  </div>  

  <br>

  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="text" name="from" id="from" class="form-control"> 
    </div>
    <div class="input-group fl">
      <p>hingga</p>
    </div>
    <div class="input-group fl">
      <input type="text" name="to" id="to" class="form-control"> 
    </div>  
    <div class="none"></div>
  </div>

  <div class="cover-input-group">
    <div class="input-group fl">
      <select name="select_group" id="select_group" class="form-control">
        <option>Daily</option>
        <!--<option>Weekly</option>-->
        <option>Monthly</option>
      </select>
    </div>
  </div>

  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="button" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
    <div class="none"></div>
  </div>

  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  
  
  <div id="chartContainer" style="height: 370px; width: 100%;"></div>

  <script>
    function refresh_page()
    {
      $.ajax({                                      
        url: '<?php echo url('price-chart/load-price-chart'); ?>',
        type: 'get',
        data: {
          from: $("#from").val(),
          to: $("#to").val(),
          select_group:$("#select_group").val(),
        },
        beforeSend: function()
        {
          $("#div-loading").show();
        },
        dataType: 'json',
        success: function(data)
        {
          var format = '';
          var xtitle='';

          if(data.type=='Daily'){
            format = 'DD-MM-YYYY';
            xtitle = 'Hari';
          } else {
            format = 'MMM-YYYY';
            xtitle = 'Bulan';
          }
          
          chart = new CanvasJS.Chart("chartContainer", {
              animationEnabled: true,
              title:{
                text: "Price Chart"
              },
              axisX:{
                title: "Hari",
                valueFormatString: format  
              }, 
              axisY:{
                title: "Total"
              },
							legend:{
								cursor: "pointer",
								dockInsidePlotArea: true,
								itemclick: toggleDataSeries
							},							
              data: [
              {
                type: "line",
                showInLegend:true,
                name: "Bank Pending",
                xValueType: "dateTime",
                xValueFormatString: format,
                //dataPoints: jQuery.parseJSON(data.bank_pending)
                dataPoints: data.bank_pending
                //dataPoints: data
              },
              {
                type: "line",
                showInLegend:true,
                name: "Bank Success",
                xValueType: "dateTime",
                xValueFormatString: format,
                //dataPoints: jQuery.parseJSON(data.bank_success)
                dataPoints: data.bank_success
              },
              {
                type: "line",
                showInLegend:true,
                name: "wuoymembership",
                xValueType: "dateTime",
                xValueFormatString: format,
                //dataPoints: jQuery.parseJSON(data.cron)
                dataPoints: data.cron
              },
              {
                type: "line",
                showInLegend:true,
                name: "Amelia Success",
                xValueType: "dateTime",
                xValueFormatString: format,
                //dataPoints: jQuery.parseJSON(data.amelia_success)
                dataPoints: data.amelia_success
              },
              {
                type: "line",
                showInLegend:true,
                name: "All",
                xValueType: "dateTime",
                xValueFormatString: format,
                //dataPoints: jQuery.parseJSON(data.amelia_success)
                dataPoints: data.all
              }]
            });

          chart.render();

          function toggleDataSeries(e){
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
              e.dataSeries.visible = false;
            }
            else{
              e.dataSeries.visible = true;
            }
            chart.render();
          }
          
          $("#div-loading").hide();
        }
      });
    }

    $(document).ready(function(){
      $("#alert").hide();
      refresh_page();
      
      $("#from").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
      });
      $("#from").datepicker('setDate', new Date());

      $("#to").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
      });
      $("#to").datepicker('setDate', new Date());

      $('#button-search').click(function(e){
        e.preventDefault();
        refresh_page();
      });
      
    });
  </script>   
  
@endsection
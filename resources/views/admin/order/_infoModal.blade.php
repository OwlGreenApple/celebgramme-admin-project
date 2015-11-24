<style>
    .column {
      float: left;
      margin-right: 50px;
    }
    
    body .modal-dialog{
        /* new custom width */
        width: 150%px;
    }
</style>
<div class="modal fade  bs-example-modal-lg" id="detail-show">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Daftar Order: </h4>
      </div>
      <div class="modal-body">
        <div class="row-fluid">
          <table class="table table-bordered">  
            <thead>
              <tr>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Product Quantity</th>
                <th>Image</th>
              </tr>      
            </thead>
            
            
            <tbody id="">
              <?php foreach ($datas as $data) { ?>
              <tr>
                <td style="text-align:center">{{$data->product_name}}</td>
                <td style="text-align:right">{{number_format($data->product_price,0,'','.')}}</td>
                <td style="text-align:center">{{$data->product_quantity}}</td>
                <td style="text-align:center">{{$data->product_image}}</td>
              </tr>
              <?php } ?>
            </tbody>
            
          </table>  
          
        </div>
        
      </div>
      <div class="modal-footer">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

  <script>
    $(document).ready(function(){
    });
  </script>		

  <!-- Modal -->
  <div class="modal fade" id="modalChangePassword" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Password</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-edit-password">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Old Password</label>
              <div class="col-sm-8 col-md-6">
                <input type="password" class="form-control" placeholder="Input Old Password" name="old_password" id="old-password">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">New Password</label>
              <div class="col-sm-8 col-md-6">
                <input type="password" class="form-control" placeholder="Input New Password" name="new_password" id="new-password">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Confirm Password</label>
              <div class="col-sm-8 col-md-6">
                <input type="password" class="form-control" placeholder="Input Confirm Password" name="new_password_confirmation" id="confirm-password">
              </div>
            </div>  
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="button-edit-password">Submit</button>
        </div>
      </div>
      
    </div>
  </div>

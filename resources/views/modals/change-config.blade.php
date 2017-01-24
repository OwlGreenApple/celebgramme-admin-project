<?php 
use Celebgramme\Models\Meta;

?>

  <!-- Modal -->
  <div class="modal fade" id="modalChangeConfig" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Config</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-edit-config">
						<div class="form-group form-group-sm row">
							<label class="col-xs-12 col-sm-12 col-md-12 control-label" for="">
								Delay follow (in seconds)
							</label>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay follow slow min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_delay_follow_slow_min" value="{{Meta::getMeta('random_delay_follow_slow_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay follow slow max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_delay_follow_slow_max" value="{{Meta::getMeta('random_delay_follow_slow_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay follow normal min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_delay_follow_normal_min" value="{{Meta::getMeta('random_delay_follow_normal_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay follow normal max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_delay_follow_normal_max" value="{{Meta::getMeta('random_delay_follow_normal_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay follow fast min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_delay_follow_fast_min" value="{{Meta::getMeta('random_delay_follow_fast_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay follow fast max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_delay_follow_fast_max" value="{{Meta::getMeta('random_delay_follow_fast_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay like slow min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_delay_like_slow_min" value="{{Meta::getMeta('random_delay_like_slow_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay like slow max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_delay_like_slow_max" value="{{Meta::getMeta('random_delay_like_slow_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay like normal min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_delay_like_normal_min" value="{{Meta::getMeta('random_delay_like_normal_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay like normal max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_delay_like_normal_max" value="{{Meta::getMeta('random_delay_like_normal_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay like fast min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_delay_like_fast_min" value="{{Meta::getMeta('random_delay_like_fast_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay like fast max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_delay_like_fast_max" value="{{Meta::getMeta('random_delay_like_fast_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay comment min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_delay_comment_min" value="{{Meta::getMeta('random_delay_comment_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay comment max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_delay_comment_max" value="{{Meta::getMeta('random_delay_comment_max')}}">
              </div>
            </div>  
						
						<hr>
						
						<div class="form-group form-group-sm row">
							<label class="col-xs-12 col-sm-12 col-md-12 control-label" for="">
								Delay follow for every action(in seconds)
							</label>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay antara action follow min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="delay_antara_action_follow_min" value="{{Meta::getMeta('delay_antara_action_follow_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay antara action follow max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="delay_antara_action_follow_max" value="{{Meta::getMeta('delay_antara_action_follow_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay antara action like min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="delay_antara_action_like_min" value="{{Meta::getMeta('delay_antara_action_like_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay antara action like max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="delay_antara_action_like_max" value="{{Meta::getMeta('delay_antara_action_like_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay antara action comment min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="delay_antara_action_comment_min" value="{{Meta::getMeta('delay_antara_action_comment_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay antara action comment max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="delay_antara_action_comment_max" value="{{Meta::getMeta('delay_antara_action_comment_max')}}">
              </div>
            </div>  
						
						<hr>
						<div class="form-group form-group-sm row">
							<label class="col-xs-12 col-sm-12 col-md-12 control-label" for="">
								Number action of follow / like / comment / unfollow (in action number)
							</label>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Action follow slow min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_action_follow_slow_min" value="{{Meta::getMeta('random_action_follow_slow_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Action follow slow max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_action_follow_slow_max" value="{{Meta::getMeta('random_action_follow_slow_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Action follow normal min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_action_follow_normal_min" value="{{Meta::getMeta('random_action_follow_normal_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Action follow normal max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_action_follow_normal_max" value="{{Meta::getMeta('random_action_follow_normal_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Action follow fast min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_action_follow_fast_min" value="{{Meta::getMeta('random_action_follow_fast_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Action follow fast max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_action_follow_fast_max" value="{{Meta::getMeta('random_action_follow_fast_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Action follow turbo min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_action_follow_turbo_min" value="{{Meta::getMeta('random_action_follow_turbo_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Action follow turbo max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_action_follow_turbo_max" value="{{Meta::getMeta('random_action_follow_turbo_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Action like slow min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_action_like_slow_min" value="{{Meta::getMeta('random_action_like_slow_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Action like slow max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_action_like_slow_max" value="{{Meta::getMeta('random_action_like_slow_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Action like normal min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_action_like_normal_min" value="{{Meta::getMeta('random_action_like_normal_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Action like normal max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_action_like_normal_max" value="{{Meta::getMeta('random_action_like_normal_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Action like fast min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_action_like_fast_min" value="{{Meta::getMeta('random_action_like_fast_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Action like fast max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_action_like_fast_max" value="{{Meta::getMeta('random_action_like_fast_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Action like turbo min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_action_like_turbo_min" value="{{Meta::getMeta('random_action_like_turbo_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Action like turbo max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_action_like_turbo_max" value="{{Meta::getMeta('random_action_like_turbo_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Action comment min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_action_comment_min" value="{{Meta::getMeta('random_action_comment_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Action comment max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_action_comment_max" value="{{Meta::getMeta('random_action_comment_max')}}">
              </div>
            </div>  
						<hr>
						<div class="form-group form-group-sm row">
							<label class="col-xs-12 col-sm-12 col-md-12 control-label" for="">
								Number range maximum action of follow / like / comment / unfollow (in action hourly number)
							</label>
            </div>  
						
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Hourly follow slow min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_hourly_limit_follow_slow_min" value="{{Meta::getMeta('random_hourly_limit_follow_slow_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Hourly follow slow max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_hourly_limit_follow_slow_max" value="{{Meta::getMeta('random_hourly_limit_follow_slow_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Hourly follow normal min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_hourly_limit_follow_normal_min" value="{{Meta::getMeta('random_hourly_limit_follow_normal_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Hourly follow normal max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_hourly_limit_follow_normal_max" value="{{Meta::getMeta('random_hourly_limit_follow_normal_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Hourly follow fast min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_hourly_limit_follow_fast_min" value="{{Meta::getMeta('random_hourly_limit_follow_fast_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Hourly follow fast max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_hourly_limit_follow_fast_max" value="{{Meta::getMeta('random_hourly_limit_follow_fast_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Hourly like slow min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_hourly_limit_like_slow_min" value="{{Meta::getMeta('random_hourly_limit_like_slow_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Hourly like slow max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_hourly_limit_like_slow_max" value="{{Meta::getMeta('random_hourly_limit_like_slow_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Hourly like normal min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_hourly_limit_like_normal_min" value="{{Meta::getMeta('random_hourly_limit_like_normal_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Hourly like normal max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_hourly_limit_like_normal_max" value="{{Meta::getMeta('random_hourly_limit_like_normal_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Hourly like fast min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_hourly_limit_like_fast_min" value="{{Meta::getMeta('random_hourly_limit_like_fast_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Hourly like fast max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_hourly_limit_like_fast_max" value="{{Meta::getMeta('random_hourly_limit_like_fast_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Hourly comment min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_hourly_limit_comment_min" value="{{Meta::getMeta('random_hourly_limit_comment_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Hourly comment max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="random_hourly_limit_comment_max" value="{{Meta::getMeta('random_hourly_limit_comment_max')}}">
              </div>
            </div>  
						<hr>
						<div class="form-group form-group-sm row">
							<label class="col-xs-12 col-sm-12 col-md-12 control-label" for="">
								Number range maximum action of follow / like / comment / unfollow (in daily action number)
							</label>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Daily follow slow min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="daily_follow_slow_limit_min" value="{{Meta::getMeta('daily_follow_slow_limit_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Daily follow slow max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="daily_follow_slow_limit_max" value="{{Meta::getMeta('daily_follow_slow_limit_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Daily follow normal min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="daily_follow_normal_limit_min" value="{{Meta::getMeta('daily_follow_normal_limit_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Daily follow normal max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="daily_follow_normal_limit_max" value="{{Meta::getMeta('daily_follow_normal_limit_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Daily follow fast min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="daily_follow_fast_limit_min" value="{{Meta::getMeta('daily_follow_fast_limit_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Daily follow fast max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="daily_follow_fast_limit_max" value="{{Meta::getMeta('daily_follow_fast_limit_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Daily like slow min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="daily_like_slow_limit_min" value="{{Meta::getMeta('daily_like_slow_limit_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Daily like slow max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="daily_like_slow_limit_max" value="{{Meta::getMeta('daily_like_slow_limit_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Daily like normal min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="daily_like_normal_limit_min" value="{{Meta::getMeta('daily_like_normal_limit_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Daily like normal max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="daily_like_normal_limit_max" value="{{Meta::getMeta('daily_like_normal_limit_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Daily like fast min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="daily_like_fast_limit_min" value="{{Meta::getMeta('daily_like_fast_limit_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Daily like fast max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="daily_like_fast_limit_max" value="{{Meta::getMeta('daily_like_fast_limit_max')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Daily comment min
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="daily_comment_limit_min" value="{{Meta::getMeta('daily_comment_limit_min')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Daily comment max
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="daily_comment_limit_max" value="{{Meta::getMeta('daily_comment_limit_max')}}">
              </div>
            </div>  
						<hr>
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Number days comment same user (in days)
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="num_days_comment_same_user" value="{{Meta::getMeta('num_days_comment_same_user')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Number days comment same media (in days)
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="num_days_comment_same_media" value="{{Meta::getMeta('num_days_comment_same_media')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							First Delay Error Cookies (in minutes)
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="delay_error_cookies_1" value="{{Meta::getMeta('delay_error_cookies_1')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Second Delay Error Cookies (in minutes)
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="delay_error_cookies_2" value="{{Meta::getMeta('delay_error_cookies_2')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Third Delay Error Cookies (in minutes)
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="delay_error_cookies_3" value="{{Meta::getMeta('delay_error_cookies_3')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Forth Delay Error Cookies (in minutes)
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="delay_error_cookies_4" value="{{Meta::getMeta('delay_error_cookies_4')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Fifth Delay Error Cookies (in minutes)
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="delay_error_cookies_5" value="{{Meta::getMeta('delay_error_cookies_5')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Maximum Like on same account <br>(per Delay like number)
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="number_like_on_same_account" value="{{Meta::getMeta('number_like_on_same_account')}}">
              </div>
              <label class="col-xs-2 col-sm-2 col-md-2 control-label" for="">
							Delay like on same account (in days)
							</label>
              <div class="col-xs-2 col-sm-2 col-md-2">
                <input type="number" class="form-control" placeholder="" name="delay_like_on_same_account" value="{{Meta::getMeta('delay_like_on_same_account')}}">
              </div>
            </div>  
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="button-edit-config">Submit</button>
        </div>
      </div>
      
    </div>
  </div>

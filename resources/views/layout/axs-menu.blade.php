<div id="navbar-axs" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Payment<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{url('order', $parameters = [], $secure = null)}}">Order</a></li>
                <li><a href="{{url('payment', $parameters = [], $secure = null)}}">Confirm Payment</a></li>
                <li><a href="{{url('invoice', $parameters = [], $secure = null)}}">Invoice</a></li>
                <li><a href="{{url('coupon', $parameters = [], $secure = null)}}">Coupon</a></li>
              </ul>
          </li>
<?php 
use Celebgramme\Models\Post;
$count_post = Post::join("settings","settings.id","=","posts.setting_id")
				 ->select("posts.*","settings.insta_username","settings.insta_password","settings.error_cred")
				 ->where("posts.type","=","pending")
				 ->orderBy('posts.updated_at', 'asc')
				 ->count();
?>					
          <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                History ({{$count_post}})<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{url('post', $parameters = [], $secure = null)}}">Post History Daily Likes</a></li>
                <li><a href="{{url('post-auto-manage', $parameters = [], $secure = null)}}">Post History Auto Manage ({{$count_post}})</a></li>
                <li><a href="{{url('setting', $parameters = [], $secure = null)}}">Setting IG Account All</a></li>
              </ul>
          </li>
          <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Member<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{url('member-all', $parameters = [], $secure = null)}}">All</a></li>
                <li><a href="{{url('access-token', $parameters = [], $secure = null)}}">Access Token</a></li>
              </ul>
          </li>
          <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Package<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{url('package-auto-manage', $parameters = [], $secure = null)}}">Package Auto Manage</a></li>
                <li><a href="#">Package Daily Likes</a></li>
              </ul>
          </li>
          <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Helper Const<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
								<li><a href="{{url('fl-name', $parameters = [], $secure = null)}}">Follow liker instance name</a></li>
								<li><a href="{{url('template-email', $parameters = [], $secure = null)}}">Templates Email</a></li>
              </ul>
          </li>
          <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Account<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#" data-target="#modalChangePassword" data-toggle="modal">Change Password</a></li>
								<li><a href="{{url('auth/logout', $parameters = [], $secure = null)}}">Logout</a></li>
              </ul>
          </li>
        </ul>          
      </div><!--/.nav-collapse -->
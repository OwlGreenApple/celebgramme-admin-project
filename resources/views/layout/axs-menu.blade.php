<div id="navbar-axs" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
				<?php if ( $user->email != "hancelebgramme@gmail.com" ) { ?>
          <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Payment<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{url('order', $parameters = [], $secure = null)}}">Order</a></li>
                <li><a href="{{url('payment', $parameters = [], $secure = null)}}">Confirm Payment</a></li>
                <!--<li><a href="{{url('invoice', $parameters = [], $secure = null)}}">Invoice</a></li>-->
                <li><a href="{{url('coupon', $parameters = [], $secure = null)}}">Coupon</a></li>
              </ul>
          </li>
				<?php } ?>
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
                <!--<li><a href="{{url('post', $parameters = [], $secure = null)}}">Post History Daily Likes</a></li>-->
                <li><a href="{{url('post-auto-manage', $parameters = [], $secure = null)}}">Post History Auto Manage ({{$count_post}})</a></li>
                <li><a href="{{url('setting', $parameters = [], $secure = null)}}">Setting IG Account All</a></li>
                <li><a href="{{url('log-post', $parameters = [], $secure = null)}}">Logs Post Auto Manage</a></li>
              </ul>
          </li>
          <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Member<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{url('member-all', $parameters = [], $secure = null)}}">All</a></li>
                <!--<li><a href="{{url('access-token', $parameters = [], $secure = null)}}">Access Token</a></li>-->
                <li><a href="{{url('home-page', $parameters = [], $secure = null)}}">Home Page</li></a>
                <li><a href="{{url('ads-page', $parameters = [], $secure = null)}}">Ads Content</li></a>
                <li><a href="{{url('affiliate', $parameters = [], $secure = null)}}">Affiliate</li></a>
              </ul>
          </li>
					<?php if ( ($user->email == "celebgramme.dev@gmail.com") || ($user->email == "admin@admin.com") ) { ?>
          <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Email<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{url('email-users', $parameters = [], $secure = null)}}">Users</a></li>
                <li><a href="{{url('blast-email', $parameters = [], $secure = null)}}">Blast Email</a></li>
              </ul>
          </li>
					<?php } ?>
          <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Package<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{url('package-auto-manage', $parameters = [], $secure = null)}}">Package Auto Manage</a></li>
                <!--<li><a href="#">Package Daily Likes</a></li>-->
              </ul>
          </li>
					<?php if ( ($user->email == "celebgramme.dev@gmail.com") || ($user->email == "admin@admin.com") || ($user->email == "it.axiapro@gmail.com") ) { ?>
          <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Automation<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{url('proxy-manager', $parameters = [], $secure = null)}}">Proxy Manager</a></li>
                <li><a href="{{url('categories', $parameters = [], $secure = null)}}">Categories</a></li>
								<li><a href="{{url('setting-automation', $parameters = [], $secure = null)}}">Status IG automation</a></li>
								<li><a href="{{url('setting-automation-daily', $parameters = [], $secure = null)}}">Daily IG automation</a></li>
								<li><a href="#" data-target="#modalChangeConfig" data-toggle="modal">Change Config</a></li>
              </ul>
          </li>
					<?php } ?>
          <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Helper Const<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
								<li><a href="{{url('fl-name', $parameters = [], $secure = null)}}">Server instance name</a></li>
								<li><a href="{{url('template-email', $parameters = [], $secure = null)}}">Templates Email</a></li>
              </ul>
          </li>
          <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Account<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#" data-target="#modalChangePassword" data-toggle="modal">Change Password</a></li>
                <li><a href="{{url('admin', $parameters = [], $secure = null)}}">Admin</a></li>
								<li><a href="{{url('auth/logout', $parameters = [], $secure = null)}}">Logout</a></li>
              </ul>
          </li>
        </ul>          
      </div><!--/.nav-collapse -->
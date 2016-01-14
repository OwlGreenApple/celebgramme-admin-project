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
          <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                History<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{url('post', $parameters = [], $secure = null)}}">Post History Daily Likes</a></li>
                <li><a href="{{url('post-auto-manage', $parameters = [], $secure = null)}}">Post History Auto Manage</a></li>
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
                <li><a href="{{url('member-all', $parameters = [], $secure = null)}}">Package Auto Manage</a></li>
                <li><a href="#">Package Daily Likes</a></li>
              </ul>
          </li>
              <li><a href="{{url('auth/logout', $parameters = [], $secure = null)}}">Logout</a></li>
        </ul>          
      </div><!--/.nav-collapse -->
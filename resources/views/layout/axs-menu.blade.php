<div id="navbar-axs" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Payment<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{url('suppliers', $parameters = [], $secure = null)}}">Confirm Payment</a></li>
              </ul>
          </li>
          <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                History<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{url('product-categories', $parameters = [], $secure = null)}}">Post History</a></li>
              </ul>
          </li>
              <li><a href="{{url('auth/logout', $parameters = [], $secure = null)}}">Logout</a></li>
        </ul>          
      </div><!--/.nav-collapse -->
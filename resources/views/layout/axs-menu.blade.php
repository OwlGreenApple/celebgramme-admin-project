<div id="navbar-axs" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Add Suppliers<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{url('suppliers', $parameters = [], $secure = null)}}">Suppliers List</a></li>
                <li><a href="{{url('add-suppliers', $parameters = [], $secure = null)}}">Add Suppliers</a></li>
              </ul>
            </li>
			<li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Add Category<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{url('product-categories', $parameters = [], $secure = null)}}">Categories List</a></li>
                <li><a href="{{url('add-product-category', $parameters = [], $secure = null)}}">Add Category</a></li>
              </ul>
            </li>
			<li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Add Products<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{url('products', $parameters = [], $secure = null)}}">Products</a></li>
                <li><a href="{{url('add-product', $parameters = [], $secure = null)}}">Add Product</a></li>
              </ul>
            </li>
			<li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Packages<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{url('packages', $parameters = [], $secure = null)}}">Packages</a></li>
              </ul>
            </li>
            <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Payment<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{url('show-confirm-payment', $parameters = [], $secure = null)}}">Confirm Payment</a></li>
                <li><a href="{{url('order', $parameters = [], $secure = null)}}">Order List</a></li>
                <li><a href="{{url('invoice', $parameters = [], $secure = null)}}">Invoice List</a></li>
              </ul>
            </li>
            <li class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Settings<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{url('order', $parameters = [], $secure = null)}}">Global Settings</a></li>
                <li><a href="{{url('show-confirm-payment', $parameters = [], $secure = null)}}">Coupon Rules</a></li>
              </ul>
            </li>
              <li><a href="{{url('auth/logout', $parameters = [], $secure = null)}}">Logout</a></li>
        </ul>          
      </div><!--/.nav-collapse -->
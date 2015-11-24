<?php

namespace Celebgramme\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Celebgramme\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
		$router->bind("supplierId", function ($id){
            $suppliers = \Celebgramme\Models\Suppliers::findOrFail($id);
            return $suppliers;
        });
		$router->bind("productId", function ($id){
            $product = \Celebgramme\Models\Products::where('product_slug',$id)->firstOrFail();
            return $product;
        });
		$router->bind("productCategoryId", function ($id){
            $category = \Celebgramme\Models\Product_categories::where('category_slug',$id)->firstOrFail();
            return $category;
        });
		
		$router->bind("packageId", function ($id){
            $package = \Celebgramme\Models\Packages::findOrFail($id);
            return $package;
        });
		
		$router->bind("packageFeatureId", function ($id){
            $package_feature = \Celebgramme\Models\Package_features::findOrFail($id);
            return $package_feature;
        });
		
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}

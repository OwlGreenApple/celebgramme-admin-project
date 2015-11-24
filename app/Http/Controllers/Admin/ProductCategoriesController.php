<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\Product;
use Celebgramme\Models\Product_categories;
use Celebgramme\Models\Link_product_category;
use Celebgramme\Models\Product_category_metas;
use Celebgramme\Models\Suppliers;
use Celebgramme\Models\Admin_logs;

use Illuminate\Http\Request as req;

use View,Auth,Request,DB,Carbon,Excel,Input,Config;

class ProductCategoriesController extends Controller {
    
	/**
	 * Hapus category dari table product_category
	 *
	 * @param  supplier  $supplier
	 * @return Response
	 */
	public function delete_product_category($category){
        $category->delete();
        $del = "category id = ".$category->id;
        Admin_logs::log_activity('delete',$category->toArray(),'delete category',$category->id);
        return redirect('product-categories');
	}
	
	
	/**
	 * Display a listing of the resource.
	 *
	 *@var Suppliers $suppliers
	 *
	 * @return Response
	 */
	public function load_list_product_categories(Product_categories $cat){
        $search   = Request::input('search');
        $page     = Request::input('page');
		$metas   = Product_category_metas::get();
		
        if ( $search === "" ) {
              $data = $cat->orderBy('id','ASC')->paginate(15);
			  /*
			  $data = DB::table('product_categories as a')->
							select('a.*','b.category_name as parent_name')->
							join('product_categories as b', 'b.parent_id', '=', 'a.id')->orderBy('id','DESC')->paginate(15);
			  */
        } else { 
              $data = $cat->where('category_name','like','%'.$search.'%')
											->orwhere('category_slug','like','%'.$search.'%')
											->orwhere('category_description','like','%'.$search.'%')
											->orwhere('category_type','like','%'.$search.'%')
											->orderBy('id','ASC')
											->paginate(15);
        }
        //$user = Auth::user();
        return view('admin.product_categories.content')->with(
                array(
                    'data'=>$data,
                    'page'=>$page,
                    'search'=>$search,
                    'metas'=>$metas
                ));
	}
	
	/**
	 * Post Product Category
	 *
	 * @return View
	 */
	public function post_product_category(){
		$category_name = Input::get('category_name');
		$destinationPath = UPLOADS_PATH.'categories/';
		if(Input::get('category_type') == "catalog"){
			$destinationPath = UPLOADS_PATH.'catalogs/';
		}elseif(Input::get('category_type') == "promo"){
			$destinationPath = UPLOADS_PATH.'promos/';
		}
		
		$count = Product_categories::where('category_slug','like','%'.str_slug($category_name,"-").'%')->count();
		if($count > 0){
			$category_name = $category_name." ".($count+1);
		}
		
		$category_name = str_slug($category_name,"-");
		
		$images = Input::file('image');
		if($images !== null){
				$extension = $images->getClientOriginalExtension();
				$fileName  = str_replace('.'.$extension,'_',$category_name).'.'.$extension;
				Request::merge(['category_image' => $fileName]);
				
				$images->move($destinationPath, $fileName);
		}
		Request::merge(['category_slug' => $category_name]);
		
		$product_categories = Product_categories::create(Input::all());
		Admin_logs::log_activity('insert new product category',Input::except('_method','_token','image','arrIdProducts'),'insert new',$product_categories->id);
    
    //(link product category), add records
    $arrIdProducts = Input::get('arrIdProducts');
    foreach($arrIdProducts as $arrIdProduct) {
      $link_products = new Link_product_category;
      $link_products->product_id = $arrIdProduct;
      $link_products->product_category_id = $product_categories->id;
      $link_products->save();
    }
    
		return redirect('product-categories');
	}
	
		/**
	 * Post Product category meta
	 *
	 * @return View
	 */
	public function post_product_category_meta(){
		$meta = Product_category_metas::create(Input::all());
		Admin_logs::log_activity('insert new product category meta',Input::except('_method','_token'),'insert new',$meta->id);
		return redirect('product-categories');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return View
	 */
	public function product_categories(){
		$search   = Request::input('search');
        $page     = Request::input('page');
        
        $user = Auth::user();
		return view('admin.product_categories.index',compact('user','search','page'));
	}
	/**
	 * update data category
	 *
	 * @param  category  $category
	 * @return Response
	 */
	public function update_product_category($category){
		$category_name = Input::get('category_name');
		$destinationPath = UPLOADS_PATH.'categories/';
		if(Input::get('category_type') == "catalog"){
			$destinationPath = UPLOADS_PATH.'catalogs/';
		}elseif(Input::get('category_type') == "promo"){
			$destinationPath = UPLOADS_PATH.'promos/';
		}
		
		
		$count = Product_categories::where('category_slug','like','%'.str_slug($category_name,"-").'%')->count();
		if($count > 0){
			$category_name = $category_name." ".($count+1);
		}
		
		$images = Input::file('image');
		if($images !== null){
				
				$extension = $images->getClientOriginalExtension();
				$fileName  = str_replace('.'.$extension,'_',$category_name).'.'.$extension;
				Request::merge(['category_image' => $fileName]);
				$images->move($destinationPath, $fileName);
		}
		Request::merge(['category_slug' => str_slug($category_name,"-")]);
		/* comparing array of request and retrieved collections from database */
        $diff = array_diff_assoc($category->toArray(),Request::except('_method','_token'));
        Admin_logs::log_activity('update ('.$category->id.')',$diff,'update product category',$category->id);
		
		$category->update(Request::all());
    
    //delete all record (link product category), add records
    $link_products = Link_product_category::
                     where("link_products_categories.product_category_id","=",$category->id)
                     ->delete();
    $arrIdProducts = Input::get('arrIdProducts');
    if (count($arrIdProducts) > 0 ) {
      foreach($arrIdProducts as $arrIdProduct) {
        $link_products = new Link_product_category;
        $link_products->product_id = $arrIdProduct;
        $link_products->product_category_id = $category->id;
        $link_products->save();
      }
    }
    
        return redirect('product-categories');
	}
	/**
	 * Menampilkan form edit category
	 *
	 * @return View
	 */
	public function edit_product_category($category){
		$id = $category->parent_id;
    $user = Auth::user();
    $products = Product::select("products.*","suppliers.supplier_company_name")->leftJoin("suppliers","suppliers.id","=","products.supplier_id")->get();
    $link_products = Link_product_category::select("products.*","suppliers.supplier_company_name")
                     ->join("products","products.id","=","link_products_categories.product_id")
                     ->leftJoin("suppliers","suppliers.id","=","products.supplier_id")
                     ->where("link_products_categories.product_category_id","=",$category->id)
                     ->get();
		$categories = Product_categories::lists('category_name','id');
		return view('admin.product_categories.editproduct_categories',compact('user','category','link_products','products','categories','id'));
	}
	
	/**
	 * Menampilkan form add product category
	 *
	 * @return View
	 */
	public function add_product_category(){
		$id = 0;
        $user = Auth::user();
		$categories = Product_categories::lists('category_name','id');
    $products = Product::select("products.*","suppliers.supplier_company_name")->leftJoin("suppliers","suppliers.id","=","products.supplier_id")->get();
    $link_products = array();
		return view('admin.product_categories.addproduct_categories',compact('user','categories','id','link_products','products'));
	}
	
	public function add_sub_product_category($category){
		$id = $category->id;
        $user = Auth::user();
		$categories = Product_categories::lists('category_name','id');
		return view('admin.product_categories.addproduct_categories',compact('user','categories','id'));
	}
	
	/**
	 * Menampilkan form add product category meta
	 *
	 * @return View
	 */
	public function add_product_category_meta($category){
		$id = $category->id;
        $user = Auth::user();
		return view('admin.product_categories.addproductcategory_meta',compact('user','id'));
	}
}

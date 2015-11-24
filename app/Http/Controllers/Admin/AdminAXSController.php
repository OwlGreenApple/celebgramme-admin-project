<?php namespace Axiapro\Http\Controllers\AdminAXS;

use Axiapro\Http\Requests;
use Axiapro\Http\Controllers\Controller;

use Axiapro\Models\Suppliers;
use Axiapro\Models\Product_categories;
use Axiapro\Models\Packages;
use Axiapro\Models\Package_features;
use Axiapro\Models\Admin_logs_axs;
use Axiapro\Models\Product_metas;
use Axiapro\Models\Products;

use Axiapro\Http\Requests\ImageRequest;
use Axiapro\Http\Requests\ProductRequest;
use Illuminate\Http\Request as req;

use View,Auth,Request,DB,Carbon,Excel,Input,Config;

class AdminAXSController extends Controller {
    
	/**
	 * Menampilkan form add suppliers
	 *
	 * @return View
	 */
	public function add_suppliers(){
        $user = Auth::user();
		return view('adminaxs.suppliers.addsuppliers',compact('user'));
	}
	
	
	
	/**
	 * Menampilkan form edit suppliers
	 *
	 * @return View
	 */
	public function edit_supplier($supplier){
        $user = Auth::user();
		return view('adminaxs.suppliers.editsuppliers',compact('user','supplier'));
	}
	
	/**
	 * update data supplier
	 *
	 * @param  supplier  $supplier
	 * @return Response
	 */
	public function update_supplier($suppliers){
		/* comparing array of request and retrieved collections from database */
        $diff = array_diff_assoc($suppliers->toArray(),Request::except('_method','_token'));
        Admin_logs_axs::log_activity('update ('.$suppliers->id.')',$diff,'update supplier',$suppliers->id);
		
		$suppliers->update(Request::all());
        return redirect('suppliers');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return View
	 */
	public function suppliers_axs(){
		$search   = Request::input('search');
        $page     = Request::input('page');
        
        $user = Auth::user();
		return view('adminaxs.suppliers.index',compact('user','search','page'));
	}
	
	
	/**
	 * Display a listing of the resource.
	 *
	 *@var Suppliers $suppliers
	 *
	 * @return Response
	 */
	public function load_list_suppliers(Suppliers $suppliers){
        $search   = Request::input('search');
        $page     = Request::input('page');
        
        if ( $search === "" ) {
              $data = $suppliers->orderBy('id','DESC')->paginate(15);
        } else { 
              $data = $suppliers->where('supplier_company_name','like','%'.$search.'%')
											->orwhere('supplier_address','like','%'.$search.'%')
											->orderBy('id','DESC')
											->paginate(15);
        }
        $user = Auth::user();
        return view('adminaxs.suppliers.content')->with(
                array(
                    'data'=>$data,
                    'page'=>$page,
                    'search'=>$search,
                    'user'=>$user,
                ));
	}
	
	/**
	 * Post Suppliers
	 *
	 * @return View
	 */
	public function post_suppliers(){
		$supplier = Suppliers::create(Input::all());
		Admin_logs_axs::log_activity('insert new suppliers',Input::all(),'insert new',$supplier->id);
		return redirect('suppliers');
	}
	
	/**
	 * Hapus supplier dari table suppliers
	 *
	 * @param  supplier  $supplier
	 * @return Response
	 */
	public function delete_supplier($suppliers){
        $suppliers->delete();   
        $del = "supplier id = ".$supplier->id;
        Admin_logs_axs::log_activity('delete',$suppliers->toArray(),'delete supplier',$admin->id);
        return redirect('suppliers');
	}
	
	/**
	 * Hapus category dari table product_category
	 *
	 * @param  supplier  $supplier
	 * @return Response
	 */
	public function delete_product_category($category){
        $category->delete();
        $del = "category id = ".$category->id;
        Admin_logs_axs::log_activity('delete',$category->toArray(),'delete category',$category->id);
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
        
        if ( $search === "" ) {
              $data = $cat->orderBy('id','DESC')->paginate(15);
        } else { 
              $data = $cat->where('supplier_name','like','%'.$search.'%')
											->orwhere('supplier_address','like','%'.$search.'%')
											->orderBy('id','DESC')
											->paginate(15);
        }
        $user = Auth::user();
        return view('adminaxs.product_categories.content')->with(
                array(
                    'data'=>$data,
                    'page'=>$page,
                    'search'=>$search,
                    'user'=>$user,
                ));
	}
	
	/**
	 * Post Product Category
	 *
	 * @return View
	 */
	public function post_product_category(){
		$count = Product_categories::where('category_slug',$this->slugify(Input::get('category_name')))->count();
		$category_name = Input::get('category_name');
		if($count > 0){
			$category_name = $category_name." ".($count+1);
		}
		Request::merge(['category_slug' => $this->slugify($category_name)]);
		$product_categories = Product_categories::create(Input::all());
		Admin_logs_axs::log_activity('insert new product category',Input::all(),'insert new',$product_categories->id);
		return redirect('product-categories');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return View
	 */
	public function product_categories_axs(){
		$search   = Request::input('search');
        $page     = Request::input('page');
        
        $user = Auth::user();
		return view('adminaxs.product_categories.index',compact('user','search','page'));
	}
	/**
	 * update data category
	 *
	 * @param  category  $category
	 * @return Response
	 */
	public function update_product_category($category){
		/* comparing array of request and retrieved collections from database */
		Request::merge(['category_slug' => $this->slugify(Input::get('category_name'))]);
        $diff = array_diff_assoc($category->toArray(),Request::except('_method','_token'));
        Admin_logs_axs::log_activity('update ('.$category->id.')',$diff,'update supplier',$category->id);
		
		$category->update(Request::all());
        return redirect('product-categories');
	}
	/**
	 * Menampilkan form edit category
	 *
	 * @return View
	 */
	public function edit_product_category($category){
        $user = Auth::user();
		return view('adminaxs.product_categories.editproduct_categories',compact('user','category'));
	}
	
	/**
	 * Menampilkan form add product category
	 *
	 * @return View
	 */
	public function add_product_category(){
        $user = Auth::user();
		return view('adminaxs.product_categories.addproduct_categories',compact('user'));
	}
	
	/**
	 * Hapus produk
	 *
	 * @param  supplier  $supplier
	 * @return Response
	 */
	public function delete_product($product){
        $product->delete();
		Product_metas::where('product_id',$product->id)->delete();
        $del = "product id = ".$product->id;
        Admin_logs_axs::log_activity('delete',$product->toArray(),'delete product',$product->id);
        return redirect('products');
	}
	
	/**
	 * Menampilkan image dari produk
	 *
	 *@var image $image
	 *
	 * @return Response
	 */
	public function load_list_image(){
		$image = Product_metas::where('product_id',Input::get('id'))->where('meta_name','like','product_image%')->orderBy('id')->get();
		return view('adminaxs.products.content_images')->with(
                array(
                    'images'=>$image,
                ));
	}
	/**
	 * Display a listing of the resource.
	 *
	 *@var Suppliers $suppliers
	 *
	 * @return Response
	 */
	public function load_list_products(Products $prod){
        $search   = Request::input('search');
        $page     = Request::input('page');
        
        if ( $search === "" ) {
              //$data = $prod->orderBy('id','DESC')->paginate(15);
              $data = $prod
									->select('products.*','products.id as pid','suppliers.supplier_company_name','product_categories.name')
									->join("suppliers","suppliers.id","=","products.supplier_id")
									->join("product_categories","product_categories.id","=","products.product_categories_id")
									->orderBy('products.id','DESC')->paginate(15);
        } else {
              $data = $prod->select('products.*','products.id as pid','suppliers.supplier_company_name','product_categories.name')
											->where('products.product_name','like','%'.$search.'%')
											->orwhere('products.product_price','like','%'.$search.'%')
											->orwhere('products.product_location','like','%'.$search.'%')
											->orwhere('products.product_condition','like','%'.$search.'%')
											->orwhere('products.product_description','like','%'.$search.'%')
											->orwhere('products.product_stock','like','%'.$search.'%')
											->join("suppliers","suppliers.id","=","products.supplier_id")
											->join("product_categories","product_categories.id","=","products.product_categories_id")
											->orwhere('product_categories.name','like','%'.$search.'%')
											->orwhere('suppliers.supplier_company_name','like','%'.$search.'%')
											->orderBy('products.id','DESC')
											->paginate(15);
        }
        $user = Auth::user();
        return view('adminaxs.products.content')->with(
                array(
                    'data'=>$data,
                    'page'=>$page,
                    'search'=>$search,
                    'user'=>$user,
                ));
	}
	
	/**
	 * Post Products
	 *
	 * @return View
	 */
	public function post_product(ProductRequest $prodReq, ImageRequest $imgReq){
		$products = Products::create(Input::all());
		Admin_logs_axs::log_activity('insert new product ',Input::except('meta_value'),'insert new',$products->id);
		
		$uploaded = $this->upload($imgReq,$products->id);
		return redirect('products');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return View
	 */
	public function products_axs(){
		$search   = Request::input('search');
        $page     = Request::input('page');
        
        $user = Auth::user();
		return view('adminaxs.products.index',compact('user','search','page'));
	}
	/**
	 * update data products
	 *
	 * @param  product $product
	 * @return Response
	 */
	public function update_product($product, ProductRequest $prodReq, ImageRequest $imgReq){
		/* comparing array of request and retrieved collections from database */
        $diff = array_diff_assoc($product->toArray(),Request::except('_method','_token'));
        Admin_logs_axs::log_activity('update ('.$product->id.')',$diff,'update product',$product->id);
		
		$product->update(Request::all());
		$uploaded = $this->update_upload($imgReq,$product->id);
        return redirect('products');
	}
	/**
	 * Menampilkan form edit product
	 *
	 * @return View
	 */
	public function edit_product($product){
        $user = Auth::user();
		$suppliers = Suppliers::lists('supplier_company_name','id');
		$categories = Product_categories::lists('name','id');
		$image = product_metas::join('products','product_metas.product_id','=','products.id')->where('products.id',$product->id)->get();
		return view('adminaxs.products.editproducts',compact('user','product','suppliers','categories','image'));
	}
	
	/**
	 * Menampilkan form add product category
	 *
	 * @return View
	 */
	public function add_product(){
        $user = Auth::user();
		$suppliers = Suppliers::lists('supplier_company_name','id');
		$categories = Product_categories::lists('category_name','id');
		return view('adminaxs.products.addproducts',compact('user','product','suppliers','categories'));
	}
	
	public function upload(ImageRequest $request,$id) {
		$images = $request->file('meta_value');
        foreach( $images as $key => $val){
			if($images[$key] !== null){
					$fileName = $this->moveFile($images,$key,$id);
					$products = Product_metas::insert(['meta_name'=>'product_image','meta_value'=>$fileName,'product_id'=>$id]);
			}
		}
	}
	
	/*
	* set upload path
	* return string
	*/
	private function setUploadPath() {
		$destinationPath = base_path().'/../public_html/axiasmart/uploads/';
		if(\App::environment() == "local"){
				$destinationPath = base_path().'/../htdocs/admin/uploads/';
		}
		return $destinationPath;
	}
	/*
	* upload file
	* param  images/request $images
	* param  int $key
	* param  int $id
	* return string $filename
	*/
	private function moveFile($images, $key,$id) {
		$destinationPath = $this->setUploadPath();
		$extension = $images[$key]->getClientOriginalExtension();
		$fileName  = str_replace('.'.$extension,'_'.$id,$images[$key]->getClientOriginalName()).'.'.$extension;
		$images[$key]->move($destinationPath, $fileName);
		return $fileName;
	}
	public function update_upload(ImageRequest $request,$id) {
		$images = $request->file('meta_value');
		$savedImage = Product_metas::where('product_id',$id)->get();
		$o = 0;
		if(count($savedImage) > 0){
			foreach( $images as $key => $val){
				if($images[$key] !== null){
						$fileName = $this->moveFile($images,$key,$id);
						foreach( $savedImage as $keyIndex => $img){
							if($keyIndex == $o){
								Product_metas::where('id',$img->id)->update(['meta_name'=>'product_image','meta_value'=>$fileName]);
							}else{
								Product_metas::insert(['meta_name'=>'product_image','meta_value'=>$fileName,'product_id'=>$id]);
							}
						}
				}
				$o++;
			}
		}else{
			$this->upload($request,$id);
		}
        
	}
	
	
	/**
	 * Menampilkan form add product package
	 *
	 * @return View
	 */
	public function add_package(){
        $user = Auth::user();
		return view('adminaxs.packages.addpackages',compact('user'));
	}
	
	/**
	 * Hapus category dari table package
	 *
	 * @param  supplier  $supplier
	 * @return Response
	 */
	public function delete_package($package){
        $package->delete();
        $del = "package id = ".$package->id;
        Admin_logs_axs::log_activity('delete',$package->toArray(),'delete package',$package->id);
        return redirect('packages');
	}
	
	
	/**
	 * Display a listing of the resource.
	 *
	 *@var Suppliers $suppliers
	 *
	 * @return Response
	 */
	public function load_list_packages(packages $cat){
        $search   = Request::input('search');
        $page     = Request::input('page');
        
        if ( $search === "" ) {
              $data = $cat->orderBy('id','DESC')->paginate(15);
        } else { 
              $data = $cat->where('supplier_name','like','%'.$search.'%')
											->orwhere('supplier_address','like','%'.$search.'%')
											->orderBy('id','DESC')
											->paginate(15);
        }
        $user = Auth::user();
        return view('adminaxs.packages.content')->with(
                array(
                    'data'=>$data,
                    'page'=>$page,
                    'search'=>$search,
                    'user'=>$user,
                ));
	}
	
	/**
	 * Post Product package
	 *
	 * @return View
	 */
	public function post_package(){
		$packages = packages::create(Input::all());
		Admin_logs_axs::log_activity('insert new product package',Input::all(),'insert new',$packages->id);
		return redirect('packages');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return View
	 */
	public function packages_axs(){
		$search   = Request::input('search');
        $page     = Request::input('page');
        
        $user = Auth::user();
		return view('adminaxs.packages.index',compact('user','search','page'));
	}
	/**
	 * update data package
	 *
	 * @param  package  $package
	 * @return Response
	 */
	public function update_package($package){
		/* comparing array of request and retrieved collections from database */
        $diff = array_diff_assoc($package->toArray(),Request::except('_method','_token'));
        Admin_logs_axs::log_activity('update ('.$package->id.')',$diff,'update supplier',$package->id);
		
		$package->update(Request::all());
        return redirect('packages');
	}
	/**
	 * Menampilkan form edit package
	 *
	 * @return View
	 */
	public function edit_package($package){
        $user = Auth::user();
		return view('adminaxs.packages.editpackages',compact('user','package'));
	}
	
	
	/*PACKAGE FEATURE*/
	/**
	 * Menampilkan form add product package
	 *
	 * @return View
	 */
	public function add_package_feature(){
        $user = Auth::user();
		$packages = Packages::lists('package_name','id');
		return view('adminaxs.package_features.addpackage_features',compact('user','packages'));
	}
	
	/**
	 * Hapus category dari table package_features
	 *
	 * @param  package_feature  $package_feature
	 * @return Response
	 */
	public function delete_package_feature($package_feature){
        $package_feature->delete();
        $del = "package feature id = ".$package_feature->id;
        Admin_logs_axs::log_activity('delete',$package_feature->toArray(),'delete package',$package_feature->id);
        return redirect('package-features');
	}
	
	
	/**
	 * Display a listing of the resource.
	 *
	 *@var Suppliers $suppliers
	 *
	 * @return Response
	 */
	public function load_list_package_features(package_features $cat){
        $search   = Request::input('search');
        $page     = Request::input('page');
        
        if ( $search === "" ) {
              $data = $cat->select('package_features.*','packages.package_name')->join('packages','package_features.package_id',"=",'packages.id')->orderBy('package_features.id','DESC')->paginate(15);
        } else { 
              $data = $cat->select('package_features.*','packages.package_name')->join('packages','package_features.package_id',"=",'packages.id')
											->where('package_features.feature_name','like','%'.$search.'%')
											->orwhere('package_features.feature_value','like','%'.$search.'%')
											->orwhere('packages.package_name','like','%'.$search.'%')
											->orderBy('package_features.id','DESC')
											->paginate(15);
        }
        $user = Auth::user();
        return view('adminaxs.package_features.content')->with(
                array(
                    'data'=>$data,
                    'page'=>$page,
                    'search'=>$search,
                    'user'=>$user,
                ));
	}
	
	/**
	 * Post package feature
	 *
	 * @return View
	 */
	public function post_package_feature(){
		$package_features = package_features::create(Input::all());
		Admin_logs_axs::log_activity('insert new package feature',Input::all(),'insert new',$package_features->id);
		return redirect('package-features');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return View
	 */
	public function package_features_axs(){
		$search   = Request::input('search');
        $page     = Request::input('page');
        
        $user = Auth::user();
		return view('adminaxs.package_features.index',compact('user','search','page'));
	}
	/**
	 * update data package feature
	 *
	 * @param  package_feature  $package_feature
	 * @return Response
	 */
	public function update_package_feature($package_feature){
		/* comparing array of request and retrieved collections from database */
        $diff = array_diff_assoc($package_feature->toArray(),Request::except('_method','_token'));
        Admin_logs_axs::log_activity('update ('.$package_feature->id.')',$diff,'update package_feature',$package_feature->id);
		
		$package_feature->update(Request::all());
        return redirect('package-features');
	}
	/**
	 * Menampilkan form edit package feature
	 *
	 * @return View
	 */
	public function edit_package_feature($package_feature){
        $user = Auth::user();
		$packages = Packages::lists('package_name','id');
		return view('adminaxs.package_features.editpackage_features',compact('user','package_feature','packages'));
	}
	/*PACKAGE FEATURE*/
	
	
	private function slugify($text){
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
	  // trim
	  $text = trim($text, '-');
	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	  // lowercase
	  $text = strtolower($text);
	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);
	  if (empty($text)){
		return 'n-a';
	  }
	  return $text;
	}
}

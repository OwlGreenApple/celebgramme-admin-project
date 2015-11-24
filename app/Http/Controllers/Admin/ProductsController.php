<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\Suppliers;
use Celebgramme\Models\Product_categories;
use Celebgramme\Models\Admin_logs;
use Celebgramme\Models\Product_metas;
use Celebgramme\Models\Products;

use Celebgramme\Helpers\GeneralHelper;


use Celebgramme\Http\Requests\ImageRequest;
use Celebgramme\Http\Requests\ProductRequest;
use Illuminate\Http\Request as req;

use View,Auth,Request,DB,Carbon,Excel,Input,Config, File, Image;

class ProductsController extends Controller {
    
	/**
	 * Hapus produk
	 *
	 * @param  supplier  $supplier
	 * @return Response
	 */
	public function delete_product($product){
        $destinationPath = $this->setUploadPath();
		$old   = $destinationPath.$product->product_image;
		File::delete($old);
		
		$metaImages = Product_metas::where('product_id','=',$product->id)->where('meta_name','like','%product_image%')->where('meta_name','!=','product_image_count')->get();
		foreach($metaImages as $image){
				$old   = $destinationPath.$image->meta_value;
				File::delete($old);
		}
		$product->delete();
		Product_metas::where('product_id',$product->id)->delete();
		
        $del = "product id = ".$product->id;
        Admin_logs::log_activity('delete',$product->toArray(),'delete product',$product->id);
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
		$image = Product_metas::where('product_id',Input::get('id'))->where('meta_name','like','product_image%')->where('meta_name','!=','product_image_count')->orderBy('id')->get();
		return view('admin.products.content_images')->with(
                array(
                    'images'=>$image,
                ));
	}
	/**
	 * Menghapus produt meta
	 *
	 * @return Response
	 */
	public function delete_product_meta(){
		$image = Product_metas::where('id',Input::get('id'))->firstOrFail();
		$id = Product_metas::where('id',Input::get('id'))->first();
		$destinationPath = $this->setUploadPath();
		$old   = $destinationPath.$image->meta_value;
		File::delete($old);
		$image->delete();
		$this->updateImageCount($id->product_id);
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
		$metas   = Product_metas::where('meta_name','NOT LIKE','%product_image%')->get();
        
        if ( $search === "" ) {
              //$data = $prod->orderBy('id','DESC')->paginate(15);
              $data = $prod
									->select('products.*','products.id as pid','suppliers.supplier_company_name','product_categories.category_name')
									->join("suppliers","suppliers.id","=","products.supplier_id")
									->leftJoin("product_categories","product_categories.id","=","products.product_categories_id")
									->orderBy('products.id','ASC')->paginate(15);
        } else {
              $data = $prod->select('products.*','products.id as pid','suppliers.supplier_company_name','product_categories.category_name')
											->where('products.product_name','like','%'.$search.'%')
											->orwhere('products.product_price','like','%'.$search.'%')
											->orwhere('products.product_location','like','%'.$search.'%')
											->orwhere('products.product_condition','like','%'.$search.'%')
											->orwhere('products.product_description','like','%'.$search.'%')
											->orwhere('products.product_stock','like','%'.$search.'%')
											->join("suppliers","suppliers.id","=","products.supplier_id")
											->leftJoin("product_categories","product_categories.id","=","products.product_categories_id")
											->orwhere('product_categories.category_name','like','%'.$search.'%')
											->orwhere('suppliers.supplier_company_name','like','%'.$search.'%')
											->orderBy('products.id','ASC')
											->paginate(15);
        }
        $user = Auth::user();
        return view('admin.products.content')->with(
                array(
                    'data'=>$data,
                    'page'=>$page,
                    'search'=>$search,
                    'user'=>$user,
                    'metas'=>$metas,
                ));
	}
	
	/**
	 * Post Products
	 *
	 * @return View
	 */
	public function post_product(ProductRequest $prodReq, ImageRequest $imgReq){
		
		$product_name = Input::get('product_name');
		$count = Products::where('product_slug','like','%'.str_slug($product_name,"-").'%')->count();
		if($count > 0){
			$product_name = $product_name." ".$count;
		}
		$product_name = str_slug($product_name,"-");
		Request::merge(['product_slug' => $product_name]);

    //checkbox
    $optin = (Request::input('product_view') == "on") ? 1 : 0; 
    Request::merge(array('product_view' => $optin));
    
		$products = Products::create(Input::all());
    
		Admin_logs::log_activity('insert new product ',Input::except('meta_value'),'insert new',$products->id);
		
		
		$this->uploadMain($prodReq,$products->id, $product_name);
		$this->upload($imgReq,$products->id, $product_name);
    
    $temp_product = Products::where('id','=',$products->id)->firstOrFail();
    if ($temp_product->product_discount>0) {
			$imagedir = GeneralHelper::getBaseDirectory().'/general/images/products/';
			$imagepath = $imagedir.$temp_product->product_image;
			$badgepath = GeneralHelper::getBaseDirectory().'/general/images/badge-special-simple.png';
			if (File::exists($imagepath)){
				$image = Image::make($imagepath);
				$imagewidth = $image->width();
				$imageheight = $image->height();
				if ($imageheight < $imagewidth){
					$resizewidth = round((45/100)*$imageheight);
				}
				else{
					$resizewidth = round((45/100)*$imagewidth);
				}
				$badge = Image::make($badgepath)->resize($resizewidth,$resizewidth);
				$image->insert($badge, 'top-right');
				$image->save($imagedir.'sale_'.$temp_product->product_image);
			}
    }
		return redirect('products');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return View
	 */
	public function products(){
		$search   = Request::input('search');
        $page     = Request::input('page');
        
        $user = Auth::user();
		return view('admin.products.index',compact('user','search','page'));
	}
	/**
	 * update data products
	 *
	 * @param  product $product
	 * @return Response
	 */
	public function update_product($product, ProductRequest $prodReq, ImageRequest $imgReq){
		
		$product_name = Input::get('product_name'); //pro
			// jika nama produk di ubah: buat slug baru
			if($product_name != $product->product_name){
					$count = Products::where('product_slug','like','%'.str_slug($product_name,"-").'%')->count();
					// jika nama product sudah di pakai tambah nomor di belakang
					$product_name = str_slug($product_name,"-");
					Request::merge(['product_slug' => $product_name]);
					if($count > 0){
						$product_name = $product_name." ".$count;
						$product_name = str_slug($product_name,"-");
						Request::merge(['product_slug' => $product_name]);
					}
					
						$mainImages = Products::where('id','=',$product->id)->firstOrFail();
						
						$destinationPath = $this->setUploadPath();
						/*RENAME MAIN IMAGE */
						$old   = $destinationPath.$mainImages->product_image;
						$ext = pathinfo($mainImages->product_image, PATHINFO_EXTENSION);
						$filename = $product_name.".".$ext;
						$new = $destinationPath.$filename;
						if ( ! File::copy($old, $new)){
							die("Couldn't copy file");
						}
						Products::where('id', $mainImages->id)
															->update(['product_image' =>$filename]);
						File::delete($old);
						/*RENAME MAIN IMAGE */
						
						/*RENAME META IMAGE */
						$urut = 1;
						$metaImages = Product_metas::where('product_id','=',$product->id)->where('meta_name','like','%product_image%')->where('meta_name','!=','product_image_count')->get();
						foreach($metaImages as $images ){
								$old   = $destinationPath.$images->meta_value;
								$ext = pathinfo($images->meta_value, PATHINFO_EXTENSION);
								$no = $urut++;
								$filename = $product_name."-".$no.".".$ext;
								$new = $destinationPath.$filename;
								if ( ! File::copy($old, $new)){
									die("Couldn't copy file");
								}
								Product_metas::where('id', $images->id)
															->update(['meta_value' =>$filename]);
								File::delete($old);
						}
						/*RENAME META IMAGE */
					
			}
		
		/* comparing array of request and retrieved collections from database */
        $diff = array_diff_assoc($product->toArray(),Request::except('_method','_token'));
        Admin_logs::log_activity('update ('.$product->id.')',$diff,'update product',$product->id);
		
    //checkbox
    $optin = (Request::input('product_view') == "on") ? 1 : 0; 
    Request::merge(array('product_view' => $optin));
    
		$product->update(Request::all());
		$this->uploadMain($prodReq,$product	->id,$product_name);
		$this->update_upload($imgReq,$product->id,$product_name);
    
    if ($product->product_discount>0) {
			$imagedir = GeneralHelper::getBaseDirectory().'/general/images/products/';
			$imagepath = $imagedir.$product->product_image;
			$badgepath = GeneralHelper::getBaseDirectory().'/general/images/badge-special-simple.png';
			if (File::exists($imagepath)){
				$image = Image::make($imagepath);
				$imagewidth = $image->width();
				$imageheight = $image->height();
				if ($imageheight < $imagewidth){
					$resizewidth = round((45/100)*$imageheight);
				}
				else{
					$resizewidth = round((45/100)*$imagewidth);
				}
				$badge = Image::make($badgepath)->resize($resizewidth,$resizewidth);
				$image->insert($badge, 'top-right');
				$image->save($imagedir.'sale_'.$product->product_image);
			}
    }
    
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
		$categories = Product_categories::lists('category_name','id');
		$image = Product_metas::select('product_metas.id as meta_id','product_metas.*','products.*')->join('products','product_metas.product_id','=','products.id')->where('products.id',$product->id)->where('meta_name','like','%product_image%')->where('meta_name','!=','product_image_count')->get();
		return view('admin.products.editproducts',compact('user','product','suppliers','categories','image'));
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
		return view('admin.products.addproducts',compact('user','product','suppliers','categories'));
	}
	
	/**
	 * Menampilkan form add product meta
	 *
	 * @return View
	 */
	public function add_product_meta($prod){
		$id = $prod->id;
        $user = Auth::user();
		return view('admin.products.addproduct_meta',compact('user','id'));
	}
	
	/**
	 * Post Product meta
	 *
	 * @return View
	 */
	public function post_product_meta(){
		$meta = Product_metas::create(Input::all());
		Admin_logs::log_activity('insert new product meta',Input::except('_method','_token'),'insert new',$meta->id);
		return redirect('products');
	}
	public function uploadMain(ProductRequest $request,$id, $product_name) {
		$images = $request->file('product_image');
		if($images !== null){
				$destinationPath = $this->setUploadPath();
				$extension = $images->getClientOriginalExtension();
				$fileName  = str_replace('.'.$extension,'_'.$id,$product_name).'.'.$extension;
				$images->move($destinationPath, $fileName);
				Products::where('id',$id)->update(['product_image'=>$fileName]);
		}
	}
	
	public function upload(ImageRequest $request,$id, $product_name) {
		$images = $request->file('meta_value');
		$count = 0;
        foreach( $images as $key => $val){
			
			$no = $key + 1;
			if($images[$key] !== null){
					$count += 1;
					$fileName = $this->moveFile($images,$key,$id,$product_name);
					$products = Product_metas::insert(['meta_name'=>'product_image_'.$no,'meta_value'=>$fileName,'product_id'=>$id]);
			}
		}
		
		$this->updateImageCount($id);
		
	}

	/*
	* update image count
	* var int $id
	* return string
	*/
	private function updateImageCount($id) {
		$imageCount = Product_metas::where('meta_name','product_image_count')->where('product_id',$id)->count();
		$count = Product_metas::where('product_id',$id)->where('meta_name','like','%product_image%')->where('meta_name','!=','product_image_count')->count();
		if($imageCount == 0){
				$products = Product_metas::insert(['meta_name'=>'product_image_count','meta_value'=>$count,'product_id'=>$id]);
		}else{
				Product_metas::where('product_id',$id)->where('meta_name','product_image_count')->update(['meta_value'=>$count]);
		}
	}
	/*
	* set upload path
	* return string
	*/
	private function setUploadPath() {
		return UPLOADS_PATH."products/";
	}
	/*
	* upload file
	* param  images/request $images
	* param  int $key
	* param  int $id
	* return string $filename
	*/
	private function moveFile($images, $key,$id,$product_name) {
		$destinationPath = $this->setUploadPath();
		$extension = $images[$key]->getClientOriginalExtension();
		$num = $key + 1;
		$fileName  = str_replace('.'.$extension,'_'.$id,$product_name."-".$num).'.'.$extension;
		$images[$key]->move($destinationPath, $fileName);
		return $fileName;
	}
	public function update_upload(ImageRequest $request,$id,$product_name) {
		$images = $request->file('meta_value');
		$savedImage = Product_metas::where('product_id',$id)->where('meta_name','like','%product_image%')->where('meta_name','!=','product_image_count')->get();
		$o = 0;
		$no = 1;
		if(count($savedImage) > 0){
			foreach( $images as $key => $val){
				if($images[$key] !== null){
						$fileName = $this->moveFile($images,$key,$id,$product_name);
						foreach( $savedImage as $keyIndex => $img){
							if($keyIndex == $o){
								Product_metas::where('id',$img->id)->update(['meta_value'=>$fileName]);
								$up = 1;
							}
						}
						if($up == 0){
							$no = $this->getNomorUrut($id);
							Product_metas::insert(['meta_name'=>'product_image_'.$no,'meta_value'=>$fileName,'product_id'=>$id]);
						}		
				}
				$o++;
				$no++;
				$up = 0;
			}
			$count = Product_metas::where('product_id',$id)->where('meta_name','like','%product_image%')->where('meta_name','!=','product_image_count')->count();
			Product_metas::where('product_id',$id)->where('meta_name','product_image_count')->update(['meta_value'=>$count]);
		}else{
			$this->upload($request,$id,$product_name);
		}
	}
	
	private function getNomorUrut($id){
		for($a = 1; $a <= 5; $a++){
			$count  = Product_metas::where('product_id',$id)->where('meta_name','product_image_'.$a)->count();
			if($count == 0){
				return $a;
			}
		}
	}
}

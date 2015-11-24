<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\Packages;
use Celebgramme\Models\Package_metas;
use Celebgramme\Models\Admin_logs;

use Illuminate\Http\Request as req;

use View,Auth,Request,DB,Carbon,Excel,Input,Config;

class PackagesController extends Controller {
    
	/**
	 * Menampilkan form add product package
	 *
	 * @return View
	 */
	public function add_package(){
        $user = Auth::user();
		return view('admin.packages.addpackages',compact('user'));
	}
	
	/**
	 * Menampilkan form add product package meta
	 *
	 * @return View
	 */
	public function add_package_meta($package){
		$id = $package->id;
        $user = Auth::user();
		return view('admin.packages.addpackage_meta',compact('user','id'));
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
        Admin_logs::log_activity('delete',$package->toArray(),'delete package',$package->id);
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
        $metas   = Package_metas::get();
        if ( $search === "" ) {
              $data = $cat->orderBy('id','ASC')->paginate(15);
        } else { 
              $data = $cat->where('package_name','like','%'.$search.'%')
											->orwhere('package_price','like','%'.$search.'%')
											->orderBy('id','ASC')
											->paginate(15);
        }
        $user = Auth::user();
        return view('admin.packages.content')->with(
                array(
                    'data'=>$data,
                    'page'=>$page,
                    'search'=>$search,
                    'user'=>$user,
                    'metas'=>$metas,
                ));
	}
	
	/**
	 * Post Product package
	 *
	 * @return View
	 */
	public function post_package(){
		$packages = packages::create(Input::all());
		Admin_logs::log_activity('insert new package',Input::except('_method','_token'),'insert new',$packages->id);
		return redirect('packages');
	}
	
	/**
	 * Post Product package meta
	 *
	 * @return View
	 */
	public function post_package_meta(){
		$package_meta = package_metas::create(Input::all());
		Admin_logs::log_activity('insert new package meta',Input::except('_method','_token'),'insert new',$package_meta->id);
		return redirect('packages');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return View
	 */
	public function packages(){
		$search   = Request::input('search');
        $page     = Request::input('page');
        $user = Auth::user();
		return view('admin.packages.index',compact('user','search','page','meta'));
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
        Admin_logs::log_activity('update ('.$package->id.')',$diff,'update supplier',$package->id);
		
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
		return view('admin.packages.editpackages',compact('user','package'));
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
		return view('admin.package_features.addpackage_features',compact('user','packages'));
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
        Admin_logs::log_activity('delete',$package_feature->toArray(),'delete package',$package_feature->id);
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
        return view('admin.package_features.content')->with(
                array(
                    'data'=>$data,
                    'page'=>$page,
                    'search'=>$search,
                    'user'=>$user,
                ));
	}
}

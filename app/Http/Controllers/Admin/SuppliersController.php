<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\Suppliers;
use Celebgramme\Models\Admin_logs;

use Illuminate\Http\Request as req;

use View,Auth,Request,DB,Carbon,Excel,Input,Config;

class SuppliersController extends Controller {
    
	/**
	 * Menampilkan form add suppliers
	 *
	 * @return View
	 */
	public function add_suppliers(){
        $user = Auth::user();
		return view('admin.suppliers.addsuppliers',compact('user'));
	}
	
	
	
	/**
	 * Menampilkan form edit suppliers
	 *
	 * @return View
	 */
	public function edit_supplier($supplier){
        $user = Auth::user();
		return view('admin.suppliers.editsuppliers',compact('user','supplier'));
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
        Admin_logs::log_activity('update ('.$suppliers->id.')',$diff,'update supplier',$suppliers->id);
		
		$suppliers->update(Request::all());
        return redirect('suppliers');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return View
	 */
	public function suppliers(){
		$search   = Request::input('search');
        $page     = Request::input('page');
        
        $user = Auth::user();
		return view('admin.suppliers.index',compact('user','search','page'));
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
              $data = $suppliers->orderBy('id','ASC')->paginate(15);
        } else { 
              $data = $suppliers->where('supplier_company_name','like','%'.$search.'%')
											->orwhere('supplier_address','like','%'.$search.'%')
											->orderBy('id','ASC')
											->paginate(15);
        }
        $user = Auth::user();
        return view('admin.suppliers.content')->with(
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
		Admin_logs::log_activity('insert new suppliers',Input::except('_method','_token'),'insert new',$supplier->id);
		return redirect('suppliers');
	}
	
	/**
	 * Hapus supplier dari table suppliers
	 *
	 * @param  supplier  $supplier
	 * @return Response
	 */
	public function delete_supplier($supplier){
        $del = "supplier id = ".$supplier->id;
        Admin_logs::log_activity('delete',$supplier->toArray(),'delete supplier',$supplier->id);
		$supplier->delete();   
        return redirect('suppliers');
	}
}

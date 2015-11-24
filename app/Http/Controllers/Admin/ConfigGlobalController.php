<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\Confirm_payment;
use Celebgramme\Models\Order;
use Celebgramme\Models\Invoice;
use Celebgramme\Models\Admin_logs;
use Celebgramme\Models\Setting;

use Auth,View,Input,Form,Request;

class ConfigGlobalController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
    $settings = Setting::all();
		return View::make('admin.settings.global_setting')->with(
                  array(
                    "settings"=>$settings,
                  ));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
    $configuration = Configuration::first();
    $configuration->title = Request::input('judulWebsite');
    $configuration->description = Request::input('deskripsi');
    $configuration->keyword = Request::input('keyword');
    $configuration->footer = Request::input('footer');
    $configuration->name = Request::input('nama');
    $configuration->company = Request::input('perusahaan');
    $configuration->email = Request::input('email');
    $configuration->alamat = Request::input('alamatLengkap');
    $configuration->hpsms = Request::input('hpSms');
    $configuration->phone = Request::input('telepon');
    $configuration->fax = Request::input('fax');
    $configuration->ym = Request::input('ym');
    $configuration->facebook = Request::input('facebook');
    $configuration->twitter = Request::input('twitter');
    $configuration->biaya_adm = Request::input('biayaAdmin');
    $configuration->min_transfer = Request::input('minimalTransfer');
    $configuration->pnr = Request::input('pnr');
    $configuration->pv_rp = Request::input('pv_rp');
    $configuration->flush_pay = Request::input('flush_pay');
    $configuration->save();
    
    $arr['type']="success";
    $arr['message']="Proses save berhasil dilakukan";
    return $arr;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
	}

}

<?php

namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\Referral;

use Auth,Request,DB, Carbon;

class ReferralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user = Auth::user();

      return view('admin.referral.index')
                ->with('user',$user);
    }

    public function load_referral(){
      $dt = Carbon::createFromFormat("d-m-Y h:i:s", Request::input('from').' 00:00:00'); 
      $dt1 = Carbon::createFromFormat("d-m-Y h:i:s", Request::input('to').' 00:00:00');

      $referrals = Referral::join('users','users.id','=','referrals.user_id_giver')
                    ->select('referrals.*','users.fullname','users.email', DB::raw('count(*) as jmlrefer'))
                    ->where('referrals.is_confirm',1)
                    ->whereDate('referrals.updated_at','>=',$dt)
                    ->whereDate('referrals.updated_at','<=',$dt1)
                    ->groupBy('referrals.user_id_giver')
                    ->having('jmlrefer','>=',Request::input('minrefer'))
                    ->get();

      $arr['view'] = (string) view('admin.referral.content')
                      ->with('referrals',$referrals);
      return $arr;
    }
}

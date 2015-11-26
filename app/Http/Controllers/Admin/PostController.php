<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Models\Products;

use View,Auth,Request,DB,Carbon;

class PostController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show bpv ranking page.
	 *
	 * @return Response
	 */
	public function index()
	{
    // return "from :".date("Y-m-d", intval(Request::input('from')))." to:".date("Y-m-d", intval(Request::input('to')))." to periode before:".date("Y-m-d", intval(Request::input('toperiodebefore')));
    // return date("Y-m-d H:i:s");
    // return GeneralHelper::getChildUpline("AX0000-0000","KIRI")->username;
    // return TreeHelper::countDownlinePNR("AX0000-1209","KANAN",'2014-12-01 00:00:00','2015-06-30 23:59:59','tgl_aktif');
    
    
    
    
    $user = Auth::user();
    $configuration = Configuration::first();
		return View::make('adminpage.bpv_ranking.index')->with(
                  array(
                    'user'=>$user,
                    'configuration'=>$configuration,
                  ));
	}

	public function generate_bpv_ranking()
  {
    $user = Auth::user();
    /*
    * checking available proses generate from table tb_ranking
    */
    $mydate = Tb_4mingguan::
              where('date_from','<=',date("Y-m-d", intval(Request::input('from'))))
              ->where('date_to','>=',date("Y-m-d", intval(Request::input('to'))))
              ->orderBy('id', 'desc')
              ->first();
              
    if (is_null($mydate)) {
      $mydate = Tb_4mingguan::
                where('date_from','<=',date("Y-m-d", intval(Request::input('from'))))
                ->where('date_from','<=',date("Y-m-d", intval(Request::input('to'))))
                ->orderBy('id', 'desc')
                ->first();
    }

    $tb_ranking = Tb_ranking::where('tgl_from','>=',$mydate->date_from)
                              ->where('tgl_to','<=',$mydate->date_to)
                              ->get();


    if ($tb_ranking->count()>0) {
      $arr['type']="error";
      $arr['message']="Proses generate telah dilakukan";
      return $arr;
    } else {
      //find previous periode
      $mydatePrevious = Tb_4mingguan::find($mydate->id - 1);
      if (!is_null($mydatePrevious)) {
        $previousDateFrom = $mydatePrevious->date_from;
        $previousDateTo = $mydatePrevious->date_to;
      } else {
        $previousDateFrom = "";
        $previousDateTo = "";
      }
      
      //generate data
      $results = DB::select("SELECT sponsor as username,count(sponsor) as jumlah 
                            FROM member where tglaktif<='".$mydate->date_to." 16:59:59' 
                            group by sponsor having jumlah>=2 ORDER BY sponsor ASC");
      // $results = DB::select("SELECT sponsor as username,count(sponsor) as jumlah 
                            // FROM upline where tgl_aktif<='".$mydate->date_to." 23:59:59' 
                            // group by sponsor having jumlah>=2 ORDER BY sponsor ASC");
                            //  status=1 and  and blokir='0'
      foreach ($results as $result)
      { 
        $member = Member::where('username','=',$result->username)->first();

        //fill pnr data, put it at temporary variable first
        $tb_ranking = Tb_ranking::where('tgl_from','>=',$previousDateFrom)
                                  ->where('tgl_to','<=',$previousDateTo)
                                  ->where('username','=',$result->username)
                                  ->orderBy('id', 'desc')
                                  ->first();
        $prevPendingLeft =0;$prevActiveLeft = 0;$prevPendingRight = 0;$prevActiveRight =0;
        //grabbing carry forward from previous periode record
        if (!is_null($tb_ranking)) {
          $prevPendingLeft = $tb_ranking->cf_l;
          $prevActiveLeft = $tb_ranking->cf_aktif_l;
          $prevPendingRight = $tb_ranking->cf_r;
          $prevActiveRight = $tb_ranking->cf_aktif_r;
        }
        $l_pnr_total_new=TreeHelper::countDownlinePNR($result->username,"KIRI",$mydate->date_from.' 00:00:00',$mydate->date_to.' 16:59:59','tgl_aktif'); //hanya daftar blm aktif2
        $l_pnr_aktif_new=TreeHelper::countDownlinePNR($result->username,"KIRI",$mydate->date_from.' 00:00:00',$mydate->date_to.' 16:59:59','tgl_aktif2');  //aktif 2 
        $r_pnr_total_new=TreeHelper::countDownlinePNR($result->username,"KANAN",$mydate->date_from.' 00:00:00',$mydate->date_to.' 16:59:59','tgl_aktif');
        $r_pnr_aktif_new=TreeHelper::countDownlinePNR($result->username,"KANAN",$mydate->date_from.' 00:00:00',$mydate->date_to.' 16:59:59','tgl_aktif2');
        

        $tb_ranking = new Tb_ranking;
        $tb_ranking->username=$result->username;
        $tb_ranking->nopolis=$member->nopolis;
        $tb_ranking->periode=date("Y-m", strtotime($mydate->date_to));
        $tb_ranking->tgl_from=$mydate->date_from;
        $tb_ranking->tgl_to=$mydate->date_to;
        $tb_ranking->personal_recruit=$result->jumlah;
        
        $tb_ranking->l_pnr_total_prev=$prevPendingLeft;
        $tb_ranking->l_pnr_total_new=$l_pnr_total_new;
        $tb_ranking->l_pnr_aktif_new=$l_pnr_aktif_new;
        $tb_ranking->l_pnr_total_tot=$prevPendingLeft + $l_pnr_total_new - $l_pnr_aktif_new;
        $tb_ranking->l_pnr_aktif_prev=$prevActiveLeft;
        $tb_ranking->l_pnr_aktif_tot=$l_pnr_aktif_new+$prevActiveLeft;
        
        $tb_ranking->r_pnr_total_prev=$prevPendingRight;
        $tb_ranking->r_pnr_total_new=$r_pnr_total_new;
        $tb_ranking->r_pnr_aktif_new=$r_pnr_aktif_new;
        $tb_ranking->r_pnr_total_tot=$prevPendingRight + $r_pnr_total_new - $r_pnr_aktif_new;
        $tb_ranking->r_pnr_aktif_prev=$prevActiveRight;
        $tb_ranking->r_pnr_aktif_tot=$r_pnr_aktif_new+$prevActiveRight;
        
        if ($prevPendingLeft + $l_pnr_total_new - $l_pnr_aktif_new >=0) {
          $tb_ranking->cf_l = $prevPendingLeft + $l_pnr_total_new - $l_pnr_aktif_new;
        } else { 
          $tb_ranking->cf_l = 0;
        }                
        if ($prevPendingRight + $r_pnr_total_new - $r_pnr_aktif_new >=0) {
          $tb_ranking->cf_r=$prevPendingRight + $r_pnr_total_new - $r_pnr_aktif_new;
        } else {
          $tb_ranking->cf_r = 0;
        }
        
        $match_value = Config_ranking::where('number_of_pnr','<=',$r_pnr_aktif_new+$prevActiveRight)
                       ->where('number_of_pnr','<=',$l_pnr_aktif_new+$prevActiveLeft)->orderBy('number_of_pnr', 'desc')->first();
        if (!is_null($match_value)) {
          $tb_ranking->cf_aktif_r=$r_pnr_aktif_new+$prevActiveRight - $match_value->number_of_pnr;
          $tb_ranking->cf_aktif_l=$l_pnr_aktif_new+$prevActiveLeft - $match_value->number_of_pnr;
          $tb_ranking->match_aktif = $match_value->number_of_pnr;
          $tb_ranking->ranking = $match_value->type;
          $tb_ranking->ranking_code = $match_value->id;
          
          // create data bpv 
          $datapv = new Datapv;
          $datapv->jenispv = "bpv_ranking";
          $datapv->username = $result->username;
          $datapv->kiri = $match_value->bonus_pv / 2;
          $datapv->kanan = $match_value->bonus_pv / 2;
          $datapv->uraian = "BPV Ranking ".$match_value->type;
          $datapv->naik = "no";
          // $datapv->tgl = date('Y-m-d H:i:s');
          $datapv->tgl = $mydate->date_to.' 00:00:00';
          $datapv->status = "0";
          $datapv->jenis = "kredit";
          $datapv->save();
          
        } else {
          $tb_ranking->cf_aktif_r=$r_pnr_aktif_new+$prevActiveRight;
          $tb_ranking->cf_aktif_l=$l_pnr_aktif_new+$prevActiveLeft;
          $tb_ranking->match_aktif = 0;
          $tb_ranking->ranking = "";
          $tb_ranking->ranking_code = "";
        }

        
        
        $tb_ranking->tgl=date('Y-m-d').' 23:59:59';
        $tb_ranking->userid=$user->userid;
        $tb_ranking->flushout='';
        $tb_ranking->status=0;
        $tb_ranking->save();
      }
      $arr['type']="success";
      $arr['message']="Proses generate berhasil dilakukan";
      return $arr;
    }
  }
  
  public function load_bpv_ranking()
  {
    $arr_rank = array();
    $mydate = Tb_4mingguan::
              where('date_from','<=',date("Y-m-d", intval(Request::input('from'))))
              ->where('date_to','>=',date("Y-m-d", intval(Request::input('to'))))
              ->orderBy('id', 'desc')
              ->first();

    if (is_null($mydate)) {
      $mydate = Tb_4mingguan::
                where('date_from','<=',date("Y-m-d", intval(Request::input('from'))))
                ->where('date_from','<=',date("Y-m-d", intval(Request::input('to'))))
                ->orderBy('id', 'desc')
                ->first();
    }      

    if (Request::input('username')=="") {
      $tb_ranking = Tb_ranking::leftJoin('config_rankings', 'tb_ranking.ranking_code', '=', 'config_rankings.id')->where('tgl_from','>=',$mydate->date_from)
                              ->where('tgl_to','<=',$mydate->date_to.' 23:59:59')
                              ->orderBy('username', 'asc')
                              ->paginate(15);
    } else {
      $tb_ranking = Tb_ranking::leftJoin('config_rankings', 'tb_ranking.ranking_code', '=', 'config_rankings.id')->where('tgl_from','>=',$mydate->date_from)
                              ->where('tgl_to','<=',$mydate->date_to.' 23:59:59')
                              ->where('username','=',Request::input('username'))
                              ->orderBy('username', 'asc')
                              ->paginate(15);
      if ($tb_ranking->count()==0) {
        //generate data
        $result = DB::select("SELECT sponsor as username,count(sponsor) as jumlah 
                              FROM member where tglaktif<='".$mydate->date_to." 16:59:59' 
                              and sponsor = '".Request::input('username')."'
                              group by sponsor ORDER BY sponsor ASC");
        $sponsor = 0;
        if (!is_null($result)) {
          $sponsor = $result[0]->jumlah;
        }
        
        $member = Member::where('username','=',Request::input('username'))->first();
        
        //find previous periode
        $mydatePrevious = Tb_4mingguan::find($mydate->id - 1);
        if (!is_null($mydatePrevious)) {
          $previousDateFrom = $mydatePrevious->date_from;
          $previousDateTo = $mydatePrevious->date_to;
        } else {
          $previousDateFrom = "";
          $previousDateTo = "";
        }

        //fill pnr data, put it at temporary variable first
        $check = Tb_ranking::where('tgl_from','>=',$previousDateFrom)
                                  ->where('tgl_to','<=',$previousDateTo)
                                  ->where('username','=',Request::input('username'))
                                  ->orderBy('id', 'desc')
                                  ->first();
        $prevPendingLeft =0;$prevActiveLeft = 0;$prevPendingRight = 0;$prevActiveRight =0;
        //grabbing carry forward from previous periode record
        if (!is_null($check)) {
          $prevPendingLeft = $check->cf_l;
          $prevActiveLeft = $check->cf_aktif_l;
          $prevPendingRight = $check->cf_r;
          $prevActiveRight = $check->cf_aktif_r;
        }
        $l_pnr_total_new=TreeHelper::countDownlinePNR(Request::input('username'),"KIRI",$mydate->date_from.' 00:00:00',$mydate->date_to.' 16:59:59','tgl_aktif'); //hanya daftar blm aktif2
        $l_pnr_aktif_new=TreeHelper::countDownlinePNR(Request::input('username'),"KIRI",$mydate->date_from.' 00:00:00',$mydate->date_to.' 16:59:59','tgl_aktif2');  //aktif 2 
        $r_pnr_total_new=TreeHelper::countDownlinePNR(Request::input('username'),"KANAN",$mydate->date_from.' 00:00:00',$mydate->date_to.' 16:59:59','tgl_aktif');
        $r_pnr_aktif_new=TreeHelper::countDownlinePNR(Request::input('username'),"KANAN",$mydate->date_from.' 00:00:00',$mydate->date_to.' 16:59:59','tgl_aktif2');


        $arr_rank['username']=Request::input('username');
        $arr_rank['nopolis']=$member->nopolis;
        $arr_rank['periode']=date("Y-m", strtotime($mydate->date_to));///////////////////////////// JANGAN LUPA DIGANTI
        $arr_rank['tgl_from']=$mydate->date_from;
        $arr_rank['tgl_to']=$mydate->date_to;
        $arr_rank['personal_recruit']=$sponsor;
        
        $arr_rank['l_pnr_total_prev']=$prevPendingLeft;
        $arr_rank['l_pnr_total_new']=$l_pnr_total_new;
        $arr_rank['l_pnr_aktif_new']=$l_pnr_aktif_new;
        $arr_rank['l_pnr_total_tot']=$prevPendingLeft + $l_pnr_total_new - $l_pnr_aktif_new;
        $arr_rank['l_pnr_aktif_prev']=$prevActiveLeft;
        $arr_rank['l_pnr_aktif_tot']=$l_pnr_aktif_new+$prevActiveLeft;
        
        $arr_rank['r_pnr_total_prev']=$prevPendingRight;
        $arr_rank['r_pnr_total_new']=$r_pnr_total_new;
        $arr_rank['r_pnr_aktif_new']=$r_pnr_aktif_new;
        $arr_rank['r_pnr_total_tot']=$prevPendingRight + $r_pnr_total_new - $r_pnr_aktif_new;
        $arr_rank['r_pnr_aktif_prev']=$prevActiveRight;
        $arr_rank['r_pnr_aktif_tot']=$r_pnr_aktif_new+$prevActiveRight;
        
        $arr_rank['cf_l']=$prevPendingLeft + $l_pnr_total_new - $l_pnr_aktif_new;
        $arr_rank['cf_r']=$prevPendingRight + $r_pnr_total_new - $r_pnr_aktif_new;
        
        $match_value = Config_ranking::where('number_of_pnr','<=',$r_pnr_aktif_new+$prevActiveRight)
                       ->where('number_of_pnr','<=',$l_pnr_aktif_new+$prevActiveLeft)->orderBy('number_of_pnr', 'desc')->first();
        if (!is_null($match_value)) {
          $arr_rank['cf_aktif_r']=$r_pnr_aktif_new+$prevActiveRight - $match_value->number_of_pnr;
          $arr_rank['cf_aktif_l']=$l_pnr_aktif_new+$prevActiveLeft - $match_value->number_of_pnr;
          $arr_rank['match_aktif'] = $match_value->number_of_pnr;
          $arr_rank['ranking'] = $match_value->type;
          $arr_rank['ranking_code'] = $match_value->id;
          $arr_rank['bonus_pv'] = $match_value->bonus_pv;
          
        } else {
          $arr_rank['cf_aktif_r']=$r_pnr_aktif_new+$prevActiveRight;
          $arr_rank['cf_aktif_l']=$l_pnr_aktif_new+$prevActiveLeft;
          $arr_rank['match_aktif'] = 0;
          $arr_rank['ranking'] = "";
          $arr_rank['ranking_code'] = "";
          $arr_rank['bonus_pv'] = 0;
        }
        $arr_rank['flushout']="";
        $arr_rank['status']=0;
        
        
        
        
      }
    }
    
    return view('adminpage.bpv_ranking.content')->with(
                array(
                  'tb_ranking'=>$tb_ranking,
                  'arr_rank'=>$arr_rank,
                  'from'=>date("Y-m-d", strtotime($mydate->date_from)),
                  'to'=>date("Y-m-d", strtotime($mydate->date_to)),
                  'page'=>Request::input('page'),
                  'username'=>Request::input('username'),
                ));
  }
  
	public function pagination_bpv_ranking()
  {
    $mydate = Tb_4mingguan::
              where('date_from','<=',date("Y-m-d", intval(Request::input('from'))))
              ->where('date_to','>=',date("Y-m-d", intval(Request::input('to'))))
              ->orderBy('id', 'desc')
              ->first();

    if (is_null($mydate)) {
      $mydate = Tb_4mingguan::
                where('date_from','<=',date("Y-m-d", intval(Request::input('from'))))
                ->where('date_from','<=',date("Y-m-d", intval(Request::input('to'))))
                ->orderBy('id', 'desc')
                ->first();
    }      

    if (Request::input('username')=="") {
      $tb_ranking = Tb_ranking::where('tgl_from','>=',$mydate->date_from)
                                ->where('tgl_to','<=',$mydate->date_to.' 23:59:59')
                                ->orderBy('username', 'asc')
                                ->paginate(15);
    } else {
      $tb_ranking = Tb_ranking::leftJoin('config_rankings', 'tb_ranking.ranking_code', '=', 'config_rankings.id')->where('tgl_from','>=',$mydate->date_from)
                              ->where('tgl_to','<=',$mydate->date_to.' 23:59:59')
                              ->where('username','=',Request::input('username'))
                              ->orderBy('username', 'asc')
                              ->paginate(15);
    }
    
                              
    return view('adminpage.bpv_ranking.pagination')->with(
                array(
                  'tb_ranking'=>$tb_ranking,
                ));
  }
  
    
}

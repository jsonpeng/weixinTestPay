<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Setting;
use Config;

use App\User;
use App\Models\Admin;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class UserController extends AppBaseController
{

    //过滤处理特殊字节
     private  function filter($str) {      
        if($str){ 
            $name = $str; 
            $name = preg_replace('/\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]/', '', $name); 
            $name = preg_replace('/xE0[x80-x9F][x80-xBF]‘.‘|xED[xA0-xBF][x80-xBF]/S','?', $name); 
            $return = json_decode(preg_replace("#(\\\ud[0-9a-f]{3})#ie","",json_encode($name))); 
            if(!$return){ 
                return $this->jsonName($return); 
            } 
        }else{ 
            $return = ''; 
        }     
        return $return; 
  
    }

    private  function emoji_encode($nickname){
          $strEncode = '';
          $length = mb_strlen($nickname,'utf-8');
          for ($i=0; $i < $length; $i++) {
              $_tmpStr = mb_substr($nickname,$i,1,'utf-8');
              if(strlen($_tmpStr) >= 4){
                  $strEncode .= '[[EMOJI:'.rawurlencode($_tmpStr).']]';
              }else{
                  $strEncode .= $_tmpStr;
             }
         }
        return $strEncode;
     }


    //批量导出
    public function reportMany(Request $request){
        if(User::orderBy('created_at','desc')->count() == 0){
            Flash::error('当前没有数据可以导出');
            return redirect(route('users.index'));
        }
        $time = Carbon::now()->format('Y-m-d H:i:s');
        $lists = User::orderBy('created_at','desc')->get();
        $con = $this;
        Excel::create('截止到'.$time.'用户记录', function($excel) use($lists,$con) {
            //第二列sheet
            $excel->sheet('用户记录列表', function ($sheet) use ($lists,$con) {
            $sheet->setWidth(array(
                'A' => 80,
                'B' => 14,
                'C' => 12,
                'D' => 60,
                'E' => 18
            ));
            $sheet->appendRow(array('微信昵称','手机号', '注册职位', '当前套餐','注册时间'));
                //$lists = $lists->chunk(100, function($lists) use(&$sheet) {
                   // Log::info($lists);
                    //$item = $item->items()->get();
                        foreach ($lists as $key => $item) {
                            $taocan_des = '';
                            $taocans = $item->packages()->orderBy('created_at','desc')->get();
                            foreach($taocans as $taocan){
                                $taocan_des .= $taocan->package_name.' ';
                            }
                            $sheet->appendRow(array(
                                $con->emoji_encode($item->nickname),
                                $item->mobile,
                                $item->job,
                                $taocan_des,
                                $item->created_at
                            ));
                        }
                  
                
            //});
        });
        })->download('xls');
    }

    public function index(Request $request){
        $users=$this->defaultSearchState(app('zcjy')->UserRepo()->model()); 
        $input=$request->all();
        $input =array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );

        $tools=$this->varifyTools($input);

        if(array_key_exists('name', $input)){
            $users=$users->where('nickname','like','%'.$input['name'].'%');
        }

        if(array_key_exists('mobile', $input)){
            $users=$users->where('mobile','like','%'.$input['mobile'].'%');
        }

        $users = $this->descAndPaginateToShow($users);
        return view('admin.user.index')
               ->with('users', $users)
               ->with('tools',$tools)
               ->with('input',$input);
    }

    public function edit($id){
        $users = app('zcjy')->UserRepo()->findWithoutFail($id);
        if(empty($users)){
            Flash::error('没有找到该用户');
            return redirect(route('users.index'));
        }
        return view('admin.user.edit')
        ->with('users',$users);
    }

    public function update($id,Request $request){
        $users = app('zcjy')->UserRepo()->findWithoutFail($id);

        if(empty($users)){
            Flash::error('没有找到该用户');
        }

        $users->update($request->all());
        Flash::success('更新用户成功');
        return redirect(route('users.index'));
    }

 
    



}

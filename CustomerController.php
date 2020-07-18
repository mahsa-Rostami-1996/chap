<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Imagick;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Models\tbl_media;
use App\Models\tbl_rolls;
use App\Models\tbl_settings;
use App\Models\customer;
use App\Models\order;
use Illuminate\Validation\Validator;
//use Input; 
use Session;

//use Illuminate\Support\Facades\Request;


class CustomerController extends Controller
{
    public function index(){ 
        $medias = tbl_media::orderBy('created_at' , 'desc')->get();
        $customername = session('customername');
        return view('index')->with('medias' , $medias )->with('customername' , $customername );
    }
    public function photostore(CustomerRequest $request){
        $imagename = date('YmdHis') . time().'.'.$request->photoupload->getClientOriginalExtension();
        $request->photoupload->move(public_path('photos'), $imagename);
        $data = getimagesize(public_path('photos' . "\\" ) . $imagename );
        $widthpix = $data[0];
        $heightpix = $data[1];
        $widthcm = round($widthpix * 0.02645);
        $heightcm = round($heightpix * 0.02645);
        session()->put('imagename2', $imagename);
        return  redirect()->to('/')->with( 'imagename' ,  $imagename)->with( 'widthcm' ,  $widthcm)->with( 'heightcm' ,  $heightcm);
    }
    public function submitorder(Request $request){        
        //sesion is set 
        //->> insert order
        //--insert orde, tempId() Login-singup
        //
        
        $order = new order();
        if(!session()->exists('customerid') ){        
            $order->idCustomer = 0;
            $order->idMedia = $request->get('zirmedia');
            $order->file =session('imagename2');
            $order->height = $request->height;
            $order->width = $request->width;
            $order->number = $request->number;
            $order->roll = $request->bestroll;
            

            if(!($request->has('punch'))){
                $order->punch = 0;
            }
            else if($request->has('punch')){
                $order->punch = 1;
            }
            if(!($request->has('whited'))){
                $order->withed = 0;
            }
            else if($request->has('whited') ){
                $order->withed = 1;
            }
            if(!($request->has('leefe'))){
                $order->leefe = 0;
            }
            else if($request->has('leefe') ){
                $order->leefe = 1;
            }
            if(!($request->has('exactsize'))){
                $order->exactsize = 0;
            }
            else if($request->has('exactsize')){
                $order->exactsize = 1;
            }
            $order->detials = $request->details;
            $order->price= $request->price;
            $order->status=0;
            $order->save(); 
            session()->put('orderid', $order->id);
            return view('login');
        }        
        else {
            $order->idCustomer =session('customerid');
            $order->idMedia = $request->get('zirmedia');
        $order->file =session('imagename2');
        $order->height = $request->height;
        $order->width = $request->width;
        $order->number = $request->number;
        $order->roll = $request->bestroll;
        if(!($request->has('punch'))){
            $order->punch = 0;
        }
        else if($request->has('punch')){
            $order->punch = 1;
        }
        if(!($request->has('whited'))){
            $order->withed = 0;
        }
        else if($request->has('whited') ){
            $order->withed = 1;
        }
        if(!($request->has('leefe'))){
            $order->leefe = 0;
        }
        else if($request->has('leefe') ){
            $order->leefe = 1;
        }
        if(!($request->has('exactsize'))){
            $order->exactsize = 0;
        }
        else if($request->has('exactsize')){
            $order->exactsize = 1;
        }
        $order->detials = $request->details;
        $order->price= $request->price;
        $order->status=0;
        $order->save(); 
        session()->put('orderid', $order->id);
        //echo session('orderid');
        return  redirect()->to('/')->with( 'success' ,  'سفارش شما ثبت شد');
        }
        
    }
    public function signin(Request $request){        
        $user = new customer();
        $user->name = $request->signin_name ;
        $user->mobile = $request->signin_mobile ;
        $user->password = md5($request->signin_pass) ;
        $user->save();
        session()->put('customerid', $user->id);
        session()->put('customername', $user->name);
        if (session('orderid') > 0)
        {
            $order = order::find(session('orderid'));
            $order->idCustomer = session('customerid');
            $order->save();
            return  redirect()->to('/')->with( 'success' ,  'سفارش شما ثبت شد');
        }
        return  redirect()->to('/');
    }
    public function login(Request $request){        
        $mypas=md5($request->login_pass);
        $user = customer::where('mobile' ,  $request->login_mobile)->where('password' ,  $mypas)->get();        
       // $_SESSION['customerid'] = $user[0]->id;
        session()->put('customerid', $user[0]->id);
        session()->put('customername', $user[0]->name);
        if(session('orderid') > 0)
        {
            $order = order::find(session('orderid'));
            $order->idCustomer = session('customerid');
            $order->save();
            return  redirect()->to('/')->with( 'success' ,  'سفارش شما ثبت شد');
        }
         return  redirect()->to('/');
    }
    public function logout(){        
        session()->flush();
       // session()->put('customername', 0);
        return  redirect()->to('/');
    }
}
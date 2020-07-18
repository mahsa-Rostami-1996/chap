<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_media;
use App\Models\tbl_rolls;
use App\Models\tbl_settings;

class MediaController extends Controller
{
    public function index(){
        
        $medias = tbl_media::orderBy('created_at' , 'desc')->get();
        $rolls = tbl_rolls::orderBy('created_at' , 'desc')->get();
        $settingroll = tbl_settings::where('type' , 'roll')->get();
        $settingleefe = tbl_settings::where('type' , 'leefe')->get();
        $settingpunch = tbl_settings::where('type' , 'punch')->get();
        $settingglue = tbl_settings::where('type' , 'glue')->get();
        $settingexactsize = tbl_settings::where('type' , 'exactsize')->get();
        $settingmedia = tbl_settings::select('name')->join('tbl_media' , 'tbl_media.id' , '=' , 'tbl_settings.value')->where('type' , 'media')->get();
    // echo  $settingroll ;
    // die;
        return view('management')->with('medias' , $medias )->with('rolls' , $rolls )->with('settingroll' , $settingroll )->with('settingleefe' , $settingleefe )->with('settingpunch' , $settingpunch )->with('settingglue' , $settingglue )->with('settingmedia' , $settingmedia )->with('settingexactsize', $settingexactsize);

    }
    public function mediastore(Request $request){  
        if(($request->mediaorder)==='insert'){
            return $this->mediacreate($request);
        }
        else if(($request->mediaorder)==='edit'){
            return $this->mediaedit($request);
        }
    }
    public function mediacreate(Request $request){
        $this->validate($request , [
            'medianame' => 'required',
            'mediaprice' => 'required',
        ]);
        //dd($request);
        $medias = new tbl_media();
      
        $medias->name = $request->medianame;
        $medias->price = $request->mediaprice;
       
        if( $request->has('mediamedia') && ($request->mediamedia)==0){
            $medias->parent = 0;
        }
        else if($request->has('mediamedia') && ($request->mediamedia)==1){
            $medias->parent = 1;
        } 
        if($request->has('mediapunch') && ($request->mediapunch)==='on'){
            $medias->punch = 1;
        }
        else if(!($request->has('mediapunch'))){
            $medias->punch = 0;
        }
        if(!($request->has('medialeefe'))){
            $medias->leefe = 0;
        }
        else if($request->has('medialeefe') && ($request->medialeefe)==='on'){
            $medias->leefe = 1;
        }
        if($request->has('mediaactivity') && ($request->mediaactivity)==='on'){
            $medias->activity = 1;
        }
        else if(!($request->has('mediaactivity')) ){
            $medias->activity = 0;
        }

        $medias->save();

        return redirect()->to('/management?order='.($request->order));

    }
    public function mediaedit(Request $request){
        $this->validate($request , [
            'medianame' => 'required',
            'mediaprice' => 'required',
        ]);
        //dd($request);
        $medias =tbl_media::find($request->mediaid);
      
        $medias->name = $request->medianame;
        $medias->price = $request->mediaprice;
       
        if( $request->has('mediamedia') && ($request->mediamedia)==0){
            $medias->parent = 0;
        }
        else if($request->has('mediamedia') && ($request->mediamedia)==1){
            $medias->parent = 1;
        } 
        if($request->has('mediapunch') && ($request->mediapunch)==='on'){
            $medias->punch = 1;
        }
        else if(!($request->has('mediapunch'))){
            $medias->punch = 0;
        }
        if(!($request->has('medialeefe'))){
            $medias->leefe = 0;
        }
        else if($request->has('medialeefe') && ($request->medialeefe)==='on'){
            $medias->leefe = 1;
        }
        if($request->has('mediaactivity') && ($request->mediaactivity)==='on'){
            $medias->activity = 1;
        }
        else if(!($request->has('mediaactivity')) ){
            $medias->activity = 0;
        }

        $medias->save();

        return redirect()->to('/management?order='.($request->order));

    }
    public function mediadestroy($id){
        $media = tbl_media::find($id);
        $dfltmdia = tbl_settings::where('type' , 'media')->where('value' , $id)->get();
        if ($dfltmdia)
        {
            $dfltmdia->value = 0;
        }

        $media->delete();
        return redirect()->to('/management?order=media');
    }


    public function rollstore2(Request $request){
       
        // if(($request->rollorder)==='insert'){
        //     return $this->rollcreate($request);
        // }
        // else if(($request->rollorder)==='edit'){
        //     return $this->rolledit($request);
        // }
        }

    public function rollstore(Request $request){
        
         if(($request->rollorder)==='insert'){
             return $this->rollcreate($request);
         }
         else if(($request->rollorder)==='edit'){
             return $this->rolledit($request);
         }
    } 
    public function rollcreate(Request $request){
        $this->validate($request , [
            'rollwidth' => 'required',
        ]);
        $rolls = new tbl_rolls();
      
        $rolls->width = $request->rollwidth;
       
        if($request->has('rollactivity') && ($request->rollactivity)==='on'){
            $rolls->activity = 1;
        }
        else if(!($request->has('rollactivity')) ){
            $rolls->activity = 0;
        }

        $rolls->save();

        return redirect()->to('/management?order='.($request->order));
    }
    public function rolledit(Request $request){
        $this->validate($request , [
            'rollwidth' => 'required',
        ]);
        $rolls =tbl_rolls::find($request->rollid);
      
        $rolls->width = $request->rollwidth;
       
        if($request->has('rollactivity') && ($request->rollactivity)==='on'){
            $rolls->activity = 1;
        }
        else if(!($request->has('rollactivity')) ){
            $rolls->activity = 0;
        }

        $rolls->save();

        return redirect()->to('/management?order='.($request->order));
    }
    public function rolldestroy($id){
        $roll = tbl_rolls::find($id);
        $roll->delete();
        return redirect()->to('/management?order=roll');
    }
    public function settingupdate(Request $request){
        $this->validate($request , [
            'settingroll' => 'required',
            'settingleefe' => 'required',
            'settingpunch' => 'required',
            'settingglue' => 'required',
            'settingmedia' => 'required',
        ]);

        $settingroll = tbl_settings::select('value')->where('type' , 'roll')->update(['value' =>  $request->settingroll]);
        $settingleefe = tbl_settings::select('value')->where('type' , 'leefe')->update(['value' =>  $request->settingleefe]);
        $settingpunch = tbl_settings::select('value')->where('type' , 'punch')->update(['value' =>  $request->settingpunch]);
        $settingglue = tbl_settings::select('value')->where('type' , 'glue')->update(['value' =>  $request->settingglue]);
        $settingexactsize = tbl_settings::select('value')->where('type' , 'exactsize')->update(['value' =>  $request->settingexactsize]);
       
        $settingmediaid =tbl_media::select('id')->where('name' , $request->settingmedia)->first();
        $settingmedia = tbl_settings::select('value')->where('type' , 'media')->update(['value' =>  $settingmediaid->id]);
        
        return redirect()->to('/management?order='.($request->order));

    }
}

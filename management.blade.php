<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" ></script>
    <script>
        function resetinputs(){
            jQuery('input').val('');
        }
        function showroll(){
            jQuery('.setting').hide();
            jQuery('.set-media').hide();
            jQuery('.set-roll').show();
            resetinputs();
        };
        function showmedia(){
            jQuery('.setting').hide();
            jQuery('.set-media').show();
            jQuery('.set-roll').hide();
            resetinputs();
        };
        function showsetting(){
            jQuery('.setting').show();
            jQuery('.set-media').hide();
            jQuery('.set-roll').hide();
            resetinputs();
        };
    </script>
    <script>
        function cancelmediaedit(){      
                jQuery("#mediapunch").prop( "checked", false );
                jQuery("#medialeefe").prop( "checked", false );
                jQuery("#mediaactivity").prop( "checked", false );

                jQuery("#btnmediaaction").val('');
                jQuery("#btnmediaaction").text('ثبت');
                jQuery(".mediaeditcancel").addClass( "disabled" );
                
                jQuery('input#medianame').val('');
                jQuery('input#mediaprice').val('');

                jQuery('#mediaid').val('');
                jQuery('#mediaorder').val('insert');
        };
         function setmediaforedit(id){       
            jQuery.get("getdata?id="+id+"&type=media",function(response)
            {
                jQuery("#mediapunch").prop( "checked", false );
                jQuery("#medialeefe").prop( "checked", false );
                jQuery("#mediaactivity").prop( "checked", false );

                jQuery("#mediaeditcancel").removeClass( "disabled" );

                jQuery("#btnmediaaction").val(id);
                jQuery("#btnmediaaction").text('ویرایش');

                var myJson= JSON.parse(response);
                
                jQuery('#medianame').val(myJson[0]['name']);
                jQuery('#mediaprice').val(myJson[0]['price']);


                for(var i = 0; i< jQuery("#mediamedia option").length ; i++ ){
                    //var idx = myJson[0]['parent'];
                    jQuery("#mediamedia").prop('selectedIndex' , i);
                    var aaa = jQuery('select[name=mediamedia] option').filter(':selected').val();
                    var idx = myJson[0]['parent'];
                    if(aaa == idx ) 
                        {break;}
                }
          
                if((myJson[0]['punch'])===1){
                        jQuery("#mediapunch").prop( "checked", true );
                }
                if((myJson[0]['leefe'])===1){
                        jQuery("#medialeefe").prop( "checked", true );                            
                }
                if((myJson[0]['activity'])===1){
                        jQuery("#mediaactivity").prop( "checked", true );
                }

                jQuery('#mediaid').val(id);
                jQuery('#mediaorder').val('edit');
            });        
        };
        function setrollforedit(id){       
            jQuery.get("getdata?id="+id+"&type=roll",function(response)
            {
                jQuery("#rollactivity").prop( "checked", false );

                jQuery(".rolleditcancel").removeClass( "disabled" );

                jQuery("#btnrollaction").val(id);
                jQuery("#btnrollaction").text('ویرایش');

                var myJson= JSON.parse(response);
                
                jQuery('input#rollheight').val(myJson[0]['height']);
                jQuery('input#rollwidth').val(myJson[0]['width']);

                
                if((myJson[0]['activity'])===1){
                        jQuery("#rollactivity").prop( "checked", true );
                }

                jQuery('#rollid').val(id);
                jQuery('#rollorder').val('edit');
            });
        
        };
        function cancelrolledit(){  
                jQuery("#rollactivity").prop( "checked", false );

                jQuery(".rollstore").removeClass( "disabled" );
                jQuery(".rolledit").addClass( "disabled" );
                jQuery(".rolleditcancel").addClass( "disabled" );
                
                jQuery('input#rollheight').val('');
                jQuery('input#rollwidth').val('');
        }; 
    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>مدیریت</title>
</head>
<body>
    <header class="topnav mt-4">
        <nav class="nav navbar-dark bg-dark justify-content-end text-sm">
            <a class="nav-link text-light text-sm" href="#" onClick="">خروج</a>
            <a class="nav-link text-light text-sm " href="#" id="setting_link"  onClick="showsetting();">تنظیمات</a>
            <a class="nav-link text-light text-sm " href="#" id="roll_link" onClick="showroll();">تنظیمات رول</a>
            <a class="nav-link text-light text-sm " href="#" id="media_link" onClick="showmedia();">تنظیمات مدیا</a>
        </nav>
    </header>
    <main>
        <div class="container " dir="rtl">
            <div class="setting mt-5">
                <div class="card">
                    <div class="card-body bg-light" >
                    <h4 class="text-center text-info ">تنظیمات</h4>
                    </div>
                </div>
                <form  action="/setting_edit" method="get">
                    <div class="form-row">
                        <input type="hidden" name="order" value="setting"/>
                        <div class="form-group col-md-4">
                            <label for="settingroll" class="float-right">قیمت رول:</label>
                            <input type="text" class="form-control text-center" name="settingroll" id="settingroll" placeholder="قیمت رول" value="{{$settingroll[0]->value}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="settingleefe" class="float-right">جای داربست:</label>
                            <input type="text" class="form-control text-center" name="settingleefe" id="settingleefe" placeholder="جای داربست" value="{{$settingleefe[0]->value}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="settingpunch" class="float-right">قیمت پانچ:</label>
                            <input type="text" class="form-control text-center" name="settingpunch" id="settingpunch" placeholder="قیمت پانچ" value="{{$settingpunch[0]->value}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="settingglue" class="float-right">قیمت هر متر چسب:</label>
                            <input type="text" class="form-control text-center" name="settingglue" id="settingglue" placeholder="قیمت هر متر چسب" value="{{$settingglue[0]->value}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="settingmedia" class="float-right">مدیای پیش‌فرض:</label>
                            <select name="settingmedia" id="settingmedia" class="form-control">
                            <option value="2" >{{$settingmedia[0]->name}} </option>
                                @if(count($medias)>0)
                            
                                @foreach($medias as $media)   
                                    <option value="1" > @if(($media->parent) > 0){{$media->name}}@endif</option>  
                                @endforeach
                            
                        @endif   
                                
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">ثبت</button>
                </form>
            </div>
            <div class="set-media mt-5" >
                <div class="card">
                    <div class=" card-body bg-light">
                    <h4 class="text-center text-info ">تعریف مدیا</h4>
                    </div>
                </div>      
                    <form action="/media_store" method="post"> 
                        @csrf      
                        <div class="form-row "> 
                            <input type="hidden" name="order" value="media"/>
                            <div class="form-group col-md-4">
                                <label for="medianame" class="float-right">نام:</label>
                                <input type="text" class="form-control text-center" name="medianame" id="medianame" placeholder="نام" >
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mediaprice" class="float-right">قیمت:</label>
                                <input type="text" class="form-control text-center" name="mediaprice" id="mediaprice" placeholder="قیمت">
                            </div>  
                            <div class="form-group col-md-4">
                                <label for="mediamedia" class="float-right">زیرشاخه:</label>
                                <select name="mediamedia" id="mediamedia" class="form-control">
                                    <option value="0" selected>مدیای اصلی</option>
                                    @if(count($medias)>0)
                                        @foreach($medias as $media)  
                                            @if(($media->parent) === 0)
                                                <option value="{{$media->id}}">{{$media->name}}</option> 
                                            @endif 
                                        @endforeach
                                    @endif   
                                </select>
                            </div>
                            <div class="form-check col-md-3 form-check-inline">
                                <label class="form-check-label" for="mediapunch">پانچ</label>
                                <input class="form-check-input" type="checkbox" id="mediapunch" name="mediapunch">                                
                            </div>
                            <div class="form-check col-md-3 form-check-inline">
                                <label class="form-check-label" for="medialeefe">لیفه</label>
                                <input class="form-check-input" type="checkbox" id="medialeefe" name="medialeefe" >                               
                            </div>
                            <div class="form-check col-md-3 form-check-inline">
                                <label class="form-check-label" for="mediaactivity">فعال</label>
                                <input class="form-check-input" type="checkbox" id="mediaactivity" name="mediaactivity">                               
                            </div>
                        </div>
                        <input type="hidden" id="mediaorder" name="mediaorder" value="insert"/>
                        <input type="hidden" id="mediaid" name="mediaid" value=""/>
                        <button id="mediaeditcancel" onClick="cancelmediaedit();" class="btn text-secondary mediaeditcancel disabled">لغو ویرایش</button>
                        <button id="btnmediaaction" type="submit" class="btn btn-primary mediastore">ثبت</button>
                    </form>
                    <hr>
                    <hr>
                <div class="show_media">
                    <div class="card">
                        <div class="card-body bg-light">
                        <h4 class="text-center text-info ">لیست مدیای موجود </h4>
                        </div>
                    </div>
                    <table class="table table-striped table-success">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">نام</th>
                                <th class="text-center" scope="col">قیمت</th>
                                <!-- <th style="width:0px; background-color:inherit;" class="text-center invisible" scope="col">پدر مدیا</th> -->
                                <th class="text-center" scope="col">نوع مدیا</th>                                
                                <th class="text-center" scope="col">پانچ</th>
                                <th class="text-center" scope="col">لیفه</th>
                                <th class="text-center" scope="col">فعال/غیرفعال</th>
                                <th class="text-center" scope="col" >ویرایش/حذف</th>

                            </tr>
                        </thead>
                        @if(count($medias)>0)
                            <tbody>
                                @foreach($medias as $media)                            
                                    <tr>

                                        <td class="text-center">{{$media->name}}</td>
                                        <td class="text-center">{{$media->price}}</td> 
                                        <!-- <td id="mediaparentid" style="width:0px; background-color:inherit;" class="text-center invisible">
                                            {{$media->parent}}
                                        </td  > -->
                                        <td class="text-center">
                                            @if(($media->parent) === 0) مدیای اصلی @endif
                                            @if(($media->parent) > 0)
                                                @php
                                                    $i = $media->parent
                                                @endphp
                                                @foreach($medias as $media2)  
                                                    @if( ($media2->id) === $i)
                                                        {{$media2->name}} 
                                                    @endif 
                                                @endforeach
                                            @endif
                                        </td  >
                                        <td class="text-center">
                                            @if(($media->punch) === 1) دارد @endif
                                            @if(($media->punch) === 0) ندارد @endif
                                        </td>
                                        <td class="text-center">
                                            @if(($media->leefe)=== 1) دارد @endif
                                            @if(($media->leefe)=== 0) ندارد @endif
                                        </td>
                                        <td class="text-center">
                                            @if(($media->activity)=== 1) فعال @endif
                                            @if(($media->activity)=== 0) غیرفعال @endif
                                        </td>
                                        <td class="text-center">
                                        <button href="#" onClick="setmediaforedit({{ $media->id }});" class="btn btn-dark" id="btnedit" value="{{ $media->id }}">ویرایش</button>
                                        <form action="/media_delete/{{$media->id}}" method="post"> @csrf @method('DELETE') <button type="submit" class="btn btn-sm btn-danger"> حذف</button></form>
                                        </td>
                                    </tr>  
                                @endforeach
                            </tbody>
                        @endif       
                    </table>
                </div>
            </div>
            <div class="set-roll mt-5" >
                <div class="card">
                    <div class="card-body bg-light">
                    <h4 class="text-center text-info ">تعریف رول</h4>
                    </div>
                </div>
                <form action="/roll_store" method="post" > 
                    @csrf   
                    <div class="form-row ">
                        <input type="hidden" name="order" value="roll"/>
                        <div class="form-group col-md-4">
                            <label for="rollheight" class="float-right">طول:</label>
                            <input type="text" class="form-control text-center" name="rollheight" id="rollheight" placeholder="طول">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="rollwidth" class="float-right">عرض:</label>
                            <input type="text" class="form-control text-center" name="rollwidth" id="rollwidth" placeholder="عرض ">
                        </div>  
                        <div class="form-check col-md-3 form-check-inline">
                            <label class="form-check-label" for="rollactivity">فعال</label>
                            <input class="form-check-input" type="checkbox" id="rollactivity" name="rollactivity" >                                
                        </div>
                    </div>
                    <input type="hidden" id="rollorder" name="rollorder" value="insert"/>
                    <input type="hidden" id="rollid" name="rollid" value=""/>
                    <button onClick="cancelrolledit();"  class="btn text-secondary rolleditcancel disabled">لغو ویرایش</button>                                            
                    <button type="submit" id="btnrollaction" class="btn btn-primary rollstore">ثبت</button>
                </form>
                <hr>
                <hr>
                <div class="show_roll">
                    <div class="card">
                        <div class="card-body bg-light">
                        <h4 class="text-center text-info ">لیست رول‌های موجود </h4>
                        </div>
                    </div>
                    <table class="table table-striped table-warning">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">طول</th>
                                <th class="text-center" scope="col">عرض</th>
                                <th class="text-center" scope="col">فعال/غیرفعال</th>
                                <th class="text-center" scope="col" >ویرایش</th>
                            </tr>
                        </thead>
                        @if(count($rolls)>0)
                            <tbody>
                                @foreach($rolls as $roll)                            
                                    <tr>
                                        <td class="text-center">{{$roll->height}}</td>
                                        <td class="text-center">{{$roll->width}}</td>                                        
                                        <td class="text-center">
                                        @if(($roll->activity)=== 1) فعال @endif
                                        @if(($roll->activity)=== 0) غیرفعال @endif
                                        </td>
                                        <td class="text-center">
                                        <button href="#" onClick="setrollforedit({{ $roll->id }});" class="btn btn-dark" value=" {{ $roll->id }}">ویرایش</button>
                                        <form action="/roll_delete/{{$roll->id}}" method="post"> @csrf @method('DELETE') <button type="submit" class="btn btn-sm btn-danger"> حذف</button></form>
                                        </td>

                                    </tr>  
                                @endforeach
                            </tbody>
                        @endif       
                    </table>
                </div>
            </div>
        </div>
    </main>
    <?php
               if(isset($_GET["order"]))
               {
                    $hi= $_GET["order"];
                    if($hi=="media")
                    {
                            ?>
                                <script>
                                    showmedia();
                                </script>
                            <?php
                    }               
                    else if($hi == "roll")
                    {
                        ?>
                                <script>
                                    showroll();
                                </script>
                        <?php
                    }
                    else
                    {
                        ?>
                                <script>
                                    showsetting();
                                </script>
                        <?php
                    }
                }
                else
               {
                    ?>
                        <script>
                            showsetting();
                        </script>
                    <?php
                }
            ?>
</body>
</html>
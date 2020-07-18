<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/3e84b90c50.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" ></script>
    <script>
        function setmedias(id){       
            jQuery.get("getdata?id="+id+"&type=zirmedia",function(response){
                var myJson= JSON.parse(response);
                jQuery("#leefe").prop("disabled" , true);
                jQuery("#punch").prop("disabled" , true);

                if(myJson[0][0]['leefe']>0){
                    jQuery("#leefe").prop("disabled" , false );
                }
                if(myJson[0][0]['punch']>0){
                    jQuery("#punch").prop("disabled" , false );
                }
                //alert(myJson[0][0]['leefe']);
                jQuery("#zirmedia option").remove();
                for(var i=0; i<myJson[1].length ; i++){
                    jQuery('#zirmedia').append('<option value="' + myJson[1][i]['id']+ '">' + myJson[1][i]['name'] + '</option>');
                } 
            });        
        };
    </script>
    <script>
        jQuery(document).ready(function() { 
            jQuery('#height').on("input propertychange change paste keyup", function() {
                jQuery('#heightlast').text(jQuery(this).val()) ;
               // selectRolls(jQuery(this).val(),jQuery('#width').val());
            }); 
            jQuery('#width').on("input propertychange change paste keyup", function() {
                jQuery('#widthlast').text(jQuery(this).val()) ;
                //selectRolls(jQuery(this).val(),jQuery('#height').val());
            }); 
            jQuery('#number').on("input propertychange change paste keyup", function() {
                    jQuery('#numberlast').text(jQuery(this).val()) ;
            }); 
            // jQuery('#whited_up').on("input propertychange change paste keyup", function() {
            //     selectRolls(jQuery(this).val(),jQuery('#width').val());
            // });
        }); 
    </script>
    <script>
        jQuery(document).ready(function() { 
            jQuery('#punch_up_div').hide();
            jQuery('#punch_up').val("");
            jQuery('#punch_down_div').hide();
            jQuery('#punch_down').val("");
            jQuery('#punch_left_div').hide();
            jQuery('#punch_left').val("");
            jQuery('#punch_right_div').hide();
            jQuery('#punch_right').val("");

            jQuery('#whited_up_div').hide();
            jQuery('#whited_up').val("");
            jQuery('#whited_down_div').hide();
            jQuery('#whited_down').val("");
            jQuery('#whited_left_div').hide();
            jQuery('#whited_left').val("");
            jQuery('#whited_right_div').hide();
            jQuery('#whited_right').val("");
            
            jQuery("#punch").click(function () {
                if (jQuery(this).is(":checked")) {
                    jQuery("#punch_up_div").show();
                    jQuery("#punch_down_div").show();
                    jQuery("#punch_left_div").show();
                    jQuery("#punch_right_div").show();
                } else {
                    jQuery("#punch_up_div").hide();
                    jQuery("#punch_up").val("");
                    jQuery("#punch_down_div").hide();
                    jQuery("#punch_down").val("");
                    jQuery("#punch_left_div").hide();
                    jQuery("#punch_left").val("");
                    jQuery("#punch_right_div").hide();
                    jQuery("#punch_right").val("");
                }
            });

            jQuery("#whited").click(function () {
                if (jQuery(this).is(":checked")) {
                    jQuery("#whited_up_div").show();
                    jQuery("#whited_down_div").show();
                    jQuery("#whited_left_div").show();
                    jQuery("#whited_right_div").show();
                } else {
                    jQuery("#whited_up_div").hide();
                    jQuery("#whited_up").val("");
                    jQuery("#whited_down_div").hide();
                    jQuery("#whited_down").val("");
                    jQuery("#whited_left_div").hide();
                    jQuery("#whited_left").val("");
                    jQuery("#whited_right_div").hide();
                    jQuery("#whited_right").val("");
                }
            });   
        }); 

    </script>        
    <script> 
        var size1 = 0;
        var size2 = 0;
        var roll1=0;
        var roll2=0;
        var myRolls=[];
        var mySetting=[];

        jQuery(document).ready(function() { 
            jQuery.get("getdata?type=allroll",function(response){
                myRolls= JSON.parse(response);
            }); 
            jQuery.get("getdata?type=setting",function(response){
                mySetting= JSON.parse(response);
                //alert(mySetting[5]['value']);
            }); 
            jQuery("#exactsize").click(function () {
                if (jQuery(this).is(":checked")) {
                  //  alert("ghdg");
                    var sz = mySetting[5]['value'];
                    jQuery('#extsz').val(sz);
                   // alert( jQuery('#extsz').val());
                }
            });
        });
       
        function selectRolls(height,width){
            size1 = 0;
            size2 = 0;
            roll1=0;
            roll2=0;
            for(var i=0; i<myRolls.length ; i++)
            {
                if(parseInt(myRolls[i]['width'])>=parseInt(height))
                {
                    roll1 = parseInt(myRolls[i]['width']);
                    size1 = roll1 * parseInt(width);  
                    //alert (size1);                                   
                    break;
                }
            }

            for(var i=0; i<myRolls.length ; i++)
            {
                if(parseInt(myRolls[i]['width'])>=parseInt(width))
                {
                    roll2 = parseInt(myRolls[i]['width']);
                    size2 = roll2 * parseInt(height);   
                    //alert (size2);                 
                    break;
                }
            }
            if(parseInt(size1) < parseInt(size2)){
                jQuery('#bestroll').val(roll1); 
                var bstroll= parseInt(jQuery('#bestroll').val());
                var glue =  parseInt(mySetting[4]['value']);
                var perroll =  parseInt(mySetting[2]['value']);
                var hei = height / 100;
                var wid = width / 100;
                var bstrl = bstroll / 100;
                var masahat = ( bstrl * wid).toFixed(2) ;
                var mr = masahat * perroll; 
                var ttlgl = (hei * glue);
                var price =  mr + ttlgl ; 
                jQuery('#pricelast').val(price);
                jQuery('#price').val(price);

              //  alert (hei + '--' +  wid  + '--' +  masahat  + '--' + price );
            }
            else{
                jQuery('#bestroll').val(roll2);
                var bstroll= parseInt(jQuery('#bestroll').val());
                var glue =  parseInt(mySetting[4]['value']);
                var perroll =  parseInt(mySetting[2]['value']);
                var hei = height / 100;
                var wid = width / 100;
                var bstrl = bstroll / 100;
                var masahat = ( hei * bstrl).toFixed(2) ;
                var mr = masahat * perroll; 
                var ttlgl = wid * glue;
                var price = mr + ttlgl  ; 
                jQuery('#pricelast').val(price);
                jQuery('#price').val(price);

               // alert ( hei + '--' +  wid  + '--' +  masahat  + '--' + price );
            }
        };
        function selectlastroll(){
            var h1 = $.isNumeric(jQuery('#height').val());
            var h2 = $.isNumeric(jQuery('#whited_up').val());
            var h3 = $.isNumeric(jQuery('#whited_down').val());
            var h4 = $.isNumeric(jQuery('#punch_up').val());
            var h5 = $.isNumeric(jQuery('#punch_down').val());
            var h6 = $.isNumeric(jQuery('#extsz').val());
            if(!h1){
                jQuery('#height').val("0");
            }
            if(!h2){
                jQuery('#whited_up').val("0");
            }
            if(!h3){
                jQuery('#whited_down').val("0");
            }
            if(!h4){
                jQuery('#punch_up').val("0");
            }
            if(!h5){
                jQuery('#punch_down').val("0");
            }
            if(!h6){
                jQuery('#extsz').val("0");
            }
            var w1 = $.isNumeric(jQuery('#width').val());
            var w2 = $.isNumeric(jQuery('#whited_left').val());
            var w3 = $.isNumeric(jQuery('#whited_right').val());
            var w4 = $.isNumeric(jQuery('#punch_left').val());
            var w5 = $.isNumeric(jQuery('#punch_right').val());
            if(!w1){
                jQuery('#width').val("0");
            }
            if(!w2){
                jQuery('#whited_left').val("0");
            }
            if(!w3){
                jQuery('#whited_right').val("0");
            }
            if(!w4){
                jQuery('#punch_left').val("0");
            }
            if(!w5){
                jQuery('#punch_right').val("0");
            }
            var height = parseInt(jQuery('#height').val()) + parseInt(jQuery('#extsz').val()) + parseInt(jQuery('#whited_up').val()) + parseInt(jQuery('#whited_down').val()) +parseInt(jQuery('#punch_up').val()) + parseInt(jQuery('#punch_down').val());
            var width = parseInt(jQuery('#width').val()) + parseInt(jQuery('#extsz').val()) + parseInt(jQuery('#whited_left').val()) + parseInt(jQuery('#whited_right').val()) + parseInt(jQuery('#punch_left').val()) + parseInt(jQuery('#punch_right').val());
            //alert(height + '--' + width);
            selectRolls(height,width);
        };
    </script>
   
    <title>چاپ تبریز</title>
</head>
<body>
    @include('inc.navbar')
    <br> 
    @if (session('customername'))
        <h4 id="alaki" class="text-center float-right">{{ session('customername') }} خوش آمدید</h4>
    @endif
    <br>
    <br>
    @include('inc.messages')
    <br>
    <main>  
        <div class="container d-flex bg-dark">
            <div class="col-5 bg-light m-1 ">
                <div class="card col-12">
                    <div class="card-body">
                        <p class="card-title text-right">آپلود فایل</p>
                        <hr>
                        <p class="card-text text-right">
                            <span>طول:</span>
                            @if (session('heightcm'))
                            <span id="heightlast">{{ session('heightcm') }}</span>
                            @endif
                            <br>
                            <span>عرض:</span>
                            @if (session('widthcm'))
                                <span id="widthlast">{{ session('widthcm') }} </span>
                            @endif                            
                            <br>
                            <span>تعداد:</span>
                            <span id="numberlast"></span>
                        </p>
                        <p  class=" text-right"> 
                       
                            
                              <span> قیمت نهایی:</span>
                              <input id="pricelast"  style="width:90px;" value=""> 
                               <span>تومان</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-7 bg-warning m-1">
                <form action="photo_store" method ="post" enctype ="multipart/form-data">    
                    @csrf      
                    <div class="form-group">
                        <label class="float-right" for="photoupload">آپلود فایل</label>
                        <input type="file" class="form-control" name="photoupload" id="photoupload" value="ارسال فایل">
                        <label class="float-right" for="photoupload">.استفاده کنید CMYK و DPI72 برای ارسال فایل از حالت </label>
                    </div> 
                    <button type="submit" name="submitphoto" class="btn alert-success">آپلود عکس</button>
                </form>
                <form action="/submit_order" method ="post" >    
                    @csrf 
                    <input type="hidden"  name="bestroll" id="bestroll" value="" />
                    <input type="hidden"  name="extsz" id="extsz" value="" />
                    <input type="hidden"  name="price" id="price" value="" />
                    <div class="form-row mt-2">
                        <div class="form-col col-3">
                            @if (session('heightcm'))
                                <div class="form-group">
                                    <label for="height">طول</label>
                                    <input type="text" class="form-control mr-2" style="width:70px;" name="height" id="height" value="{{ session('heightcm') }}" >
                                    <span>سانتی متر</span>
                                </div>
                            @endif
                            @if (session('widthcm'))
                                <div class="form-group ">
                                    <label for="width">عرض</label>
                                    <input type="text" class="form-control mr-2" style="width:70px;" name="width" id="width" value="{{ session('widthcm') }}">
                                    <span>سانتی متر</span>
                                </div>
                            @endif
                            <div class="form-group ">
                                <label for="number">تعداد</label>
                                <input type="text" class="form-control mr-2" style="width:70px;" name="number" id="number" value="">
                                <span>عدد</span>
                            </div> 
                        </div>
                        @if (session('imagename'))
                        <div class="form-group col-9 text-center">
                            <img style="height:350px; width:370px;" src="/photos/{{ session('imagename') }}" alt="uploadedphoto">
                        </div>
                        @endif
                    </div>    
                    <div class="form-col col-md-12">
                        <h5><span id="fellllan" class="badge badge-success float-right">انتخاب نوع چاپ</span></h5>
                        <br>
                        <hr>
                        <div class="form-row ">
                            @foreach($medias as $md)
                                @if(($md->parent) === 0)
                                    <div class="form-check  col-md-4">
                                        <input onClick="setmedias({{ $md->id }});" class="form-check-input" name="media" type="radio" value="" id="defaultCheck1">
                                        <label class="form-check-label"  for="defaultCheck1">{{$md->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                            <div class="form-group col-md-12">
                                    <label for="zirmedia" class="float-right">زیرشاخه:</label>
                                    <select  name="zirmedia" id="zirmedia" class="form-control">
                                        @if(count($medias)>0)
                                            @foreach($medias as $media)  
                                                @if(($media->parent) > 0)
                                                    <option  value="{{$media->id}}">{{$media->name}}</option> 
                                                @endif 
                                            @endforeach
                                        @endif   
                                    </select>
                            </div>
                            <div class="card float-right">
                                <div class="card-body text-right">                                
                                    <input class="form-check-input" name="exactsize" type="checkbox" value="" id="exactsize">
                                    <label class="form-check-label"  for="exactsize">.چاپ به صورت اندازه دقیق قایل انجام شود</label>
                                </div>
                                <p class="card-text text-sm-right">توضیح: عموما هنگام چاپ اندازه فایل از هر طرف پنج سانتی متر کوچکتر می‌شود و سفید باقی می‌ماند</p>
                            </div> 
                            <div id="punchcard" class="card col-12" >
                                <div class="card-body">
                                    <p class="card-text">
                                        <input class="form-check-input" name="punch" type="checkbox" value="" id="punch">
                                        <label class="form-check-label"  for="punch">افزودن پانچ</label>
                                        <span class="card-title float-right">تنظیمات پانچ</span>
                                        <br>
                                        <div id="punch_up_div">
                                            <input class=" col-3" name="punch_up" type="text" value="" id="punch_up">
                                            <label   for="punch_up">بالا</label>
                                        </div>
                                        <div id="punch_down_div">
                                            <input class=" col-3" name="punch_down" type="text" value="" id="punch_down">
                                            <label for="punch_down">پایین</label>
                                        </div>
                                        <div id="punch_left_div">
                                            <input class=" col-3" name="punch_left" type="text" value="" id="punch_left">
                                            <label   for="punch_left">چپ</label>
                                        </div>
                                        <div id="punch_right_div">
                                            <input class=" col-3" name="punch_right" type="text" value="" id="punch_right">
                                            <label  for="punch_right">راست</label>
                                        </div>
                                    </p>
                                </div>
                            </div>
                            <div id="whitedcard" class="card col-12" >
                                <div class="card-body">
                                    <p class="card-text">
                                        <input class="form-check-input" name="whited" type="checkbox" value="" id="whited">
                                        <label class="form-check-label"  for="whited">افزودن سفیدی</label>
                                        <span class="card-title float-right">تنظیمات سفیدی</span>
                                        <br>
                                        <div id="whited_up_div">

                                        <input class="col-3 " name="whited_up" type="text" value="" id="whited_up" >
                                        <label for="whited_up">بالا</label>
                                        </div>
                                        <div id="whited_down_div">

                                        <input class="col-3" name="whited_down" type="text" value="" id="whited_down">
                                        <label  for="whited_down">پایین</label>
                                        </div>

                                        <div id="whited_left_div">

                                        <input class="col-3" name="whited_left" type="text" value="" id="whited_left">
                                        <label  for="whited_left">چپ</label>
                                        </div>

                                        <div id="whited_right_div">

                                        <input class="col-3" name="whited_right" type="text" value="" id="whited_right">
                                        <label   for="whited_right">راست</label>
                                        </div>

                                        
                                    </p>
                                </div>
                            </div>
                            <div id="leefecard" class="card col-12 " >
                                <div class="card-body">
                                    <p class="card-text ">
                                        <input class="form-check-input" name="leefe" type="checkbox" value="" id="leefe">
                                        <label class="form-check-label"  for="leefe">افزودن لیفه</label>
                                        <span class="card-title float-right">تنظیمات لیفه</span>
                                    </p>
                                </div>
                            </div>
                            <div class="card col-12">
                                <div class="card-body">
                                    <h5 class="card-title float-right">توضیحات شما</h5>
                                    <div class="card-text">
                                        <textarea class="form-control"  name="details" id="details" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="buy" class="btn btn-success mt-2 mb-2">افزودن به سبد خرید</button>
                        </div>
                    </div>
                </form>
                <button onClick="selectlastroll();" id="selectlastroll" class="btn btn-info float-right mr-2 mt-2 mb-2">محاسبه قیمت</button>
            </div>
        </div>
    </main>  
</body>
</html>
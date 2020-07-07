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
            jQuery.get("getdata?id="+id+"&type=zirmedia",function(response)
                {
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
                    jQuery("#media option").remove();
                    for(var i=0; i<myJson[1].length ; i++){
                        jQuery('#media').append('<option value="' + myJson[1][i]['id']+ '">' + myJson[1][i]['name'] + '</option>');
                    } 
                });        
           };
        </script>
        
    <title>چاپ تبریز</title>
</head>
<body>
    @include('inc.navbar')
    <main>  
        <div class="container d-flex bg-dark">
            <div class="col-5 bg-info m-1 ">
                <div class="card col-12">
                    <div class="card-body">
                        <p class="card-title text-right">آپلود فایل</p>
                        <hr>
                        <p class="card-text text-right">
                            <span>طول:</span>
                            <span>85 سانتی متر</span>
                            <br>
                            <span>عرض:</span>
                            <span>85 سانتی متر</span>
                            <br>
                            <span>تعداد:</span>
                            <span>85 سانتی متر</span>
                        </p>
                        <p  class=" text-right"> 
                            <span> قیمت نهایی:</span>
                            <span >32 تومان  </span>

                        </p>

                    </div>
                </div>
            </div>

            <div class="col-7 bg-danger m-1">
                <form action="photo_store" method ="post" enctype ="multipart/form-data">    
                    @csrf      
                    <div class="form-group">
                        <label class="float-right" for="photoupload">آپلود فایل</label>
                        <input type="file" class="form-control" name="photoupload" id="photoupload" value="ارسال فایل">
                        <label class="float-right" for="photoupload">.استفاده کنید CMYK و DPI72 برای ارسال فایل از حالت </label>
                    </div> 
                    <button type="submit" name="submitphoto" class="btn alert-success">آپلود عکس</button> 
                </form>
                
                <div class="form-col">
                    <div class="form-group">
                        <label for="height">طول</label>
                        <input type="text" class="form-control mr-2" style="width:50px;" name="height" id="height">
                        <span>سانتی متر</span>
                    </div>
                    <div class="form-group">
                        <label for="width">عرض</label>
                        <input type="text" class="form-control mr-2" style="width:50px;" name="width" id="width">
                        <span>سانتی متر</span>
                    </div>
                    <div class="form-group">
                        <label for="number">تعداد</label>
                        <input type="text" class="form-control mr-2" style="width:50px;" name="number" id="number">
                        <span>عدد</span>
                    </div>
                    <div class="form-group">
                        <?php if(isset($_POST[$imagename ?? ''])){
                         echo "<img style=\"height:150px; width:150px;\" src=\"/photos/{{$imagename}}\" alt=\"uploadedphoto\">";}
                         ?>
                        <img style="height:150px; width:150px;" src="/photos/1594132868.jpg" alt="uploadedphoto">
                       
                    </div>
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
                                <label for="media" class="float-right">زیرشاخه:</label>
                                <select  name="media" id="media" class="form-control">
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
                                </p>
                            </div>
                        </div>
                        <div id="whitedcard" class="card col-12" >
                            <div class="card-body">
                                <p class="card-text">
                                    <input class="form-check-input" name="whited" type="checkbox" value="" id="whited">
                                    <label class="form-check-label"  for="whited">افزودن سفیدی</label>
                                    <span class="card-title float-right">تنظیمات سفیدی</span>
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
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>  
        
   
</body>
</html>
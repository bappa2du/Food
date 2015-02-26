<style>
    .h2{
        text-align: center;
        font-weight: bold;
    }
    .blog{
        margin: 10px 0px;
        height: 400px;
    }
    .container-fluid{
        margin-top: 20px;
        //background-color: #656565;
        margin-bottom: 5px;
        padding: 0px;
    }
    .overlayBlog{
        background-color: rgba(128, 128, 128, 0.35);
        height: 400px;
        margin-top: -410px;
        z-index: 2;
        position: relative;
    }
    .blogDiv{
        margin: 15px auto;
        width: 100%;
        height: 250px;
        background-color: rgba(198, 198, 195, 0.70);
        color: #000000;
        position: absolute;
        padding: 11px 20px;
        font-weight: bold;
        text-align: center;
        font-size: 23px;
    }
    .showMap{
        margin-top: 295px;
        position: absolute;
        margin-left: 45.5%;
        padding: 10px 20px;
        font-size: 18px;
    }
    .back{
        position: absolute;
        z-index: 60;
        margin: -60px 45.5%;
        padding: 10px 20px;
        font-size: 18px;
    }
</style>
<div class="container-fluid">
    <div class="blog" id="googleMap">
    </div>
    <div class="btn btn btn-default-red-inverse back" style="display: none">Show Blog</div>
    <div class="overlayBlog">
        <div>
            <div class="blogDiv">
                <h3 style="margin-top: 0px">Our Clients Say</h3>
                <div class="clients"></div>
            </div>
        </div>
    </div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js"></script>
<script>

    var x;
    var y;
    var timer = false;
    var keepAlive = 1000;
    <?php $lat = $this->Session->read('lat'); ?>
    <?php $lng = $this->Session->read('lng'); ?>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        }
    }

    function showPosition(position) {
        x = position.coords.latitude;
        y = position.coords.longitude;
    }

    function showRestaurant()
    {
        if(typeof x != 'undefined')
        {
            window.location = "/restaurants/nearByTakeaways";
        }
    }

    window.onload = function () {
        getLocation();
        <?php if($lat): ?>
        x = <?php echo $lat; ?>;
        y = <?php echo $lng; ?>;
        assignLatLngSession(x,y);
        <?php else: ?>
        loadRestaurant();
        <?php endif; ?>
    }

    function loadRestaurant()
    {
        if(typeof x == 'undefined')
        {
            timer = setTimeout('loadRestaurant()', keepAlive);
        }
        else
        {
            initialize(x,y);
            assignLatLngSession(x,y);
        }
    }

    function assignLatLngSession(x,y)
    {
        $.ajax({
            type: "post",
            url: '<?php echo $this->webroot;?>webpages/assignLatLngSession',
            dataType: "json",
            data: {
                latitude:x,
                longitude:y
            },
            success: function(result){}
        });
    }

    function getRestaurantOnLoad(x,y){
        $.ajax({
            type: "post",
            url: '<?php echo $this->webroot;?>webpages/homePageRestaurant',
            dataType: "json",
            data: {
                lattitude:x,
                longitude:y
            },
            success: function (result) {
                if (result == 0) {
                    $("#popularRestaurant").html('');
                    $("#defaultRestaurantID").removeClass('defaultRestaurant');
                }
                else
                {
                    var gridList = '';
                    $.each(result,function(key,value){
                        gridList += '<a href="/restaurants/details/'+value.Restaurant.id+'">';
                        gridList += '<div class="rest-box">';
                        if(value.Restaurant.photo != null)
                        {
                            gridList += '<image src="/files/restaurant/photo/'+value.Restaurant.id+'/'+value.Restaurant.photo+'" width="80px" height="60px">';
                        }
                        else if(value.Restaurant.photo == null)
                        {
                            gridList += '<image src="/img/restaurant.png" width="80px" height="60px">';
                        }
                        gridList += '</div>';
                        gridList += '</a>';

                    });
                    $("#popularRestaurant").html(gridList);
                }
            },
            error: function () {
            }
        });
    }


    function initialize(x,y) {
        var myCenter=new google.maps.LatLng(x,y);
        var mapProp = {
            center:myCenter,
            zoom:11,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        };
        var marker=new google.maps.Marker({
            position:myCenter
        });
        var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

        marker.setMap(map);

        var infowindow = new google.maps.InfoWindow({
            content:"Your Home"
        });

        infowindow.open(map,marker);

    }
    //google.maps.event.addDomListener(window, 'load', initialize);


    $('body').on('click','.showMap',function(){
        $( '.overlayBlog' ).slideUp( "slow", function() {
            $('.back').css('display','block');
            //$( "#msg" ).text( $( "button", this ).text() + " has completed." );
        });
    });
    $('body').on('click','.back',function(){
        $('.back').css('display','none');
        $( '.overlayBlog' ).slideDown( "slow", function() {

        });
    });
</script>
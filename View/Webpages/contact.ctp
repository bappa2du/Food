<style>
    a:hover {
        text-decoration: underline;
        color: red;
    }



    h4 {
        color: red;
        font-weight: bold;
    }

    .panel {
        min-height: 400px;
    }

    a {
        color: rgba(108, 59, 5, 1);
        text-decoration: none;
    }

    .panel li {
        font-size: 12px;
        list-style: none;
    }

</style>

<div class="container">
    <div class="breadcrumb_menu">
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->webroot ?>">Home</a></li>
            <li class="active">Contact with Us</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-md-24">
            <div class="panel panel-myshop">
                <div class="panel-heading">
                    <h2>Contact with Us</h2>
                </div>
                <div class="panel-body">

                    <div class="well">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>About us</h4>
                                <li><a href="#">About Us</a></li>
                                <li><a href="/restaurants/suggestTakeaways">Info for Restaurants & takeaways</a></li>
                            </div>
                            <div class="col-md-8">
                                <h4>Contact us</h4>
                                <li><a href="/webpages/contact">Contact Us</a></li>
                                <!--                            <li><a href="">Media & Press</a></li>-->
                                <li><a href="/restaurants/suggestTakeaways">suggest a restaurant or takeaways</a></li>
                            </div>
                            <div class="col-md-8">
                                <h4>Other stuff</h4>
                                <li><a href="/webpages/privacyPolicy">Privacy Policy. Terms & Conditions</a></li>
                                <li><a href="/chefCareers/currentOpening">Career Opportunities</a></li>
                            </div>
                        </div>
                    </div>

                    <div class="well">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Contact us</h3>
                                <br/>
                                <p>
                                <h3 style="color: red">Call to Chef Genie
                                </h3></p>
                                <p>
                                    Our experts are available from 9am to 11pm to give you support. You can call us
                                    and let us know your problem. As soon as possible, we will sort out your problem. Before calling us, keep ready with your order.
                                <p >
                                    <i class="fa fa-mobile"></i> Our contact number is <h4>03303384455</h4>
                                </p>

                                </p>


                                <br/>
                                <p></p>
                                <h3 style="color: red">
                                    Available on instant chat
                                </h3>
                                <p>
                                    We are available on instant chat from 9am to 11:59pm.
                                <p >
                                    <i class="fa fa-laptop"></i> Start chatting
                                </p>

                                </p>
                                <br/>


                                <br/>

                                <br/>
                                <h3 style="color: red">
                                    Email to Chef Genie
                                </h3>
                                <p>
                                    Ping us to our email at any time. To do that, you have to sign up.
                                    If you have any query, click on query link to send us email or if
                                    you have any complaint, click on complaint link. The more details
                                    to give us would be easier for u to give you any solution faster.
                                    Sometimes a day or two take to reply your query/complaint.
                                </p>

                                <p style="color: red;">
                                    <i class="fa fa-envelope" style="color: rgba(108, 59, 5, 1)"></i> <a href="mailto:<?php echo COMPlAINT_EMAIL_RECEPIANT; ?>" target="_blank">Email for Complain</a>
                                </p>
                                <p style="color: red;">
                                    <i class="fa fa-envelope" style="color: rgba(108, 59, 5, 1)"></i> <a href="mailto:<?php echo QUERY_EMAIL_RECEPIANT; ?>" target="_blank">Email for Query</a>
                                </p>
                            </div>
                            <div class="col-md-12">
                                <script
                                    src="http://maps.googleapis.com/maps/api/js">
                                </script>
                                <script>
                                    var myCenter=new google.maps.LatLng(51.457020,0.040558);
                                    function initialize() {
                                        var mapProp = {
                                            center:myCenter,
                                            zoom:16,
                                            zoomControl:true,
                                            zoomControlOptions: {
                                                style:google.maps.ZoomControlStyle.SMALL
                                            },
                                            mapTypeId:google.maps.MapTypeId.ROADMAP
                                        };
                                        var map=new google.maps.Map(document.getElementById("googleMap"), mapProp);
                                        var marker=new google.maps.Marker({
                                            position:myCenter
                                        });
                                        var infowindow = new google.maps.InfoWindow({
                                            content:"Chef Genie LTD"
                                        });

                                        infowindow.open(map,marker);

                                        marker.setMap(map);
                                    }
                                    google.maps.event.addDomListener(window, 'load', initialize);
                                </script>
                                <div id="googleMap" style="height:380px;border: 4px solid #cedad4; border-radius: 20px"></div>
                                <br/>
                                <h3 style="color: red">
                                    Where we are
                                </h3>
                                <p></p>
                                <p>
                                    <strong>Chef Genie LTD </strong><br/>
                                    10 Mulberry Place  <br/>
                                    Pinnell Road <br/>
                                    Eltham <br/>
                                    SE9 6AR <br/>
                                    London <br/>
                                    United Kingdom <br/>
                                </p>
                                <p>

                                </p>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>




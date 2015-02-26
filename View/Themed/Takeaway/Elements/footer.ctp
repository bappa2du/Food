<style>
    #footer .footer-copyright {
        background: none repeat scroll 0% 0% rgba(255, 255, 255, 1);
    }
    #footer .main-footer img {
        padding-top: 0px;
    }
    #footer .main-footer .footer-links li a {
        padding: 0px;
    }
    #footer .main-footer {
        padding-top: 10px;
        padding-bottom: 20px;
    }
    #footer .footer-copyright {
        padding: 10px 0px;
    }
    #footer .main-footer .footer-links li a {
        color: #ffffff;
        font-size: 14px;
    }
    #footer .main-footer .footer-links li a:hover {
        color: #000000;
    }
    h5{
        color: #E00000;
        font-size: 16px;
    }
</style>
<footer id="footer">

<div class="container">

    <div class="main-footer">

        <div class="row">

            <div class="col-sm-6 col-md-3">

                <h5>Quick Link</h5>
                <div class="widget-content">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="footer-links padd">
                                <li><a href="/restaurants/searchTakeaways">Search Takeaways</a></li>
                                <li><a href="/restaurants/suggestTakeaways">Browse Takeaways</a></li>
                                <li><a href="/restaurants/takeaways/newRestaurants:new">New Takeaways</a></li>
                                <li><a class="cuisineRestaurant">Pizza</a></li>
                                <li><a class="cuisineRestaurant">Indian</a></li>
                                <li><a class="cuisineRestaurant">Chinese</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-sm-6 col-md-3">
                <h5>Popular City</h5>
                <div class="widget-content">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="footer-links padd">
                                <li><a class="cityRestaurant">Aberdeen</a></li>
                                <li><a class="cityRestaurant">London E</a></li>
                                <li><a class="cityRestaurant">London N</a></li>
                                <li><a class="cityRestaurant">Cambridge</a></li>
                                <li><a class="cityRestaurant">Dartford</a></li>
                                <li><a class="cityRestaurant">Leeds</a></li>
                                <li><a class="cityRestaurant">Birmingham</a></li>
                                <li><a class="cityRestaurant">York</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <h5>Hot Links</h5>
                <ul class="footer-links padd">
                    <li><a href="<?php echo $this->webroot ?>chefCareers/currentOpening">Career</a></li>
                    <li><a href="/webpages/privacyPolicy">Privacy policy / T&Cs</a></li>
                    <li><a href="#">Cookies Policy</a></li>
                    <li><a href="/webpages/contact">Contact us</a></li>
                    <li><a href="/webpages/faq">FAQs</a></li>
                </ul>
            </div>

            <div class="col-sm-6 col-md-3">
                <h5>Others</h5>
                <ul class="footer-links padd">
                    <li>
                            <a href="#">

                                <img width="99" height="29" alt="Get it on Google Play" src="/Chefgenie/img/google-play.png">

                            </a>
                    </li>
                    <li>
                            <a href="#">

                                <img width="99" height="29" alt="Get it on Google Play" src="/Chefgenie/img/google-apps.png">

                            </a>
                    </li>

                </ul>
            </div>

        </div>
    </div>
</div>

<div class="footer-copyright">

    <div class="container">

        <p>Copyright 2015 © Chefgenie. All rights reserved. Powered by&nbsp;
            <a target="_blank" href="http://tappware.com">Tappware Solutions</a>.
        </p>

        <ul class="footer-social">

            <li>
                <a target="_blank" href="https://www.facebook.com/pages/Chef-Genie/770279469711514" >
                    <span class="fa-stack fa-lg" style="color: #304EA8">
                      <i class="fa fa-circle fa-stack-2x"></i>
                      <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                    </span>
                </a>
            </li>

            <li>
                <a target="_blank" href="https://twitter.com/chefgenieuk">
                    <span class="fa-stack fa-lg" style="color: #39CBFA">
                      <i class="fa fa-circle fa-stack-2x"></i>
                      <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                    </span>
                </a>

            </li>

            <li>
                <a target="_blank" href="https://plus.google.com/">
                    <span class="fa-stack fa-lg" style="color: #D73D32">
                      <i class="fa fa-circle fa-stack-2x"></i>
                      <i class="fa fa-google-plus fa-stack-1x fa-inverse"></i>
                    </span>
                </a>

            </li>

            <li>
                <a target="_blank" href="https://www.youtube.com">
                    <span class="fa-stack fa-lg" style="color: #EC2828">
                      <i class="fa fa-circle fa-stack-2x"></i>
                      <i class="fa fa-youtube fa-stack-1x fa-inverse"></i>
                    </span>
                </a>
            </li>


        </ul>

        <!-- end .footer-social -->
    </div>

</div>


</footer>

<script src="http://code.jquery.com/jquery-1.10.2.js"></script>

<script type="text/javascript">
    $(".cityRestaurant").click(function () {
        var city = $(this).text();
        window.location = "/restaurants/takeawaysCity?city=" + city;
    });

    $(".cuisineRestaurant").click(function () {
        var cuisines = $(this).text();
        window.location = "/restaurants/takeawaysCuisine?cuisines=" + cuisines;
    });
</script>
<style type="text/css">
    .cityRestaurant, .cuisineRestaurant {
        cursor: pointer;
    }

    .col-md-6 li {
        list-style: none;
    }

    #footer a {
        color: #ffffff;
        font-size: 14px;
    }

    #footer a:hover {
        color: #000000;
        text-decoration: none;
    }

    #footer h3 {
        margin-left: 20px;
        color: #E00000;
        font-weight: bold;
    }

    #copyright {
        background-color: #ffffff;
    }

    #copyright p a {
        color: #e00000;
        font-weight: bold;
    }

    #copyright p a:hover {
        color: #000000;
        text-decoration: none;
    }

    p {
        color: #626262;
        font-size: 14px;
    }

    .footer-social li {
        float: left;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .footer-social {
        float: right;
    }


</style>
<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="/restaurants/searchTakeaways">Search Takeaways</a></li>
                    <li><a href="/restaurants/suggestTakeaways">Browse Takeaways</a></li>
                    <li><a href="/restaurants/takeaways/newRestaurants:new">New Takeaways</a></li>
                    <li><a class="cuisineRestaurant">Pizza</a></li>
                    <li><a class="cuisineRestaurant">Indian</a></li>
                    <li><a class="cuisineRestaurant">Chinese</a></li>
                </ul>
            </div>
            <div class="col-md-6">
                <h3>Popular City</h3>
                <ul>
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
            <div class="col-md-6">
                <h3>hot Links</h3>
                <ul>
                    <li><a href="<?php echo $this->webroot ?>chefCareers/currentOpening">Career</a></li>
                    <li><a href="/webpages/privacyPolicy">Privacy Policy / T&Cs</a></li>
                    <li><a href="">Cookies Policy</a></li>
                    <li><a href="/webpages/contact">Contact Us</a></li>
                    <li><a href="/webpages/faq">FAQ s</a></li>
                </ul>
            </div>
            <div class="col-md-6">
                <h3>Others</h3>
                <ul>
                    <li><a href=""><img width="99" height="29" src="/Chefgenie/img/google-play.png" alt=""/></a></li>
                    <li>&nbsp;</li>
                    <li><a href=""><img width="99" height="29" src="/Chefgenie/img/google-apps.png" alt=""/></a></li>
                </ul>
            </div>
        </div>
    </div>
    <section id="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="copy">
                        Copyright 2015 © Chefgenie. All rights reserved. Powered by
                        <a href="http://tappware.com">Tappware Solutions.</a>
                    </p>
                </div>
                <div class="col-md-12">
                    <ul class="footer-social">

                        <li>
                            <a target="_blank" href="https://www.facebook.com/pages/Chef-Genie/770279469711514">
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
                </div>
            </div>
        </div>
    </section>
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

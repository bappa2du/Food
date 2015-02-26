<style>

    #header .header-nav-bar .navbar-nav li a:hover, #header .header-nav-bar .navbar-nav li.active a {
        color: #000000;
    }

    #footer .main-footer .footer-links li a {
        color: #000;
    }

    #footer .footer-copyright a {
        font-weight: bold;
    }
    #footer .footer-copyright a:hover {
        color: #000000;
    }
    #header .header-nav-bar .navbar {
        background: none repeat scroll 0% 0% rgba(190, 0, 0, 1);
    }
    .btn{
        border-radius: 2px;
    }
    .call-to-action-section {
        border-radius: 2px;

    }
    #header .mainLogo{
        z-index: 1;
        position: relative;
    }
    #header .txtLogo{
	    margin-left: -50px;
	    position: absolute;
	    z-index: 2;
    }
    img{
    max-width: none;
    }
    .navbar {
        min-height: 100px;
    }
    .mainLogo{
        margin-left: 0px !important;
        position: relative;
        margin-top: -4px !important;
        width: 145px;
    }
    #header .small-menu{
        background-color: #423338 !important;
    }
    #header .header-nav-bar .navbar-nav li {
        padding: 7px 0px;
    }
    .navbar {
        min-height: 70px;
    }
    #header .header-nav-bar .navbar .navbar-header {
        position: relative;
        margin-bottom: 0px;
        margin-top: 0px;
    }
    .textLogo{
        width: 245px;
        margin: -82px 0px 0px -11px !important;
        position: relative;
        z-index: 1;
    }
    @media screen and (max-width: 1050px) {
        .mainLogo{
            max-width: 100px;
        }
        .textLogo{
            max-width: 140px;
            top: 17px;
        }
    }


</style>
<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,700' rel='stylesheet' type='text/css'>
<style>
    body{
        font-family: 'Ubuntu', sans-serif;
        background-color: #ededed;
    }
</style>

<header id="header">

<div class="header-nav-bar">

    <nav class="navbar navbar-default" role="navigation">

        <div class="container" style="padding-top: 5px;">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="/">
                    <img class="mainLogo" src="/chefgenie/logo.png" alt="Chefgenie">
                    <img class="textLogo" src="/chefgenie/text.png" alt="Chefgenie">
                </a>

            </div>


            <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
                <ul id="menu-menu-1" class="nav navbar-nav navbar-right">

                    <?php
                    $user = $this->UserAuth->getUser();
                    if (empty($user)): ?>
                    <li id="menu-item-2418"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2418">
                        <a title="Join" href="<?php echo $this->webroot ?>register">Register</a>
                    </li>
                    <li id="menu-item-2418"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2418">
                        <a title="Sign in" href="<?php echo $this->webroot ?>login">Sign in</a>
                    </li>

                    <?php endif; ?>
                    <li id="menu-item-2226"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2226"><a
                            title="Contact Us" href="<?php echo $this->webroot ?>chefCareers/currentOpening">Career</a>
                    </li>
                    <li id="menu-item-2418"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2418">
                        <a title="Help" data-toggle="modal" data-target="#helpModal">Help</a>
                    </li>
                    <li id="menu-item-2226"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2226"><a
                            title="Contact Us" href="<?php echo $this->webroot ?>webpages/contact">Contact </a>
                    </li>
                    <?php if(!empty($user)): ?>
                        <li id="menu-item-2418"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2418">
                            <a title="Sign in" href="<?php echo $this->webroot ?>logout">Sign out</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>

    </nav>

</div>

<!-- small menu section -->
<div class="small-menu">
    <div class="container">
        <ul class="list-unstyled list-inline">

        </ul>
    </div>
</div>

</header>

<!--modal-->
<style>
    .modal-content{
        border-radius: 0px;
    }
    .help-content{
        width: 206px;
        margin: 5px;
        border-radius: 3px;
        background-color: #d2d2d2;
        padding: 5px 11px;
        font-size: 13px;
    }


    .modal-header{
        background-color: rgba(68, 68, 68, 1);
        color: white;
    }
    .modal-body{
        min-height: 184px;
    }
    .modal-footer a{
        color: red;
        text-decoration: underline;
    }
    .modal-body a {
        font-weight: bold;
        line-height: 1.4;
    }
    .modal-body p{
        font-size: 13px;
    }
    .modal-body .btn-danger{
        background-color: rgba(159, 159, 159, 1);
    }
    .modal-header .close {
        margin-top: -8px;
        color: white;
        font-size: 45px;
    }
    .help-content-selected{
        background-color: #E00000;
        color: white;
    }


</style>


<div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">How Can We Help?</h4>
            </div>
            <div class="modal-body">
                <span>
                    <div class="row">
                        <div class="col-md-3">
                        <span id="showContent">

                            <a data-id="2">
                                <div class="help-content help-content-selected">
                                    <span>Check my order status</span>
                                </div>
                            </a>
                            <a data-id="3">
                                <div class="help-content">
                                    <span>Report any problem about the website</span>
                                </div>
                            </a>
                            <a data-id="4">
                                <div class="help-content">
                                    <span>Your review is vital</span>
                                </div>
                            </a>
                            <a data-id="5">
                                <div class="help-content">
                                    <span>
                                        What should I do if my order has been declined by the restaurant even though i have paid for it
                                    </span>
                                </div>
                            </a>
                            <a data-id="6">
                                <div class="help-content">
                                    <span>Take me to my favourite takeaways</span>
                                </div>
                            </a>
                        </span>
                        </div>
                        <div class="col-md-9">
                            <span id="viewContent">
                                <h4>Check my order status</h4>

                                <p>
                                    If you make an order and been accepted by the restaurant/takeaway, you will get a conformation to your email with details of your order. If you haven’t receive any email within few minutes, our chat is open for you. Our Customer Support Team will take care of you.
                                </p>
                            </span>
                            <h4 class="pull-left">Need More Help <a href="/webpages/contact" style="color: #E00000;text-decoration: underline">Contact with us</a></h4>
                        </div>
                    </div>
                </span>
            </div>

        </div>
    </div>
</div>

<script src="http://code.jquery.com/jquery-1.10.2.js"></script>

<script>

    var content = $('#showContent').html();

    $('body').on('click','a',function(){
        if($(this).data('id')=='2'){$("#viewContent").html(content2);$('.help-content').removeClass('help-content-selected');$(this).children('.help-content').addClass('help-content-selected');}
        if($(this).data('id')=='3'){$("#viewContent").html(content3);$('.help-content').removeClass('help-content-selected');$(this).children('.help-content').addClass('help-content-selected');}
        if($(this).data('id')=='4'){$("#viewContent").html(content4);$('.help-content').removeClass('help-content-selected');$(this).children('.help-content').addClass('help-content-selected');}
        if($(this).data('id')=='5'){$("#viewContent").html(content5);$('.help-content').removeClass('help-content-selected');$(this).children('.help-content').addClass('help-content-selected');}
        if($(this).data('id')=='6'){$("#viewContent").html(content6);$('.help-content').removeClass('help-content-selected');$(this).children('.help-content').addClass('help-content-selected');}
    });





    var content2 = '<h4>Check my order status</h4>'+
                    '<p>If you make an order and been accepted by the restaurant/takeaway, you will get a conformation to your email with details of your order. If you haven’t receive any email within few minutes, our chat is open for you. Our Customer Support Team will take care of you.<p>';
        

    var content3 = '<h4>Report any problem about the website</h4>'+
        '<p>Our site is designed for the customer to use in an easiest way. </p>'+
        '<p>If you find any difficulties of using our site, we would appreciate your suggestion about our site. Please fill up the report form to let us know about the problem that you noticed. </p>';

    var content4 = '<h4>Your review is vital</h4>'+
        '<p>Reviews are the secret sauce that keep our takeaways and restaurants performing to the highest standards. Its the only way we can ensure you find the best meal every time.If it’s early, on time, delivered with a smile, hot and tasty, or the restaurant went the extra mile to make you happy – then Chefgenie need to know! Alternatively if it was late, didn\'t taste great, the food was cold, the order was wrong then the only way we can ensure this doesn\'t happen again is through your review. Please take a few seconds to drop us a few words so we can help you and others to keep getting the service you deserve through ChefGenie.</p>'+
        '<p>To leave a review, login to your account, go to the homepage and click the \'Leave a review\' button in the \'Your previous orders\' section of the page.Alternatively, you can leave a review from your Order history page. If you want to tell Chefgenie about a problem with the website or our Customer Service team, drop us an email at support@chefgenie.co.uk so we can fix it.</p>';

    var content5 = '<h4>What should I do if my order has been declined by the restaurant even though i have paid for it</h4>'+
        '<p><strong>It\'s very rare for this to happen as we have ensured the takeaway listing that comes up through your postcode search is ready and able to deliver.</strong></p>'+
        '<p>Don\'t worry! If your order has been cancelled by the restaurant after you paid, our payment partners will be notified automatically and the money should be back on your balance within a few days.To place a new order, go to our homepage and find an alternative restaurant, then order in the usual way If you\'ve got any further questions, please chat live with one of our Customer Care advisors who are their to ensure you remain completely satisfied..</p>'+
        '<p>For more information about payments please refer to our terms and conditions.</p>';

    var content6 = '<h4>Take me to my favourite takeaways.</h4>'+
        '<p>ChefGenie users like you recommend thousands of restaurants every day, letting everyone know what’s good and what’s not. After you’ve popped in your postcode, you’ll see most of the restaurants near you have a star rating. The stars will tell you what the Chefgenie community think. To get the lowdown and the real honest truth, click on the stars to see people’s personal reviews. At Chefgenie, you as the people have the power.</p>'+
        '<p>Of course the proof of the pudding is in the eating! When you’ve had your takeaway, make sure you leave a review so that the rest of the Chefgenie community can find the best takeaways too.The restaurants need to know what needs fixing in order to fix it. Ratings & Reviews are the best way to ensure you get the best meal, delivered on time to your door.</p>';
</script>

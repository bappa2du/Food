<style>
    #nav-bg {
        background: url("<?php echo $this->webroot;?>Chefgenie/img/Nav-bg-right-left.png") repeat-x scroll 0 0 white;
        height: 65px;
        position: relative;
    }

    .popover {
        position: absolute;
        display: block;
        float: left;
        margin: 20px;
    }

    .popover.bottom {
        margin-top: 76px;
        margin-left: 441px;
    }

    a {
        cursor: pointer
    }

    .header-con {
        border-bottom: 5px solid #423338;
        background: none repeat scroll 0% 0% rgba(190, 0, 0, 1);
        height: 77px;
        padding-top: 8px;
    }

    .mainNav {
        background-color: rgba(190, 0, 0, 1);
        border-radius: 4px;
        color: white;
        display: inline-block;
        float: right;
        font-size: 12px;
        line-height: 20px;
        margin: -74px 0px 0px;
        padding: 15px 15px;
        text-align: right;
        vertical-align: top;
        width: auto;
        font-weight: bold;
    }

    .mainNav li a {
        color: rgba(255, 255, 255, 1);
        font-size: 14px;
        text-transform: uppercase;
    }

    .mainNav li a:hover {
        color: red;
    }

    .mainNav li {
        border-right: 0px;
    }

    #footer {
        padding-top: 15px;
    }

    .order-heading {
        background-color: #ccc;
        color: #ed0000 !important;
        font-weight: bold;
    }

    ul.restaurant-cuisine li.active, ul.restaurant-cuisine li:hover, ul.restaurant-cuisine li:focus {
        background-color: #E00000 !important;
        border-right: 10px solid #E00000 !important;
    }

    ul.nav-tabs li a {
        color: #000 !important;
    }

    #header {
        margin-bottom: 15px;
    }

    .mainLogo{
        margin-left: 0px !important;
        position: relative;
        margin-top: -24px !important;
        width: 145px;
    }

    .textLogo{
        width: 245px;
        margin: -279px 0px 0px 138px !important;
    }

    .navbar-fixed-top {
        position: relative;
        margin-top: -66px;
        z-index: 2;
    }
    .mainNav li a:hover, a.button-booking:hover {
        color: rgb(224, 0, 0) !important;
    }
    .breadcrumb_menu
    {
        background: none repeat scroll 0 0 #676767;
        padding: 4px 0;
        position: relative;
        width: 100%;
        float: right;
        border-radius: 3px;
        text-align: right;
        margin-top: -18px;
        margin-bottom: 20px;

    }
    .breadcrumb li a:hover{
        color:red;
        text-decoration: none;
    }
    .breadcrumb li{
        font-weight: bold;
        font-size: 15px;
    }
    .breadcrumb li a{
        font-weight: bold;
        font-size: 15px;
        color: #ddd;
    }
    .breadcrumb li:hover{
        color:red;
    }

    .form-control:focus {
        border-color: #e00000;
        box-shadow: 0 0 8px rgba(224, 0, 0, 0.60);
        border-radius: 2px;
    }
    .active{
        cursor: pointer;
    }
    #footer{
        border-top: 2px solid #676767;
    }




</style>
<header id="header">
    <!-- Fixed navbar -->
    <div class="navbar navbar-myshop navbar-fixed-top header-con" role="navigation">
        <div class="container" style="height: 130px">
            <div class="row" style="height: 130px">
                <div class="col-md-6 col-sm-6">
                    <a class="navbar-brand" href="/">
                        <img class="mainLogo" src="/chefgenie/logo.png" alt="Chefgenie">
                        <img class="mainLogo textLogo" src="/chefgenie/text.png" alt="Chefgenie">
                    </a>
                </div>
                <div class="col-md-18 col-sm-18 pull-right">

                    <div class="row" style="margin-top:76px;">
                        <ul class="mainNav">
                            <li>
                                <a href="<?php echo $this->webroot ?>"><i class="fa fa-home"></i></a>
                            </li>
                            <?php
                            $user = $this->UserAuth->getUser();
                            if (empty($user)): ?>
                                <li>
                                    <a href="<?php echo $this->webroot ?>register">Join</a>
                                </li>
                                <li>
                                    <a href="<?php echo $this->webroot ?>login">Sign in</a>
                                </li>
                            <?php else: ?>
                                <li>
                                    <a href="<?php echo $this->webroot ?>account">My Dashboard</a>
                                </li>

                                <li>
                                    <a href="<?php echo $this->webroot ?>orders/orderList" ><span>My Order</span></a>
                                </li>
                                <li>
                                    <a href="<?php echo $this->webroot ?>orders/checkout">My Cart</a>
                                </li>
                            <?php endif; ?>

                            <!--<li>
                                <a href="<?php /*echo $this->webroot */?>chefCareers/myCareer" >Career</a>
                            </li>-->

                            <li>
                                <a title="Help" data-toggle="modal" data-target="#helpModal">Help</a>
                            </li>
                            <li>
                                <a href="<?php echo $this->webroot ?>webpages/contact" title="Contact">Contact</a>
                            </li>
                            <?php if(!empty($user)): ?>
                                <li>
                                    <a href="<?php echo $this->webroot ?>logout">Sign Out</a>
                                </li>
                            <?php endif; ?>

                        </ul>
                        
                        <div id="item_add_mgs" class="popover bottom" style="display: none">
                            <div class="arrow"></div>
                            <div class="popover-content">
                                <p>
                                    Added to your cart.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</header>

<style>
    #helpModal .modal-content{
        border-radius: 0px;
    }
    #helpModal .help-content{
        margin: 5px;
        border-radius: 2px;
        background-color: #d2d2d2;
        padding: 6px;
        font-size: 13px;
        color: #464646;
    }
    #helpModal .help-content-selected{
        background-color: #e00000;
        color: #ffffff;
    }


    #helpModal .modal-dialog{
        margin: 73px auto;
    }
    #helpModal .modal-content{
        line-height: 1.6;
    }
    #helpModal .modal-title {
        margin: 0px;
        line-height: 1.42857;
        font-size: 19px;
        color: white;
        font-weight: bold;
    }
    #helpModal .modal-content a{
        font-weight: bold;
    }
    #helpModal .modal-content a:hover{
        text-decoration: none;
    }
    #helpModal .modal-content h4{
        color: #e00000;
        font-weight: bold;
        font-size: 20px;
    }
    #helpModal .modal-header{
        background-color: rgba(68, 68, 68, 1);
        color: white;
    }
    #helpModal .modal-header .close {
        margin-top: -8px;
        color: white;
        font-size: 45px;
    }
    #helpModal .modal-body{
        border: 0px;
    }
    #helpModal .modal-header{
        border-bottom: 0px;
    }


</style>


<div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel" style="color: #ffffff">How Can We Help?</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
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
                                    <span>Put your review</span>
                                </div>
                            </a>
                            <a data-id="5">
                                <div class="help-content">
                                    <span>What should I do if my order has declined by the restaurant though i have paid for it.</span>
                                </div>
                            </a>
                            <a data-id="6">
                                <div class="help-content">
                                    <span>Take me to my favourite takeaways.</span>
                                </div>
                            </a>
                            </span>
                    </div>
                    <div class="col-md-18">
                        <div id="viewContent">
                            <h4>Check my order status</h4>

                            <p>
                                If you make an order and been accepted by the restaurant/takeaway, you will get a conformation to your email with details of your order. If you haven’t receive any email within few minutes, our chat is open for you. Our Customer Support Team will take care of you.
                            </p>
                        </div>
                        <br/>
                        <span>
                            <h4 class="pull-left" style="color: grey">Need More Help <a href="/webpages/contact" style="color: #E00000;text-decoration: underline" target="_blank">Contact with us</a></h4>
                        </span>
                    </div>
                </div>
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
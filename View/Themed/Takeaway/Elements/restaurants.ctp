<style>
    .btn-default-red {
        border: 1px solid #2DB34B;
        color: #2DB34B;
    }

    .btn-default-red:hover, .btn-default-red:focus, .btn-default-red:active, .btn-default-red.active {
        background-color: #2DB34B;
        color: #FFF;
    }

    .latest-from-blog .blog-latest {
        border-radius: 2px;
    }
    .blog-latest{
        background-color: white;
    }
    .latest-from-blog .blog-latest img {
        height: 88px;
        width: 100%;
        border-radius: 2px;
    }
    .latest-from-blog .blog-latest {
        position: relative;
        width: 100%;
        height: 215px;
        margin: 30px 0px 0px;
        padding: 10px;
        text-align: left;
        border: 1px solid #CCC;
        border-radius: 5px;
    }
    .btn-default-red-inverse {
        padding: 2px 5px 2px 5px;
        border: 1px solid #E00000;
        background: none repeat scroll 0% 0% #E00000;
        color: #FFF;
        border-radius: 2px;
        font-size: 13px;
    }
    .latest-from-blog .blog-latest p {
        margin: 8px 0px 8px;
        color: #666;
        font-size: 13px;
        line-height: 1.3;
    }
    .latest-from-blog .btn-default-red-inverse > .fa {
        font-size: 14px;
        padding: 5px;
    }
    #header .small-menu{
        background-color: #E00000;
    }
    .restaurantInfo{
        font-size: 13px;
        /* text-align: center; */
        margin: 0px 0px !important;
        bottom: 0px;
        background-color: rgba(128, 128, 128, 1);
        padding: 10px !important;
        width: 100%;
        z-index: 200;
        position: absolute;
        cursor: pointer;
        vertical-align: bottom;
    }
    .latest-from-blog .blog-latest img {
        height: 100px;
        width: 100%;
        border-radius: 2px;
        border: 1px solid rgba(203, 203, 203, 1);
    }
    .latest-from-blog .blog-latest:hover{
        box-shadow: 0px 0px 10px #e00000;
        cursor: pointer;
    }

    figure h5{
        color: #FFF84E;
    }
    .latest-from-blog .blog-latest p{
        color: #000000;
    }
    .col-md-5 .btn{
        padding: 0px 7px;
        font-size: 12px;
    }
    .view-menu-btn{
        line-height: 1;
        padding: 4px 6px;
        top: 71px;
        position: absolute;
        right: 0px;
    }
    @media screen and (max-width: 991px) {
        .latest-from-blog .blog-latest p{
            display: none;
        }
    }
</style>

<div class="latest-from-blog text-center">
    <div class="container">
        <br/>

        <h2 style="font-size: 32px">Popular Takeaways in Your Area</h2>



        <div class="row">
            <?php foreach ($restaurants as $key => $restaurant): ?>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="blog-latest">
                        <div class="row" style="margin: auto 0px auto 0px">
                            <div class="col-md-6" style="padding: 0px">
                                <?php if (isset($restaurant['Restaurant']['photo'])):
                                    echo $this->Html->image('/files/restaurant/photo/' . $restaurant['Restaurant']['id'] . '/' . $restaurant['Restaurant']['photo'], array('alt' => $restaurant['Restaurant']['name']));
                                else : ?>
                                    <img src="/img/restaurant.png"/>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6" style="padding-right: 0px;padding-left: 10px;">
                                <p style="color: red">
                                    <?php
                                    if ($restaurant['Cusine']):
                                        $loopCount = 0;
                                        $sep = '<br/>';
                                        foreach ($restaurant['Cusine'] as $resType):
                                            if ($loopCount > 0) {
                                                echo $sep;
                                            }
                                            echo '<i class="fa fa-gift"></i> '.trim($resType['name']);
                                            $loopCount++;
                                        endforeach;
                                    endif;
                                    ?>
                                </p>

                            </div>
                            <div class="col-md-12" style="padding-left: 0px">
                                <p style="font-size: 12px">
                                    <strong><i class="fa fa-map-marker"></i></strong>
                                    <?php echo $restaurant['Restaurant']['address']; ?>
                                </p>
                                <h5 style="text-align: center;position: absolute"><i class="fa fa-cutlery"></i> <?php echo $restaurant['Restaurant']['name']; ?></h5>
                                <a class="btn btn-xs btn-warning view-menu-btn" href="<?php echo $this->webroot . 'restaurants/details/' . $restaurant['Restaurant']['id'] ?>">View Menu >></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
        <!--end .row main-->
    </div>
    <!--end container-->
</div>
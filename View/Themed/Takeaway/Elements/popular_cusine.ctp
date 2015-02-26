<style>
    .category-boxes-icons .category-boxes-item figure {
        border-radius: 2px;
    }

    .category-boxes-icons .category-boxes-item {
        border-radius: 2px;
    }
    .category-boxes-item{
        background-color: white;
    }
    .category-boxes-icons .category-boxes-item {
        position: relative;
        overflow: hidden;
        margin-bottom: 20px;
        height: 150px;
        width: 100%;
        padding: 0px;
        border: 1px solid transparent;
        border-radius: 7px;
        background: none repeat scroll 0% 0% #FFF;
        box-sizing: border-box;
    }
    .category-boxes-item .btn-default-white{
        padding: 1px 3px;
        font-size: 12px;
    }
    .category-boxes-icons .category-boxes-item figure h4{
        font-size: 17px;
    }
</style>
<div class="category-boxes-icons">
    <div class=" container">
        <div class="row">

            <div class="slide-heading text-center">
                <h2>Popular Cuisines</h2>
                <hr/>
            </div>

            <?php foreach ($order as $cusine): ?>
                <div class="col-md-2 col-sm-6 col-xs-6 text-center">
                    <div class="category-boxes-item">
                        <figure>
                            <?php
                            if (!empty($cusine['cusines']['image']))
                                echo $this->Html->image('/files/cusine/image/' . $cusine['cusines_restaurants']['cusine_id'] . '/' . $cusine['cusines']['image'], array('class' => 'img-responsive', 'alt' => $cusine['cusines']['name']));
                            else {
                                ?>
                                <img height="130" src="/cuisines/Chinese.jpg"/>
                            <?php
                            }
                            ?>
                            <h4><?php echo $cusine['cusines']['name']; ?></h4>
                            <figcaption>
                                <a href="restaurants/index/Search_cuisines:<?php echo $cusine['cusines_restaurants']['cusine_id']; ?>"
                                   class="btn btn-default-white">
                                    <i class="fa fa-cutlery"></i>
                                    View in Restaurant
                                </a>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>
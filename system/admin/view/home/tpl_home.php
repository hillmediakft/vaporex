<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Admin <small>kezdőoldal</small>
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="admin/home">Kezdőoldal</a> 
                </li>
            </ul>
        </div>
        <!-- END PAGE TITLE & BREADCRUMB-->
        <!-- END PAGE HEADER-->

        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
              <!-- echo out the system feedback (error and success messages) -->
                <?php $this->renderFeedbackMessages(); ?>
            </div>
            <!-- BEGIN DASHBOARD STATS -->

            <!--
            <?php if ($user->hasAccess('menu_rendezvenyek')) { ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat yellow">
                    <div class="visual">
                        <i class="fa fa-gavel"></i>
                    </div>
                    <div class="details">
                        <div class="number">

                        </div>
                        <div class="desc">
                            Rendezvények
                        </div>
                    </div>
                    <a href="admin/rendezvenyek" class="more">
                        Tovább <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php } ?>
            <?php if ($user->hasAccess('menu_szolgaltatasok')) { ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat purple-plum">
                    <div class="visual">
                        <i class="fa fa-star"></i>
                    </div>
                    <div class="details">
                        <div class="number">

                        </div>
                        <div class="desc">
                            Szolgáltatások
                        </div>
                    </div>
                    <a href="admin/szolgaltatasok" class="more">
                        Tovább <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php } ?> -->
        
            <?php if ($user->hasAccess('menu_products')) { ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat green-turquoise">
                    <div class="visual">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="details">
                        <div class="number">

                        </div>
                        <div class="desc">
                            Termékek
                        </div>
                    </div>
                    <a href="admin/products" class="more">
                        Tovább <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php } ?>  
            <!--
            <?php if ($user->hasAccess('menu_pages')) { ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat grey-silver">
                    <div class="visual">
                        <i class="fa fa-file"></i>
                    </div>
                    <div class="details">
                        <div class="number">

                        </div>
                        <div class="desc">
                            Eladások
                        </div>
                    </div>
                    <a href="admin/sales" class="more">
                        Tovább <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php } ?>
        </div> -->

        
        
        <div class="row">
            <!-- BEGIN DASHBOARD STATS -->
             <?php if ($user->hasAccess('menu_pages')) { ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense">
                    <div class="visual">
                        <i class="fa fa-file"></i>
                    </div>
                    <div class="details">
                        <div class="number">

                        </div>
                        <div class="desc">
                            Szerkeszthető oldalak
                        </div>
                    </div>
                    <a href="admin/pages" class="more">
                        Tovább <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php } ?>
             <?php if ($user->hasAccess('menu_register_subscribe')) { ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat green-seagreen">
                    <div class="visual">
                        <i class="fa fa-file-text-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">

                        </div>
                        <div class="desc">
                            Regisztráltak
                        </div>
                    </div>
                    <a href="admin/register_subscribe" class="more">
                        Tovább <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php } ?>
			<!--
             <?php if ($user->hasAccess('menu_offices')) { ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat yellow-casablanca">
                    <div class="visual">
                        <i class="fa fa-desktop"></i>
                    </div>
                    <div class="details">
                        <div class="number">

                        </div>
                        <div class="desc">
                            Irodák
                        </div>
                    </div>
                    <a href="admin/offices" class="more">
                        Tovább <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php } ?> -->
             <?php if ($user->hasAccess('menu_settings')) { ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-chambray">
                    <div class="visual">
                        <i class="fa fa-cogs"></i>
                    </div>
                    <div class="details">
                        <div class="number">

                        </div>
                        <div class="desc">
                            Beállítások
                        </div>
                    </div>
                    <a href="admin/settings" class="more">
                        Tovább <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
             <?php } ?>
            <?php if ($user->hasAccess('menu_users_list')) { ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison">
                    <div class="visual">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="details">
                        <div class="number">

                        </div>
                        <div class="desc">
                            Felhasználók
                        </div>
                    </div>
                    <a href="admin/users" class="more">
                        Tovább <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php } ?>
            <?php if (!$user->hasAccess('menu_users_list')) { ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison">
                    <div class="visual">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="details">
                        <div class="number">

                        </div>
                        <div class="desc">
                            Profilom
                        </div>
                    </div>
                    <a href="admin/users/profile/<?php echo Session::get('user_id');?>" class="more">
                        Tovább <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php } ?>
        </div><!-- END ROW-->         
        
        
        <!-- END DASHBOARD STATS -->
        <div class="clearfix"></div>
<!--        <div class="row ">
            <div class="col-md-6 col-sm-6">
                <div class="portlet box blue-steel">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-check"></i>Modulok
                        </div>

                    </div>	
                    <div class="portlet-body">
                        <h4>Oldalak</h4>
                        <p>A weblap egyes oldalai szerkeszthetők, a szövegek szövegszerkesztő-szerű felületen módosíthatók. Módosítható a title és descriptipn elem is. Ezek módosításakor ügyeljen arra, hogy keresőoptimalizálás szempontjai szerint történjen a változtatás.</p>
                        <h4>Egyéb tartalom</h4>
                        <p>A jobb oldali sáv és a footer bemutatkozó szövege szerkeszthető.</p>

                    </div>
                </div>
            </div>	

            <div class="col-md-6 col-sm-6">
                <div class="portlet box green-haze">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-check"></i>Tennivalók
                        </div>

                    </div>	
                    <div class="portlet-body">
                        Ez a portlet body
                    </div>
                </div>
            </div>	
        </div>

-->


    </div> <!-- END PAGE CONTAINER-->    
</div> <!-- END PAGE -->
</div> 	<!-- END CONTAINER -->

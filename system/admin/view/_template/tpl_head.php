<!DOCTYPE html>
<!--[if IE 8]> <html lang="hu" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="hu" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="hu" class="no-js">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>V-Framework | <?php echo $title; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="<?php echo $description; ?>" name="description" />
        <meta content="" name="author" />
        <base href="<?php echo BASE_URL; ?>">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->        
        <link href="<?php echo ADMIN_ASSETS; ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo ADMIN_ASSETS; ?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo ADMIN_ASSETS; ?>plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->

        <!-- OLDALSPECIFIKUS CSS LINKEK -->
        <?php
        foreach ($this->css_link as $value) {
            echo $value;
        }
        ?>


        <!-- END PAGE LEVEL PLUGIN STYLES -->
        <!-- BEGIN THEME STYLES -->
        <link href="<?php echo ADMIN_CSS; ?>components.css" id="style_components" rel="stylesheet" type="text/css"/>
        <link href="<?php echo ADMIN_CSS; ?>plugins.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo ADMIN_CSS; ?>layout.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo ADMIN_CSS; ?>darkblue.css" rel="stylesheet" type="text/css" id="style_color"/>
        <link href="<?php echo ADMIN_CSS; ?>custom.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME STYLES -->
        <link rel="shortcut icon" href="<?php echo ADMIN_IMAGE; ?>favicon.ico" />


        <?php if (isset($ckeditor) && $ckeditor === true) { ?>
            <script type="text/javascript" src="<?php echo ADMIN_ASSETS; ?>plugins/ckeditor/ckeditor.js"></script>
        <?php } ?>



    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="page-header-fixed page-quick-sidebar-over-content page-style-square">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="admin/home">
                        <img src="<?php echo ADMIN_IMAGE; ?>logo.png" alt="logo" class="logo-default"/>
                    </a>
                    <div class="menu-toggler sidebar-toggler hide">
                        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                    </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-user">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img alt="" class="img-circle" src="<?php echo Config::get('user.upload_path') . Session::get('user_photo'); ?>"/>
                                <span class="username username-hide-on-mobile"><?php echo Session::get('user_name'); ?><i class="fa fa-angle-down"></i></span>

                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="admin/users/profile/<?php echo Session::get('user_id'); ?>">
                                        <i class="fa fa-user"></i> Profilom </a>
                                </li>

                                <li class="divider">
                                </li>
                                <!--						<li>
                                                                                        <a href="extra_lock.html">
                                                                                        <i class="fa fa-lock"></i> Képernyő zárolása </a>
                                                                                </li>  -->
                                <li>
                                    <a href="admin/login/logout">
                                        <i class="fa fa-key"></i> Kijelentkezés </a>
                                </li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <div class="clearfix"></div>	


        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse collapse">        
                    <!-- BEGIN SIDEBAR MENU -->
                    <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                        <li class="sidebar-toggler-wrapper">
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <div class="sidebar-toggler">
                            </div>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                        </li>
                        <?php if ($user->hasAccess('menu_home')) { ?>
                            <li class="<?php echo ($this->registry->controller == 'home') ? 'active' : ''; ?>">
                                <a href="admin/home">
                                    <i class="fa fa-home"></i> 
                                    <span class="title">Kezdőoldal</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        <?php } ?>
                        <!-- MUNKA MENÜ 		
                        <?php if ($user->hasAccess('menu_rendezvenyek')) { ?>
                                            <li class="<?php echo ($this->registry->controller == 'rendezvenyek') ? 'active' : ''; ?>">
                                                <a href="javascript:;">
                                                    <i class="fa fa-gavel"></i> 
                                                    <span class="title">Rendezvények</span>
                                                    <span class="arrow "></span>
                                                </a>
                                                <ul class="sub-menu">
                                                    <li class="<?php echo ($this->registry->controller == 'rendezvenyek' && $this->registry->action == 'index') ? 'active' : ''; ?>">
                                                        <a href="admin/rendezvenyek">
                                                            Rendezvények listája</a>
                                                    </li>
                                                    <li class="<?php echo ($this->registry->action == 'new_job') ? 'active' : ''; ?>">
                                                        <a href="admin/rendezvenyek/uj_rendezveny">
                                                            Új rendezvény</a>
                                                    </li>


                                                </ul>
                                            </li>	
                        <?php } ?>
                        -->
                        <!-- CÉGEK BLOG --> 
                        <?php if ($user->hasAccess('menu_hirek')) { ?>
                            <li class="last <?php echo ($this->registry->controller == 'blog') ? 'active' : '';?>">
                                <a href="javascript:;">
                                    <i class="fa fa-file-text"></i> 
                                    <span class="title">Hírek</span>
                                    <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="<?php echo ($this->registry->controller == 'blog' && $this->registry->action == 'index') ? 'active' : '';           ?>">
                                        <a href="admin/blog">Bejegyzések</a>
                                    </li>
                                    <li class="<?php echo ($this->registry->controller == 'blog' && $this->registry->action == 'new_blog') ? 'active' : '';           ?>">
                                        <a href="admin/blog/insert">Új bejegyzés</a>
                                    </li>
                                    <li class="<?php echo ($this->registry->controller == 'blog' && $this->registry->action == 'category') ? 'active' : '';           ?>">
                                        <a href="admin/blog/category">Kategóriák</a>
                                    </li>
                                </ul>
                            </li>	
                        <?php } ?>
                        <!--  CÉGEK MENÜ VÉGE -->

                        <!-- TERMÉKEK MENÜ -->	
                        <?php if ($user->hasAccess('menu_products')) { ?>
                            <li class="<?php echo ($this->registry->controller == 'products') ? 'active' : ''; ?>">
                                <a href="javascript:;">
                                    <i class="fa fa-shopping-cart"></i> 
                                    <span class="title">Termékek</span>
                                    <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="<?php echo ($this->registry->controller == 'products' && $this->registry->action == 'index') ? 'active' : ''; ?>">
                                        <a href="admin/products">
                                            Termékek listája</a>
                                    </li>
                                    <li class="<?php echo ($this->registry->action == 'new_product') ? 'active' : ''; ?>">
                                        <a href="admin/products/new_product">
                                            Új termék hozzáadása</a>
                                    </li>
                                    <li class="<?php echo ($this->registry->action == 'category') ? 'active' : ''; ?>">
                                        <a href="admin/products/category">
                                            Termék kategóriák</a>
                                    </li>
                                    <li class="<?php echo ($this->registry->action == 'category_insert') ? 'active' : ''; ?>">
                                        <a href="admin/products/category_insert">
                                            Új kategória hozzáadása</a>
                                    </li>
                                </ul>
                            </li>	
                        <?php } ?>
                        <!-- TERMÉKEK MENÜ VÉGE -->                         

                        <!-- REFERENCIÁK -->
                        <?php if ($user->hasAccess('menu_referenciak')) { ?>
                            <li class="<?php echo ($this->registry->controller == 'projects') ? 'active' : ''; ?>">
                                <a href="javascript:;">
                                    <i class="fa fa-list"></i> 
                                    <span class="title">Referenciák</span>
                                    <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="<?php echo ($this->registry->controller == 'projects' && $this->registry->action == 'index') ? 'active' : ''; ?>">
                                        <a href="admin/projects">
                                            Referenciák listája</a>
                                    </li>
                                    <li class="<?php echo ($this->registry->action == 'new_project') ? 'active' : ''; ?>">
                                        <a href="admin/projects/new_project">
                                            Új referencia hozzáadása</a>
                                    </li>
                                    <li class="<?php echo ($this->registry->action == 'category') ? 'active' : ''; ?>">
                                        <a href="admin/projects/category">
                                            Referencia kategóriák</a>
                                    </li>
                                    <li class="<?php echo ($this->registry->action == 'category_insert') ? 'active' : ''; ?>">
                                        <a href="admin/projects/category_insert">
                                            Új kategória hozzáadása</a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- REFERENCIÁK VÉGE -->
                        
                        <!-- GYAKORI KÉRDÉSEK -->
                        <?php if ($user->hasAccess('menu_gyik')) { ?>
                            <li class="<?php echo ($this->registry->controller == 'gyik') ? 'active' : ''; ?>">
                                <a href="javascript:;">
                                    <i class="fa fa-question-circle"></i> 
                                    <span class="title">Gyakori kérdések</span>
                                    <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="<?php echo ($this->registry->controller == 'gyik' && $this->registry->action == 'index') ? 'active' : ''; ?>">
                                        <a href="admin/gyik">
                                            GYIK listája</a>
                                    </li>
                                    <li class="<?php echo ($this->registry->action == 'new_gyik') ? 'active' : ''; ?>">
                                        <a href="admin/gyik/new_gyik">
                                            Új kérdés hozzáadása</a>
                                    </li>
                                    <li class="<?php echo ($this->registry->action == 'category') ? 'active' : ''; ?>">
                                        <a href="admin/gyik/category">
                                            GYIK kategóriák</a>
                                    </li>
                                    <li class="<?php echo ($this->registry->action == 'category_insert') ? 'active' : ''; ?>">
                                        <a href="admin/gyik/category_insert">
                                            Új kategória hozzáadása</a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- REFERENCIÁK VÉGE -->                        

                        <!-- SZERKESZTHETŐ OLDALAK -->
                        <?php if ($user->hasAccess('menu_pages')) { ?>
                            <li class="<?php echo ($this->registry->controller == 'pages' || $this->registry->controller == 'content') ? 'active' : ''; ?>">
                                <a href="javascript:;">
                                    <i class="fa fa-files-o"></i> 
                                    <span class="title">Oldalak</span>
                                    <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="<?php echo ($this->registry->controller == 'pages') ? 'active' : ''; ?>">
                                        <a href="admin/pages">Oldalak listája</a>
                                    </li>

                                    <li class="<?php echo ($this->registry->controller == 'content') ? 'active' : ''; ?>"> 
                                        <a href="admin/content">Egyéb tartalom</a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>


                        <!-- DOKUMENTUMOK -->
                        <?php if ($user->hasAccess('menu_dokumentumok')) { ?>
                            <li class="nav-item <?php echo ($this->registry->controller == 'documents') ? 'active' : ''; ?> ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-upload"></i>
                                    <span class="title">Dokumentumok</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item <?php echo ($this->registry->controller == 'documents' && $this->registry->action == 'index') ? 'active' : ''; ?>">
                                        <a href="admin/documents" class="nav-link ">
                                            <span class="title">Feltöltött dokumentumok</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?php echo ($this->registry->action == 'new_document') ? 'active' : ''; ?>">
                                        <a href="admin/documents/insert" class="nav-link ">
                                            <span class="title">Új feltöltés</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?php echo ($this->registry->action == 'category') ? 'active' : ''; ?>">
                                        <a href="admin/documents/category" class="nav-link ">
                                            <span class="title">Kategóriák</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- END DOKUMENTUMOK -->                             



                        <!-- ADMIN USERS -->
                        <?php if ($user->hasAccess('menu_users')) { ?>
                            <li class="<?php echo ($this->registry->controller == 'users') ? 'active' : ''; ?>">
                                <a href="javascript:;">
                                    <i class="fa fa-users"></i> 
                                    <span class="title">Felhasználók</span>
                                    <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <?php if ($user->hasAccess('menu_users_list')) { ?>
                                        <li class="<?php echo ($this->registry->action == 'index') ? 'active' : ''; ?>">
                                            <a href="admin/users">
                                                Felhasználók listája</a>
                                        </li>
                                    <?php } ?>
                                    <?php if ($user->hasAccess('menu_insert_user')) { ?>
                                        <li class="<?php echo ($this->registry->action == 'new_user') ? 'active' : ''; ?>">
                                            <a href="admin/users/new_user">
                                                Új felhasználó</a>
                                        </li>
                                    <?php } ?>

                                    <li class="<?php echo ($this->registry->action == 'profile') ? 'active' : ''; ?>">
                                        <a href="admin/users/profile/<?php echo Session::get('user_id'); ?>">
                                            Profilom</a>
                                    </li>
                                    <!-- FELHASZNÁLÓI CSOPORTOK -->	 
                                    <?php if ($user->hasAccess('menu_users_groups')) { ?>					
                                        <li class="<?php echo ($this->registry->action == 'user_roles' || $this->registry->action == 'edit_roles') ? 'active' : ''; ?>">
                                            <a href="admin/users/user_roles">
                                                Csoportok</a>
                                        </li>
                                    <?php } ?>

                                </ul>
                            </li>
                        <?php } ?>

                        <!-- IRODÁK -->
                        <?php if ($user->hasAccess('menu_gallery')) { ?>    
                            <li class="<?php echo ($this->registry->controller == 'photo_gallery' || $this->registry->controller == 'video_gallery') ? 'active' : ''; ?>">
                                <a href="javascript:;">
                                    <i class="fa fa-picture-o"></i> 
                                    <span class="title">Galériák</span>
                                    <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="<?php echo ($this->registry->controller == 'photo_gallery') ? 'active' : ''; ?>">
                                        <a href="admin/photo_gallery">
                                            Képgaléria</a>
                                    </li>
                                    <li class="<?php echo ($this->registry->controller == 'photo_gallery' && $this->registry->action == 'category') ? 'active' : ''; ?>">
                                        <a href="admin/photo_gallery/category">
                                            Képgaléria kategóriák</a>
                                    </li>

                                </ul>
                            </li> 
                        <?php } ?>


                        <!--  MODULOK -->
                        <?php if ($user->hasAccess('menu_modules')) { ?>                                         
                            <li class="<?php echo ($this->registry->controller == 'slider' || $this->registry->controller == 'testimonials' || $this->registry->controller == 'clients') ? 'active' : ''; ?>">
                                <a href="javascript:;">
                                    <i class="fa fa-suitcase"></i> 
                                    <span class="title">Modulok</span>
                                    <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="<?php echo ($this->registry->controller == 'slider') ? 'active' : ''; ?>">
                                        <a href="admin/slider">
                                            Slider beállítások</a>
                                    </li>
                                    <li class="<?php echo ($this->registry->controller == 'testimonials') ? 'active' : ''; ?>">
                                        <a href="admin/testimonials">
                                            Rólunk mondták</a>
                                    </li>
                                    <li class="<?php echo ($this->registry->controller == 'clients') ? 'active' : ''; ?>">
                                        <a href="admin/clients">
                                            Partnerek</a>
                                    </li> 
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- MODULOK VÉGE -->
                        <!-- FÁJL MANAGER -->
                        <?php if ($user->hasAccess('menu_file_manager')) { ?>
                            <li class="<?php echo ($this->registry->controller == 'file_manager') ? 'active' : ''; ?>">
                                <a href="admin/file_manager">
                                    <i class="fa fa-folder-open-o"></i> 
                                    <span class="title">Fájlkezelő</span>
                                </a>

                            </li>
                        <?php } ?>
                        <!-- FÁJL MANAGER VÉGE -->
                        <!-- ALAP BEÁLLÍTÁSOK -->
                        <?php if ($user->hasAccess('menu_settings')) { ?>
                            <li class="<?php echo ($this->registry->controller == 'settings') ? 'active' : ''; ?>">
                                <a href="javascript:;">
                                    <i class="fa fa-cogs"></i> 
                                    <span class="title">Beállítások</span>
                                    <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="<?php echo ($this->registry->controller == 'settings') ? 'active' : ''; ?>">
                                        <a href="admin/settings">
                                            Oldal szintű beállítások</a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- ALAP BEÁLLÍTÁSOK VÉGE -->
                        <!-- DOKUMENTÁCIÓ 
                        <?php if ($user->hasAccess('menu_user_manual')) { ?>
                                            <li class="<?php echo ($this->registry->controller == 'user_manual') ? 'active' : ''; ?>">
                                                <a href="admin/user-manual">
                                                    <i class="fa fa-file-text-o"></i> 
                                                    <span class="title">Dokumentáció</span>
                                                </a>
                                            </li>                                
                        <?php } ?>  -->
                        <!--  NYELVEK				
                                                        <li class="<?php //echo ($this->registry->controller == 'languages') ? 'active' : '';           ?>">
                                                                <a href="admin/languages">
                                                                <i class="fa fa-globe"></i> 
                                                                <span class="title">Nyelvek</span>
                                                                </a>
                                                        </li>
                        -->				
                        <!-- HÍRLEVÉL				
                                                        <li class="<?php //echo ($this->registry->controller == 'newsletter') ? 'active' : '';           ?>">
                                                                <a href="javascript:;">
                                                                        <i class="fa fa-suitcase"></i> 
                                                                        <span class="title">Hírlevél</span>
                                                                        <span class="arrow "></span>
                                                                </a>
                                                                <ul class="sub-menu">
                                                                        <li class="<?php //echo ($this->registry->controller == 'newsletter' && $this->registry->action == 'index') ? 'active' : '';           ?>">
                                                                                <a href="admin/newsletter">Hírlevelek</a>
                                                                        </li>
                                                                        <li class="<?php //echo ($this->registry->controller == 'newsletter' && $this->registry->action == 'new_newsletter') ? 'active' : '';           ?>">
                                                                                <a href="admin/newsletter/new_newsletter">Új hírlevél</a>
                                                                        </li>
                                                                        <li class="<?php //echo ($this->registry->controller == 'newsletter' && $this->registry->action == 'new_newsletter') ? 'active' : '';           ?>">
                                                                                <a href="admin/newsletter/newsletter_stats">Elküldött hírlevelek</a>
                                                                        </li>						
                                                                </ul>
                                                        </li>
                                                        
                                                        <li class="last <?php //echo ($this->registry->controller == 'blog') ? 'active' : '';           ?>">
                                                                <a href="javascript:;">
                                                                        <i class="fa fa-suitcase"></i> 
                                                                        <span class="title">Blog</span>
                                                                        <span class="arrow "></span>
                                                                </a>
                                                                <ul class="sub-menu">
                                                                        <li class="<?php //echo ($this->registry->controller == 'blog' && $this->registry->action == 'index') ? 'active' : '';           ?>">
                                                                                <a href="admin/blog">Bejegyzések</a>
                                                                        </li>
                                                                        <li class="<?php //echo ($this->registry->controller == 'blog' && $this->registry->action == 'new_blog') ? 'active' : '';           ?>">
                                                                                <a href="admin/blog/insert">Új bejegyzés</a>
                                                                        </li>
                                                                        <li class="<?php //echo ($this->registry->controller == 'blog' && $this->registry->action == 'category') ? 'active' : '';           ?>">
                                                                                <a href="admin/blog/category">Kategóriák</a>
                                                                        </li>
                                                                </ul>
                                                        </li>				
                        -->				

                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!--END PAGE SIDEBAR WRAPPER -->
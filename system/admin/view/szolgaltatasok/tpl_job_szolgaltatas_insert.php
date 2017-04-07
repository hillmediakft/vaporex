<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <!-- 
        <h3 class="page-title">
                Szolgaltatás <small>kategória hozzáadása</small>
        </h3>
        -->

        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="admin/home">Kezdőoldal</a> 
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="admin/szolgaltatass/category">Szolgaltatás kategóriák</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li><span>Kategória hozzáadása</span></li>
            </ul>
        </div>

        <!-- END PAGE TITLE & BREADCRUMB-->
        <!-- END PAGE HEADER-->

        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">

                <!-- ÜZENETEK -->
                <div id="message"></div> 
                <?php $this->renderFeedbackMessages(); ?>			


                <form action="" method="POST" id="szolgaltatas_category_form" enctype="multipart/form-data">

                    <!-- ÜZENETEK 2 -->
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        <span><!-- ide jön az üzenet--></span>
                    </div>
                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button>
                        <span><!-- ide jön az üzenet--></span>
                    </div>	

                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet">

                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-film"></i> 
                                Kategória hozzáadása
                            </div>
                            <div class="actions">
                                <button class="btn green btn-sm" type="submit"><i class="fa fa-check"></i> Kategória hozzáadása</button>
                                <a href="admin/szolgaltatass/category" class="btn default btn-sm"><i class="fa fa-close"></i> Mégsem</a>
                                <!-- <button class="btn default btn-sm" name="cancel" type="button">Mégsem</button>-->
                            </div>
                        </div>

                        <div class="portlet-body">

                            <div class="space10"></div>							
                            <div class="row">	
                                <div class="col-md-12">						

                                    <!-- bootstrap file upload -->
                                    <div class="form-group">
                                        <label class="control-label">Kategória kép</label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo ADMIN_IMAGE . 'placeholder_200x150.jpg'; ?>" alt=""/></div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                            <div>
                                                <span class="btn default btn-file"><span class="fileupload-new">Kiválasztás</span><span class="fileupload-exists">Módosít</span><input id="uploadprofile" class="img" type="file" name="upload_szolgaltatas_category_photo"></span>
                                                <a href="#" class="btn btn-warning fileupload-exists" data-dismiss="fileupload">Töröl</a>
                                            </div>
                                        </div>

                                        <div class="space10"></div>
                                        <div class="clearfix"></div>
                                        <div class="controls">
                                            <span class="label label-danger">INFO</span>
                                            <span>Kattintson a kiválasztás gombra! Ha másik képet szeretne kiválasztani, kattintson a megjelenő módosít gombra! Ha mégsem kívánja a kiválasztott képet feltölteni, kattintson a töröl gombra!</span>
                                        </div>
                                        <div class="space10"></div>
                                        <div class="space10"></div>
                                    </div>
                                    <!-- bootstrap file upload END -->

                                    <div class="form-group">
                                        <label for="szolgaltatas_list_name" class="control-label">Kategória neve <span class="required">*</span></label>
                                        <input type="text" name="szolgaltatas_list_name" id="szolgaltatas_list_name" class="form-control input-xlarge" />
                                    </div>

                                </div>
                            </div>	

                        </div> <!-- END USER GROUPS PORTLET BODY-->
                    </div> <!-- END USER GROUPS PORTLET-->
                </form>

            </div> <!-- END COL-MD-12 -->
        </div> <!-- END ROW -->	
    </div> <!-- END PAGE CONTENT-->    
</div> <!-- END PAGE CONTENT WRAPPER -->
</div> <!-- END CONTAINER -->	
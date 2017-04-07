<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <!-- 
        <h3 class="page-title">
                Szolgáltatás <small>hozzáadása</small>
        </h3>
        -->

        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="admin/home">Kezdőoldal</a> 
                    <i class="fa fa-angle-right"></i>
                </li>
                <li><span>Szolgáltatás hozzáadása</span></li>
            </ul>
        </div>

        <!-- END PAGE TITLE & BREADCRUMB-->
        <!-- END PAGE HEADER-->

        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">

                <!-- ÜZENETEK -->
                <div id="message">
                    <?php $this->renderFeedbackMessages(); ?>			
                </div> 

                <form action="" method="POST" id="uj_szolgaltatas" enctype="multipart/form-data">	

                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        <span><!-- ide jön az üzenet--></span>
                    </div>
                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button>
                        <span><!-- ide jön az üzenet--></span>
                    </div>	

                    <!-- ÚJ SZOLGÁLTATÁS PORTLET-->
                    <div class="portlet light bg-inverse">

                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>
                                Szolgáltatás hozzáadása
                            </div>
                            <div class="actions">
                                <button class="btn green btn-sm" type="submit"><i class="fa fa-check"></i> Mentés</button>
                                <a class="btn default btn-sm" href="admin/szolgaltatasok"><i class="fa fa-close"></i> Mégsem</a>
                                <!-- <button class="btn default btn-sm" name="cancel" type="button"><i class="fa fa-close"></i> Mégsem</button>-->
                            </div>
                        </div>
                        <div class="portlet-body form">

                            <div class="space10"></div>				<div class="form-body">			
                                <div class="row">	
                                    <div class="col-md-12">						
                                        <h3 class="form-section">Kezdőkép</h3>
                                        <!-- bootstrap file upload -->
                                        <div class="form-group">
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <div class="fileupload-new thumbnail" style="width: 400px; height: 300px;"><img src="<?php echo ADMIN_IMAGE . 'placeholder-400x300.jpg'; ?>" alt=""/></div>
                                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 400px; max-height: 300px; line-height: 20px;"></div>
                                                <div>
                                                    <span class="btn default btn-file"><span class="fileupload-new">Kiválasztás</span><span class="fileupload-exists">Módosít</span><input id="upload_szolgaltatas_photo" class="img" type="file" name="upload_szolgaltatas_photo"></span>
                                                    <a href="#" class="btn btn-warning fileupload-exists" data-dismiss="fileupload">Töröl</a>
                                                </div>
                                            </div>


                                            <div class="space10"></div>
                                            <div class="clearfix"></div>
                                            <div class="controls">
                                                <div class="alert alert-info"><i class="fa fa-info-circle"></i> Kattintson a kiválasztás gombra! Ha másik képet szeretne kiválasztani, kattintson a módosít gombra! Ha mégsem kívánja a kiválasztott képet feltölteni, kattintson a töröl gombra!</div>
                                            </div>

                                        </div>
                                        <!-- bootstrap file upload END -->
                                        <h3 class="form-section">Megnevezés és leírás</h3>
                                        <!-- SZOLGÁLTATÁS MEGNEVEZÉSE -->	
                                        <div class="form-group">
                                            <label for="szolgaltatas_title" class="control-label">Megnevezés <span class="required">*</span></label>
                                            <input type="text" name="szolgaltatas_title" id="szolgaltatas_title" placeholder="" class="form-control input-xlarge" />
                                        </div>
                                        <!-- SZOLGÁLTATÁS LEÍRÁSA -->	
                                        <div class="form-group">
                                            <label for="szolgaltatas_description" class="control-label">Leírás</label>
                                            <textarea name="szolgaltatas_description" id="szolgaltatas_description" placeholder="" class="form-control input-xlarge" rows="4"></textarea>
                                        </div>
                                        <!-- SZOLGÁLTATÁS EXTRA INFÓ -->	
                                        <div class="form-group">
                                            <label for="szolgaltatas_info" class="control-label">Extra információ</label>
                                            <textarea name="szolgaltatas_info" id="szolgaltatas_info" placeholder="" class="form-control input-xlarge" rows="4"></textarea>
                                        </div>

                                        <h3 class="form-section">Kategória</h3>	                                        
                                        <!-- SZOLGÁLTATÁS STÁTUSZ -->	
                                        <div class="form-group">
                                            <label for="szolgaltatas_category_id" class="control-label">Szolgáltatás kategória</label>
                                            <select name="szolgaltatas_category_id" class="form-control input-xlarge">
                                                <option value="">Válasszon</option>
                                                <?php foreach ($category_list as $value) { ?>

                                                    <option value="<?php echo $value['szolgaltatas_list_id']; ?>"><?php echo $value['szolgaltatas_list_name']; ?></option>

                                                <?php } ?>
                                            </select>
                                        </div>                                        					

                                        <h3 class="form-section">Státusz</h3>	                                        
                                        <!-- SZOLGÁLTATÁS STÁTUSZ -->	
                                        <div class="form-group">
                                            <label for="szolgaltatas_status" class="control-label">Szolgáltatás státusz</label>
                                            <select name="szolgaltatas_status" class="form-control input-xlarge">
                                                <option value="0">Inaktív</option>
                                                <option value="1" selected>Aktív</option>
                                            </select>
                                        </div>
                                        <button class="btn green btn-sm" type="submit"><i class="fa fa-check"></i> Mentés</button>
                                    </div>
                                </div>	
                            </div> <!-- END FORM BODY -->

                        </div> <!-- END USER GROUPS PORTLET BODY-->
                    </div> <!-- END USER GROUPS PORTLET-->
                </form>


            </div> <!-- END COL-MD-12 -->
        </div> <!-- END ROW -->	
    </div> <!-- END PAGE CONTENT-->    
</div> <!-- END PAGE CONTENT WRAPPER -->
</div><!-- END CONTAINER -->
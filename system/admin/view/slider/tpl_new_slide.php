<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <!-- 
        <h3 class="page-title">
                Új slide <small>hozzáadása</small>
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
                    <a href="admin/slider">Slider lista</a> 
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Slide hozzáadása</span>
                </li>
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

                <form action="" method="POST" id="new_slider" enctype="multipart/form-data">	
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet">

                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-film"></i> 
                                Slide hozzáadása
                            </div>
                            <div class="actions">
                                <button class="btn green btn-sm" type="submit" name="submit_new_slide"><i class="fa fa-check"></i> Mentés</button>
                                <a class="btn default btn-sm" href="admin/slider"><i class="fa fa-close"></i> Mégsem</a>
                            </div>
                            <!-- 
                                    <div class="tools">
                                            <a href="javascript:;" class="collapse"></a>
                                            <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                            <a href="javascript:;" class="reload"></a>
                                            <a href="javascript:;" class="remove"></a>
                                    </div>
                            -->
                        </div>

                        <div class="portlet-body">

                            <div class="space10"></div>							
                            <div class="row">	
                                <div class="col-md-12">						

                                    <!-- bootstrap file upload -->
                                    <div class="form-group">
                                        <label class="control-label">Slide kép</label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-new thumbnail" style="width: 585px; height: 210px;"><img src="<?php echo ADMIN_IMAGE . 'slide_placeholder_585x210.jpg'; ?>" alt=""/></div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 585px; max-height: 210px; line-height: 20px;"></div>
                                            <div>
                                                <span class="btn default btn-file"><span class="fileupload-new">Kiválasztás</span><span class="fileupload-exists">Módosít</span><input id="uploadprofile" class="img" type="file" name="upload_slide_picture"></span>
                                                <a href="#" class="btn btn-warning fileupload-exists" data-dismiss="fileupload">Töröl</a>
                                            </div>
                                        </div>

                                        <div class="space10"></div>
                                        <div class="clearfix"></div>
                                        <div class="controls">
                                            <span class="label label-danger">INFO</span>
                                            <span>Kattintson a kiválasztás gombra! Ha másik képet szeretne kiválasztani, kattintson a megjelenő módosít gombra! Ha mégsem kívánja a kiválasztott képet feltölteni, kattintson a töröl gombra!<br>Annak érdekében, hogy a kép ne legyen torzított, és a lehető legjobb minőségű legyen, 1170x420 képpont méretű képet töltsön fel!</span>
                                        </div>
                                        <div class="space10"></div>
                                        <div class="space10"></div>
                                    </div>
                                    <!-- bootstrap file upload END -->

                                    <div class="form-group">
                                        <label for="slider_title" class="control-label">Slide cím</label>
                                        <input type="text" name="slider_title" id="slider_title" placeholder="" class="form-control input-xlarge" />
                                    </div>
                                    <div class="form-group">
                                        <label for="slider_text" class="control-label">Slide szöveg</label>
                                        <!--<input type="text" name="slider_text" id="slider_text" placeholder="A slide szövege" class="form-control input-xlarge" />
                                        -->
                                        <textarea name="slider_text" id="slider_text" placeholder="" class="form-control input-xlarge"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="slider_link" class="control-label">Slide link</label>
                                        <!--<input type="text" name="slider_text" id="slider_text" placeholder="A slide szövege" class="form-control input-xlarge" />
                                        -->
                                        <input type="text" name="slider_link" id="slider_link" placeholder="" class="form-control input-xlarge" />
                                    </div>
                                    <div class="form-group">
                                        <label for="slider_status">Slide státusz</label>
                                        <select name="slider_status" class="form-control input-xlarge">
                                            <option value="0">Inaktív</option>
                                            <option value="1">Aktív</option>
                                        </select>
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
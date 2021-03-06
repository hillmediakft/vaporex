<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <!-- 
        <h3 class="page-title">
                Blog <small>hozzáadása</small>
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
                    <a href="admin/blog">Hírek kezelése</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li><a href="admin/blog/update">Hír bejegyzés módosítása</a></li>
            </ul>
        </div>

        <!-- END PAGE TITLE & BREADCRUMB-->
        <!-- END PAGE HEADER-->

        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">

                <!-- echo out the system feedback (error and success messages) -->
                <?php $this->renderFeedbackMessages(); ?>			

                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet">

                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-film"></i>Hír bejegyzés módosítása</div>
                    </div>

                    <div class="portlet-body">


                        <div class="space10"></div>							
                        <div class="row">	
                            <div class="col-md-12">						
                                <form action="" method="POST" id="update_blog" enctype="multipart/form-data">	

                                    <!-- bootstrap file upload -->
                                    <div class="form-group">
                                        <label class="control-label">Kép</label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-new thumbnail" style="width: 400px; height: 300px;"><img src="<?php echo $content['blog_picture']; ?>" alt=""/></div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 400px; max-height: 300px; line-height: 20px;"></div>
                                            <div>
                                                <span class="btn default btn-file"><span class="fileupload-new">Kiválasztás</span><span class="fileupload-exists">Módosít</span><input id="uploadprofile" class="img" type="file" name="upload_blog_picture"></span>
                                                <a href="#" class="btn btn-warning fileupload-exists" data-dismiss="fileupload">Töröl</a>
                                            </div>
                                        </div>


                                        <div class="space10"></div>
                                        <div class="clearfix"></div>
                                        <div class="controls">
                                            <span class="label label-danger">INFO</span>
                                            <span>Kattintson a kiválasztás gombra! Ha másik képet szeretne kiválasztani, kattintson a módosít gombra! Ha mégsem kívánja a kiválasztott képet feltölteni, kattintson a töröl gombra!</span>
                                        </div>
                                        <div class="space10"></div>
                                        <div class="space10"></div>
                                    </div>
                                    <!-- bootstrap file upload END -->

                                        <div class="form-group">
                                            <label for="blog_title" class="control-label">Cím</label>
                                            <input type="text" name="blog_title" id="blog_title" value="<?php echo $content['blog_title']; ?>" class="form-control input-xlarge" />
                                        </div>
                                        <div class="form-group">
                                            <label for="blog_text" class="control-label">Szöveg</label>
                                            <textarea name="blog_body" id="blog_body" class="form-control input-xlarge"><?php echo $content['blog_body']; ?></textarea>
                                        </div>
                                        <?php if (isset($ckeditor) && $ckeditor === true) { ?>
                                            <script>
                                                //CKEDITOR.replace( 'blog_body' );
                                                CKEDITOR.replace('blog_body', {customConfig: 'config_custom3.js'});
                                            </script>
                                        <?php } ?>

                                        <div class="form-group">
                                            <label for="blog_category">Kategória</label>
                                            <select name="blog_category" class="form-control input-xlarge">
                                                <?php foreach ($category_list as $v) { ?>
                                                    <option value="<?php echo $v['category_id'] ?>" <?php echo ($content['category_name'] == $v['category_name']) ? "selected" : ""; ?>><?php echo $v['category_name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="blog_add_date" class="control-label">Hozzáadás dátuma</label>
                                            <input type="text" name="blog_add_date" id="blog_add_date" value="<?php echo $content['blog_add_date']; ?>" class="form-control input-xlarge" />
                                        </div>

                                    <div class="space10"></div>
                                    <button class="btn green submit" type="submit" value="submit" name="submit_update_blog">Bejegyzés módosítása <i class="fa fa-check"></i></button>
                                </form>
                            </div>
                        </div>	


                        <div id="message"></div> 


                    </div> <!-- END USER GROUPS PORTLET BODY-->
                </div> <!-- END USER GROUPS PORTLET-->
            </div> <!-- END COL-MD-12 -->
        </div> <!-- END ROW -->	
    </div> <!-- END PAGE CONTENT-->    
</div> <!-- END PAGE CONTENT WRAPPER -->
</div> <!-- END CONTAINER -->
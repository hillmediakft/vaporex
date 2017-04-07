<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->

        <h3 class="page-title">
            Képgaléria <small>kategória hozzáadása</small>
        </h3>


        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="admin/home">Kezdőoldal</a> 
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="admin/photo_gallery">Képgaléria kategóriák listája</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li><a href="admin/photo_gallery/category_insert">Kategória hozzáadása</a></li>
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
                        <div class="caption"><i class="fa fa-film"></i>Kategória hozzáadása</div>
                    </div>

                    <div class="portlet-body">

                        <div class="space10"></div>							
                        <div class="row">	
                            <div class="col-md-12">						
                                <form action="" method="POST" id="new_photo_category">

                                    <div class="form-group">
                                        <label for="photo_category_name" class="control-label">Kategória neve</label>
                                        <input type="text" name="photo_category_name" id="photo_category_name" class="form-control input-xlarge" />
                                    </div>
                                    <div class="space10"></div>
                                    <button class="btn green submit" type="submit">Kategória hozzáadása <i class="fa fa-check"></i></button>
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


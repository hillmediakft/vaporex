<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="admin/home">Kezdőoldal</a> 
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="admin/document">Dokumentumok kezelése</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li><a href="admin/documents/insert">Dokumentum feltöltése</a></li>
            </ul>
        </div>
        <!-- END PAGE TITLE & BREADCRUMB-->
        <!-- END PAGE HEADER-->

        <div class="margin-bottom-20"></div>

        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <div id="ajax_message"></div> 
                <!-- echo out the system feedback (error and success messages) -->
                <?php $this->renderFeedbackMessages(); ?>			

                <form action="admin/documents/insert" method="POST" id="upload_document_form" enctype="multipart/form-data">	

                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet">

                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-film"></i> 
                                Dokumentum feltöltése
                            </div>
                            <div class="actions">
                                <!-- Adatok "első" elküldése INSERT -->
                                                               <!-- Adatok elküldése UPDATE és kilépés -->
                                <input class="btn blue" id="data_upload" type="submit" name="upload_data" value="Mentés">
                                <a class="btn default btn-sm" id="button_megsem" href="admin/documents"><i class="fa fa-close"></i> Mégsem</a>
                            </div>
                        </div>

                        <div class="portlet-body">

                            <div class="row">	
                                <div class="col-md-12">						

                                    <!-- bootstrap file upload -->
                                    <div class="form-group">
                                        <label class="control-label">Válassza ki a feltöltendő fájlt</label>



                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- DOKUMENTUMOK FELTÖLTÉSE -->
                                                <div class="portlet">
                                                    <div class="portlet-body">
                                                        <h4 class="block">Dokumentum hozzáadása:</h4>
                                                        <label class="control-label">Fájl kiválasztása</label>
                                                        <input id="fileinput" name="new_doc" type="file" class="file-loading">
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- row END -->	                                 

                                        <div class="clearfix"></div>

                                        <div class="note note-info">
                                            Fájl kiválasztásához kattintson a "tallóz" gombra! Ha másik fájlt szeretne kiválasztani, kattintson az "eltávolít" (remove) gombra! 
                                        </div>

                                        <div class="form-group">
                                            <label for="title" class="control-label">Cím</label>
                                            <input type="text" name="title" id="title" placeholder="" class="form-control input-xlarge" />
                                        </div>
                                        <div class="form-group">
                                            <label for="description" class="control-label">Rövid leírás</label>
                                            <textarea name="description" id="description" placeholder="" class="form-control input-xlarge"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="document_category">Kategória</label>
                                            <select name="category_id" class="form-control input-xlarge">
                                                <option value="">-- válasszon --</option>
                                                <?php foreach ($this->category_list as $value) { ?>
                                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                                <?php } ?>
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
</div>
</div>
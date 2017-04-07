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

                <form action="" method="POST" id="update_szolgaltatas" enctype="multipart/form-data">	

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
                                Szolgáltatás szerkesztése
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
                                    <div class="col-md-12">					 <h3 class="form-section">Kezdőkép</h3>

                                        <div class="col-md-12 well well-sm">
                                            <div class="col-md-6">    



                                                <!-- bootstrap file upload -->
                                                <div class="form-group">
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail" style="width: 400px; height: 300px;"><img src="<?php echo Config::get('szolgaltatasphoto.upload_path') . $actual_szolgaltatas[0]['szolgaltatas_photo']; ?>" alt=""/></div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 400px; max-height: 300px; line-height: 20px;"></div>
                                                        <div>
                                                            <span class="btn default btn-file"><span class="fileupload-new">Kiválasztás</span><span class="fileupload-exists">Módosít</span><input id="upload_szolgaltatas_photo" class="img" type="file" name="upload_szolgaltatas_photo"></span>
                                                            <a href="#" class="btn btn-warning fileupload-exists" data-dismiss="fileupload">Töröl</a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-6">

                                                <div class="clearfix"></div>
                                                <div class="controls">
                                                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> Kattintson a kiválasztás gombra! Ha másik képet szeretne kiválasztani, kattintson a módosít gombra! Ha mégsem kívánja a kiválasztott képet feltölteni, kattintson a töröl gombra!</div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- bootstrap file upload END -->


                                        <h3 class="form-section">További képek</h3>                                        



                                        <div class="col-md-12 well well-sm">
                                            <div class="col-md-4">
                                                <div class="portlet">
                                                    <div class="portlet-body">
                                                        <h4 class="block">Feltöltött képek:</h4>
                                                        <ul id="photo_list">
                                                            <?php
                                                            $result_photos = json_decode($actual_szolgaltatas[0]['szolgaltatas_extra_photos']);
                                                            if (!empty($result_photos)) {
                                                                $counter = 0;
                                                                $file_location = Config::get('szolgaltatasphoto.upload_path');
                                                                foreach ($result_photos as $key => $value) {
                                                                    $counter = $key + 1;
                                                                    $file_path = Util::thumb_path($file_location . $value);
                                                                    echo '<li id="elem_' . $counter . '" class="ui-state-default"><img style="width: 100px" class="img-thumbnail" src="' . $file_path . '" alt="" /><button style="position:absolute; top:20px; right:20px; z-index:2;" class="btn btn-xs red" type="button" title="Kép törlése"><i class="fa fa-trash"></i></button></li>' . "\n\r";
                                                                }
                                                            } else {
                                                                echo 'Nincsenek feltöltött extra képek!';
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <!-- KÉPEK FELTÖLTÉSE -->
                                                <div class="portlet">
                                                    <div class="portlet-body">
                                                        <h4 class="block">Képek hozzáadása:</h4>
                                                        <input type="file" name="new_file[]" multiple="true" id="input-4" />
                                                    </div>
                                                </div>		
                                            </div>                                        

                                            <div class="col-md-12">
                                                <div class="controls">
                                                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> A böngészés gombra kattintás után válassza ki feltöltendő fájlokat, egyszerre többet is kiválaszthat. A feltöltés gombra kattintva elindul a feltöltés, a feltöltés állapotát folyamatotjelző sáv mutatja. A feltöltés befejeztével a feltöltött képek megjelennek a baloldali listában. A képek sorrendje módosítható, ehhez a kívánt helyre kell mozgatni a kiválasztott képet.</div>
                                                </div>
                                            </div>

                                            <div id="data_update_ajax" data-id="<?php echo $actual_szolgaltatas[0]['szolgaltatas_id']; ?>"></div>


                                        </div>


                                        <h3 class="form-section">Megnevezés és leírás</h3>
                                        <!-- SZOLGÁLTATÁS MEGNEVEZÉSE -->	
                                        <div class="form-group">
                                            <label for="szolgaltatas_title" class="control-label">Megnevezés <span class="required">*</span></label>
                                            <input type="text" name="szolgaltatas_title" id="szolgaltatas_title" value="<?php echo $actual_szolgaltatas[0]['szolgaltatas_title']; ?>" class="form-control input-xlarge" />
                                        </div>
                                        <!-- SZOLGÁLTATÁS LEÍRÁSA -->	
                                        <div class="form-group">
                                            <label for="szolgaltatas_description" class="control-label">Leírás</label>
                                            <textarea name="szolgaltatas_description" id="szolgaltatas_description" placeholder="" class="form-control input-xlarge" rows="10"><?php echo $actual_szolgaltatas[0]['szolgaltatas_description']; ?></textarea>
                                        </div>

                                        <!-- SZOLGÁLTATÁS EXTRA INFO -->	
                                        <div class="form-group">
                                            <label for="szolgaltatas_info" class="control-label">Leírás</label>
                                            <textarea name="szolgaltatas_info" id="szolgaltatas_info" placeholder="" class="form-control input-xlarge" rows="10"><?php echo $actual_szolgaltatas[0]['szolgaltatas_info']; ?></textarea>
                                        </div>

                                        <h3 class="form-section">kategória</h3>	                                        
                                        <!-- SZOLGÁLTATÁS STÁTUSZ -->	
                                        <div class="form-group">
                                            <label for="szolgaltatas_category_id" class="control-label">Szolgáltatás kategória</label>
                                            <select name="szolgaltatas_category_id" class="form-control input-xlarge">
                                                <option value="">-- Válasszon --</option>
                                                <?php foreach ($category_list as $value) { ?>
                                                    <option value="<?php echo $value['szolgaltatas_list_id']; ?>" <?php echo ($value['szolgaltatas_list_id'] == $actual_szolgaltatas[0]['szolgaltatas_category_id']) ? 'selected' : ''; ?>><?php echo $value['szolgaltatas_list_name']; ?></option>

                                                <?php } ?>

                                            </select>
                                        </div>                                        					

                                        <h3 class="form-section">Státusz</h3>	                                        
                                        <!-- SZOLGÁLTATÁS STÁTUSZ -->	
                                        <div class="form-group">
                                            <label for="szolgaltatas_status" class="control-label">Szolgáltatás státusz</label>
                                            <select name="szolgaltatas_status" class="form-control input-xlarge">
                                                <option value="1" <?php echo ($actual_szolgaltatas[0]['szolgaltatas_status'] == 1) ? 'selected' : ''; ?>>Aktív</option>
                                                <option value="0" <?php echo ($actual_szolgaltatas[0]['szolgaltatas_status'] == 0) ? 'selected' : ''; ?>>Inaktív</option>
                                            </select>
                                        </div>

                                        <!-- régi kép neve-->
                                        <input type="hidden" name="old_img" value="<?php echo $actual_szolgaltatas[0]['szolgaltatas_photo']; ?>">
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
<div id="loadingDiv" style="display:none;"><img src="public/admin_assets/img/loader.gif"></div>
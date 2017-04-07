<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <!-- 
        <h3 class="page-title">
                Rendezvény <small>hozzáadása</small>
        </h3>
        -->

        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="admin/home">Kezdőoldal</a> 
                    <i class="fa fa-angle-right"></i>
                </li>
                <li><span>Rendezvény hozzáadása</span></li>
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

                <form action="" method="POST" id="uj_rendezveny" enctype="multipart/form-data">	

                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        <span><!-- ide jön az üzenet--></span>
                    </div>
                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button>
                        <span><!-- ide jön az üzenet--></span>
                    </div>	

                    <!-- ÚJ RENDEZVÉNY PORTLET-->
                    <div class="portlet light bg-inverse">

                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>
                                Rendezvény hozzáadása
                            </div>
                            <div class="actions">
                                <button class="btn green btn-sm" type="submit"><i class="fa fa-check"></i> Mentés</button>
                                <a class="btn default btn-sm" href="admin/rendezvenyek"><i class="fa fa-close"></i> Mégsem</a>
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
                                                    <span class="btn default btn-file"><span class="fileupload-new">Kiválasztás</span><span class="fileupload-exists">Módosít</span><input id="upload_rendezveny_photo" class="img" type="file" name="upload_rendezveny_photo"></span>
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
                                        <!-- RENDEZVÉNY MEGNEVEZÉSE -->	
                                        <div class="form-group">
                                            <label for="rendezveny_title" class="control-label">Megnevezés <span class="required">*</span></label>
                                            <input type="text" name="rendezveny_title" id="rendezveny_title" placeholder="" class="form-control input-xlarge" />
                                        </div>
                                        <!-- RENDEZVÉNY LEÍRÁSA -->	
                                        <div class="form-group">
                                            <label for="rendezveny_description" class="control-label">Leírás</label>
                                            <textarea name="rendezveny_description" id="rendezveny_description" placeholder="" class="form-control input-xlarge" rows="10"></textarea>
                                        </div>

                                        <!-- ******** HELYSZÍN ADATOK ******* --> 	
                                        <h3 class="form-section">Helyszín</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- MEGYE MEGADÁSA -->	
                                                <div class="form-group">
                                                    <label for="rendezveny_county_id" class="control-label">Megye <span class="required">*</span></label>
                                                    <select name="rendezveny_county_id" id="county_select" class="form-control input-xlarge">
                                                        <option value="">-- Válasszon --</option>
                                                        <?php foreach ($county_list as $value) { ?>
                                                            <option value="<?php echo $value['county_id']; ?>"><?php echo $value['county_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <!-- VÁROS MEGADÁSA -->	
                                                <div class="form-group" id="city_div" style="display: none;">
                                                    <label for="rendezveny_city_id" class="control-label">Város <span class="required">*</span></label>
                                                    <select name="rendezveny_city_id" class="form-control input-xlarge">
                                                        <!-- ide jön a városlista AJAX hívással -->
                                                    </select>
                                                </div>
                                                <!-- KERÜLET MEGADÁSA -->	
                                                <div class="form-group" id="district_div" style="display: none;">
                                                    <label for="rendezveny_district_id" class="control-label">Kerület <span class="required">*</span></label>
                                                    <select name="rendezveny_district_id" class="form-control input-xlarge">
                                                        <?php foreach ($district_list as $value) { ?>
                                                            <option value="<?php echo $value['district_id']; ?>"><?php echo $value['district_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <!-- HELYSZÍN -->	
                                                <div class="form-group">
                                                    <label for="rendezveny_location" class="control-label">Rendezvény helyszíne</label>
                                                    <input type="text" name="rendezveny_location" id="rendezveny_location" placeholder="" class="form-control input-xlarge" />
                                                </div>
                                                <!-- HELYSZÍN CÍME -->	
                                                <div class="form-group">
                                                    <label for="rendezveny_address" class="control-label">Rendezvény címe</label>
                                                    <input type="text" name="rendezveny_address" id="rendezveny_address" placeholder="" class="form-control input-xlarge" />
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <!-- HELYSZÍN KOORDINÁTA SZÉLESÉG-->	
                                                        <div class="form-group">
                                                            <label for="rendezveny_location_lat_lng" class="control-label">Földrajzi koordináták (pl.: 47.535719, 19.039634)</label>
                                                            <input type="text" name="rendezveny_location_lat_lng" id="rendezveny_location_lat_lng" class="form-control input-xlarge" />
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- RENDEZVÉNY MEGKÖZELÍTHETŐSÉG -->	
                                        <div class="col-md-12">
                                            <div class="form-group">
                                            <label for="rendezveny_directions" class="control-label">Megközelíthetőség</label>
                                            <textarea name="rendezveny_directions" id="rendezveny_directions" class="form-control input-xlarge" rows="10"></textarea>
                                        </div>
                                        </div>                                            
                                            
                                            
                                            
                                        </div>

                                        <h3 class="form-section">Játékok / szolgáltatások</h3>

                                        <div class="form-group">
                                            <label class="control-label col-md-2">Válasszon szolgáltatásokat</label>
                                            <div class="col-md-10">
                                                <select multiple="multiple" class="multi-select" id="rendezveny_szolgaltatasok" name="rendezveny_szolgaltatasok[]">

                                                    <?php foreach ($szolgaltatasok_list as $value) { ?>
                                                        <option value="<?php echo $value['szolgaltatas_id']; ?>"><?php echo $value['szolgaltatas_title']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>   
                                        <div class="clearfix"></div>

                                        <h3 class="form-section">Facebook</h3>

                                        <!-- FACEBOOK OLDAL MEGADÁSA -->	
                                        <div class="form-group">
                                            <label for="rendezveny_facebook_site_id" class="control-label">Facebook oldal automata post generáláshoz</label>
                                            <select name="rendezveny_facebook_site_id" class="form-control input-xlarge">
                                                <option value="">-- Válasszon --</option>
                                                <?php foreach ($facebook_site_list as $value) { ?>
                                                    <option value="<?php echo $value['facebook_site_id']; ?>"><?php echo $value['facebook_site_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>	


                                        <h3 class="form-section">Időpont</h3>					


                                        <!-- LEJÁRAT DÁTUMA DATETIMEPICKER JS PLUGIN-NAL-->	
                                        
<div class="row">
        <div class='col-sm-6'>
            <div class="form-group">
                <label for="rendezveny_start_date" class="control-label">Rendezvény kezdete </label>
                <div class='input-group date datetimepicker'>
                    <input type='text' class="form-control" name="rendezveny_start_timestamp" id="rendezveny_start_timestamp"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>

        <div class='col-sm-6'>
            <div class="form-group">
                <label for="rendezveny_expiry_date" class="control-label">Rendezvény vége </label>
                <div class='input-group date datetimepicker'>
                    <input type='text' class="form-control" name="rendezveny_expiry_timestamp" id="rendezveny_expiry_timestamp"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>                              
</div>
					
                                        <!-- STÁTUSZ -->	
                                        <h3 class="form-section">Státusza</h3>	                                        
                                        <!-- RENDEZVÉNY STÁTUSZ -->	
                                        <div class="form-group">
                                            <label for="rendezveny_status" class="control-label">Rendezvény státusz</label>
                                            <select name="rendezveny_status" class="form-control input-xlarge">
                                                <option value="0">Inaktív</option>
                                                <option value="1">Aktív</option>
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
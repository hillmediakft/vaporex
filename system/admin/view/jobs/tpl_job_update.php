<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <!-- 
        <h3 class="page-title">
                Munka <small>módosítása</small>
        </h3>
        -->		

        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="admin/home">Kezdőoldal</a> 
                    <i class="fa fa-angle-right"></i>
                </li>
                <li><span>Munka módosítása</span></li>
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

                <form action="" method="POST" id="update_job">

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
                                <i class="fa fa-cogs"></i> 
                                Munka módosítása
                            </div>
                            <div class="actions">
                                <button class="btn green btn-sm" type="submit"><i class="fa fa-check"></i> Mentés</button>
                                <a class="btn default btn-sm" href="admin/jobs"><i class="fa fa-close"></i> Mégsem</a>
                                <!-- <button class="btn default btn-sm" name="cancel" type="button">Mégsem</button>-->
                            </div>							
                        </div>

                        <div class="portlet-body">

                            <div class="space10"></div>							
                            <div class="row">	
                                <div class="col-md-12">

                                    <?php if (Session::get('user_role_id') == 1) { ?>
                                        <!-- REFERENS -->	
                                        <div class="form-group">
                                            <label for="job_ref_id" class="control-label">Referens</label>
                                            <select name="job_ref_id" class="form-control input-xlarge">
                                                <?php foreach ($user_list as $value) { ?>
                                                    <option value="<?php echo $value['user_id']; ?>" <?php echo ($value['user_id'] == $actual_job[0]['job_ref_id']) ? 'selected' : ''; ?> ><?php echo $value['user_first_name'] . ' ' . $value['user_last_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>                                              
                                    <?php } ?>                                        

                                    <!-- MUNKA MEGNEVEZÉSE -->	
                                    <div class="form-group">
                                        <label for="job_title" class="control-label">Megnevezés <span class="required">*</span></label>
                                        <input type="text" name="job_title" id="job_title" placeholder="" class="form-control input-xlarge" value="<?php echo $actual_job[0]['job_title']; ?>"/>
                                    </div>
                                    <!-- MUNKA LEÍRÁSA -->	
                                    <div class="form-group">
                                        <label for="job_description" class="control-label">Leírás</label>
                                        <textarea name="job_description" id="job_description" placeholder="" class="form-control input-xlarge" rows="10"><?php echo $actual_job[0]['job_description']; ?></textarea>
                                    </div>										
                                    <!-- MUNKA KATEGÓRIA -->	
                                    <div class="form-group">
                                        <label for="job_category_id" class="control-label">Kategória <span class="required">*</span></label>
                                        <select name="job_category_id" class="form-control input-xlarge">
                                            <?php foreach ($jobs_list as $value) { ?>
                                                <option value="<?php echo $value['job_list_id']; ?>" <?php echo ($value['job_list_id'] == $actual_job[0]['job_category_id'] ? 'selected' : ''); ?>><?php echo $value['job_list_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <!-- FIZETÉS MEGADÁSA -->	
                                    <div class="form-group">
                                        <label for="job_pay" class="control-label">Fizetés</label>
                                        <input type="text" name="job_pay" id="job_pay" placeholder="" class="form-control input-xlarge" value="<?php echo $actual_job[0]['job_pay']; ?>"/>
                                    </div>
                                    <!-- MUNKAIDŐ MEGADÁSA -->	
                                    <div class="form-group">
                                        <label for="job_working_hours" class="control-label">Munkaidő</label>
                                        <input type="text" name="job_working_hours" id="job_working_hours" placeholder="" class="form-control input-xlarge" value="<?php echo $actual_job[0]['job_working_hours']; ?>"/>
                                    </div>
                                    <!-- MEGYE MEGADÁSA -->	
                                    <div class="form-group">
                                        <label for="job_county_id" class="control-label">Megye <span class="required">*</span></label>
                                        <select name="job_county_id" id="county_select" class="form-control input-xlarge">
                                            <?php foreach ($county_list as $value) { ?>
                                                <option value="<?php echo $value['county_id']; ?>" <?php echo ($value['county_id'] == $actual_job[0]['job_county_id'] ? 'selected' : ''); ?>><?php echo $value['county_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>										
                                    <!-- VÁROS MEGADÁSA -->	
                                    <div class="form-group" id="city_div" style="<?php echo ($budapest == true) ? 'display:none;' : ''; ?>">
                                        <label for="job_city_id" class="control-label">Város <span class="required">*</span></label>
                                        <select name="job_city_id" class="form-control input-xlarge">
                                            <!-- ide jön a városlista AJAX hívással -->
                                            <option value="">Válasszon</option>
                                            <?php foreach ($city_list as $value) { ?>
                                                <option value="<?php echo $value['city_id']; ?>" <?php echo ($value['city_id'] == $actual_job[0]['job_city_id'] ? 'selected' : ''); ?>><?php echo $value['city_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <!-- KERÜLET MEGADÁSA -->	
                                    <div class="form-group" id="district_div" style="<?php echo ($budapest == false) ? 'display:none;' : ''; ?>">
                                        <label for="job_district_id" class="control-label">Kerület <span class="required">*</span></label>
                                        <select name="job_district_id" class="form-control input-xlarge">
                                            <?php foreach ($district_list as $value) { ?>
                                                <option value="<?php echo $value['district_id']; ?>" <?php echo ($value['district_id'] == $actual_job[0]['job_district_id'] ? 'selected' : ''); ?>><?php echo $value['district_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>	
                                    <!-- CÉG MEGADÁSA -->	
                                    <div class="form-group">
                                        <label for="job_employer_id" class="control-label">Cég kiválasztása</label>
                                        <select name="job_employer_id" class="form-control input-xlarge">
                                            <?php foreach ($employer_list as $value) { ?>
                                                <option value="<?php echo $value['employer_id']; ?>" <?php echo ($value['employer_id'] == $actual_job[0]['job_employer_id'] ? 'selected' : ''); ?>><?php echo $value['employer_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>	
                                    <!-- FELTÉTEL -->	
                                    <div class="form-group">
                                        <label for="job_conditions" class="control-label">Munkához szükséges feltételek</label>
                                        <textarea name="job_conditions" id="job_conditions" placeholder="" class="form-control input-xlarge"><?php echo $actual_job[0]['job_conditions']; ?></textarea>
                                    </div>										
                                    <!-- LEJÁRAT DÁTUMA DATEPICKER JS PLUGIN-NAL-->	
                                    <div class="form-group">
                                        <label for="job_expiry_date" class="control-label">Munka lejáratának dátuma</label>
                                        <input class="form-control form-control-inline input-medium date-picker" name="job_expiry_timestamp" id="job_expiry_timestamp" placeholder="nincs" size="16" type="text" value="<?php echo (empty($actual_job[0]['job_expiry_timestamp'])) ? '' : date('Y-m-d', $actual_job[0]['job_expiry_timestamp']); ?>"/>
                                    </div>										
                                    <!-- MUNKA STÁTUSZ -->	
                                    <div class="form-group">
                                        <label for="job_status" class="control-label">Státusz</label>
                                        <select name="job_status" class="form-control input-xlarge">
                                            <option value="1" <?php echo ($actual_job[0]['job_status'] == 1) ? 'selected' : ''; ?>>Aktív</option>
                                            <option value="0" <?php echo ($actual_job[0]['job_status'] == 0) ? 'selected' : ''; ?>>Inaktív</option>
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
</div><!-- END CONTAINER -->
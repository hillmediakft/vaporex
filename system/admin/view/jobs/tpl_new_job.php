<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
				<!-- BEGIN PAGE HEADER-->
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<!-- 
					<h3 class="page-title">
						Munka <small>hozzáadása</small>
					</h3>
					-->

					<div class="page-bar">
						<ul class="page-breadcrumb">
							<li>
								<i class="fa fa-home"></i>
								<a href="admin/home">Kezdőoldal</a> 
								<i class="fa fa-angle-right"></i>
							</li>
							<li><span>Munka hozzáadása</span></li>
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

					<form action="" method="POST" id="new_job">	
						
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
									Munka hozzáadása
								</div>
								<div class="actions">
									<button class="btn green btn-sm" type="submit"><i class="fa fa-check"></i> Mentés</button>
									<a class="btn default btn-sm" href="admin/jobs"><i class="fa fa-close"></i> Mégsem</a>
									<!-- <button class="btn default btn-sm" name="cancel" type="button"><i class="fa fa-close"></i> Mégsem</button>-->
								</div>
							</div>
							<div class="portlet-body">

								<div class="space10"></div>							
								<div class="row">	
									<div class="col-md-12">						
									
                                    <?php if(Session::get('user_role_id') == 1){ ?>
                                     <!-- REFERENS -->
										<div class="form-group">
											<label for="job_ref_id" class="control-label">Referens</label>
											<select name="job_ref_id" class="form-control input-xlarge">
												<?php
                                                    $userid = Session::get('user_id');
                                                    foreach($user_list as $value) { ?>
												    <option value="<?php echo $value['user_id']; ?>" <?php echo ($value['user_id'] == $userid) ? 'selected' : ''; ?>><?php echo $value['user_first_name'] . ' ' . $value['user_last_name']; ?></option>
												<?php } ?>
											</select>
										</div>                                              
                                    <?php } ?>   
                                        <?php ?>
                                    <!-- MUNKA MEGNEVEZÉSE -->	
										<div class="form-group">
											<label for="job_title" class="control-label">Megnevezés <span class="required">*</span></label>
											<input type="text" name="job_title" id="job_title" placeholder="" class="form-control input-xlarge" />
										</div>
									<!-- MUNKA LEÍRÁSA -->	
										<div class="form-group">
											<label for="job_description" class="control-label">Leírás</label>
											<textarea name="job_description" id="job_description" placeholder="" class="form-control input-xlarge" rows="10"></textarea>
										</div>										
									<!-- MUNKA KATEGÓRIA -->	
										<div class="form-group">
											<label for="job_category_id" class="control-label">Kategória <span class="required">*</span></label>
											<select name="job_category_id" class="form-control input-xlarge">
												<option value="">Válasszon</option>
												<?php foreach($jobs_list as $value) { ?>
												<option value="<?php echo $value['job_list_id']; ?>"><?php echo $value['job_list_name']; ?></option>
												<?php } ?>
											</select>
										</div>
									<!-- FIZETÉS MEGADÁSA -->	
										<div class="form-group">
											<label for="job_pay" class="control-label">Fizetés</label>
											<input type="text" name="job_pay" id="job_pay" placeholder="" class="form-control input-xlarge" />
										</div>
									<!-- MUNKAIDŐ MEGADÁSA -->	
										<div class="form-group">
											<label for="job_working_hours" class="control-label">Munkaidő</label>
											<input type="text" name="job_working_hours" id="job_working_hours" placeholder="" class="form-control input-xlarge" />
										</div>
									<!-- MEGYE MEGADÁSA -->	
										<div class="form-group">
											<label for="job_county_id" class="control-label">Megye <span class="required">*</span></label>
											<select name="job_county_id" id="county_select" class="form-control input-xlarge">
												<option value="">Válasszon</option>
												<?php foreach($county_list as $value) { ?>
												<option value="<?php echo $value['county_id']; ?>"><?php echo $value['county_name']; ?></option>
												<?php } ?>
											</select>
										</div>										
									<!-- VÁROS MEGADÁSA -->	
										<div class="form-group" id="city_div" style="display: none;">
											<label for="job_city_id" class="control-label">Város <span class="required">*</span></label>
											<select name="job_city_id" class="form-control input-xlarge">
											<!-- ide jön a városlista AJAX hívással -->
											</select>
										</div>
									<!-- KERÜLET MEGADÁSA -->	
										<div class="form-group" id="district_div" style="display: none;">
											<label for="job_district_id" class="control-label">Kerület <span class="required">*</span></label>
											<select name="job_district_id" class="form-control input-xlarge">
												<?php foreach($district_list as $value) { ?>
												<option value="<?php echo $value['district_id']; ?>"><?php echo $value['district_name']; ?></option>
												<?php } ?>
											</select>
										</div>	
									<!-- CÉG MEGADÁSA -->	
										<div class="form-group">
											<label for="job_employer_id" class="control-label">Cég kiválasztása</label>
											<select name="job_employer_id" class="form-control input-xlarge">
												<option value="">Válasszon</option>
												<?php foreach($employer_list as $value) { ?>
												<option value="<?php echo $value['employer_id']; ?>"><?php echo $value['employer_name']; ?></option>
												<?php } ?>
											</select>
										</div>	
									<!-- FELTÉTEL -->	
										<div class="form-group">
											<label for="job_conditions" class="control-label">Munkához szükséges feltételek</label>
											<textarea name="job_conditions" id="job_conditions" placeholder="" class="form-control input-xlarge"></textarea>
										</div>										
									<!-- LEJÁRAT DÁTUMA DATEPICKER JS PLUGIN-NAL-->	
										<div class="form-group">
											<label for="job_expiry_date" class="control-label">Munka lejáratának dátuma</label>
											<input class="form-control form-control-inline input-medium date-picker" name="job_expiry_timestamp" id="job_expiry_timestamp" placeholder="nincs" size="16" type="text" value=""/>
										</div>										
									<!-- MUNKA STÁTUSZ -->	
										<div class="form-group">
											<label for="job_status" class="control-label">Státusz</label>
											<select name="job_status" class="form-control input-xlarge">
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
</div><!-- END CONTAINER -->
<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
		<!-- BEGIN PAGE HEADER-->
			<!-- BEGIN PAGE TITLE & BREADCRUMB-->
			<!-- 
			<h3 class="page-title">
				Munkaadó <small>módosítása</small>
			</h3>
			-->

			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="admin/home">Kezdőoldal</a> 
						<i class="fa fa-angle-right"></i>
					</li>
					<li><span>Munkaadó módosítása</span></li>
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

					<form action="" method="POST" id="employer_update" name="employer_update">	
					
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
									Munkaadó módosítása
								</div>
								<div class="actions">
									<button class="btn green btn-sm" type="submit"><i class="fa fa-check"></i> Mentés</button>
									<a class="btn default btn-sm" href="admin/employer"><i class="fa fa-close"></i> Mégsem</a>
									<!-- <button class="btn default btn-sm" name="cancel" type="button"><i class="fa fa-close"></i> Mégsem</button>-->
								</div>
							</div>
			
							<div class="portlet-body">
								<div class="space10"></div>							
								<div class="row">	
									<div class="col-md-12">						
									
									<!-- CÉG MEGNEVEZÉSE -->	
										<div class="form-group">
											<label for="employer_name" class="control-label">Cég neve <span class="required">*</span></label>
											<input type="text" name="employer_name" id="employer_name" placeholder="" class="form-control input-xlarge" value="<?php echo $employer_data[0]['employer_name']; ?>" />
										</div>
									<!-- CÉG CÍME -->	
										<div class="form-group">
											<label for="employer_address" class="control-label">Cím <span class="required">*</span></label>
											<input type="text" name="employer_address" id="employer_address" placeholder="" class="form-control input-xlarge" value="<?php echo $employer_data[0]['employer_address']; ?>"/>
										</div>
									<!-- KONTAKT SZEMÉLY NEVE -->	
										<div class="form-group">
											<label for="employer_contact_person" class="control-label">Kapcsolattartó személy neve <span class="required">*</span></label>
											<input type="text" name="employer_contact_person" id="employer_contact_person" placeholder="" class="form-control input-xlarge" value="<?php echo $employer_data[0]['employer_contact_person']; ?>"/>
										</div>
									<!-- KONTAKT TELEFONSZÁM -->	
										<div class="form-group">
											<label for="employer_contact_tel" class="control-label">Telefonszám <span class="required">*</span></label>
											<input type="text" name="employer_contact_tel" id="employer_contact_tel" placeholder="" class="form-control input-xlarge" value="<?php echo $employer_data[0]['employer_contact_tel']; ?>"/>
										</div>
									<!-- KONTAKT EMAIL -->	
										<div class="form-group">
											<label for="employer_contact_email" class="control-label">E-mail cím</label>
											<input type="text" name="employer_contact_email" id="employer_contact_email" placeholder="" class="form-control input-xlarge" value="<?php echo $employer_data[0]['employer_contact_email']; ?>"/>
										</div>
									<!-- MEGJEGYZÉS -->	
										<div class="form-group">
											<label for="employer_remark" class="control-label">Megjegyzés</label>
											<textarea name="employer_remark" id="employer_remark" placeholder="" class="form-control input-xlarge" rows="10"><?php echo $employer_data[0]['employer_remark']; ?></textarea>
										</div>										
									<!-- MUNKAADÓ STÁTUSZ -->	
										<div class="form-group">
											<label for="employer_status">Státusz</label>
											<select name="employer_status" class="form-control input-xlarge">
												<option value="1" <?php echo ($employer_data[0]['employer_status'] == 1) ? 'selected' : ''; ?>>Aktív</option>
												<option value="0" <?php echo ($employer_data[0]['employer_status'] == 0) ? 'selected' : ''; ?>>Inaktív</option>
											</select>
										</div>

									</div>
								</div>	

							</div> <!-- END PORTLET BODY-->
						</div> <!-- END PORTLET-->
					</form>

				</div> <!-- END COL-MD-12 -->
			</div> <!-- END ROW -->	
		</div> <!-- END PAGE CONTENT-->    
	</div> <!-- END PAGE CONTENT WRAPPER -->
</div><!-- END CONTAINER -->
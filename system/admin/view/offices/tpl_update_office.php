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
							<li>
								<a href="admin/offices">Irodák</a> 
								<i class="fa fa-angle-right"></i>
							</li>
							<li><span>Iroda adatok módosítása</span></li>
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

					<form action="" method="POST" id="office_data_form">	
						
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
									Iroda hozzáadása
								</div>
								<div class="actions">
									<button class="btn green btn-sm" type="submit"><i class="fa fa-check"></i> Mentés</button>
									<a class="btn default btn-sm" href="admin/offices"><i class="fa fa-close"></i> Mégsem</a>
									<!-- <button class="btn default btn-sm" name="cancel" type="button"><i class="fa fa-close"></i> Mégsem</button>-->
								</div>
							</div>
							<div class="portlet-body">

								<div class="space10"></div>							
								<div class="row">	
									<div class="col-md-12">						
									
                                    <!-- IRODA MEGNEVEZÉSE -->	
										<div class="form-group">
											<label for="office_name" class="control-label">Város, vagy régió <span class="required">*</span></label>
											<input type="text" name="office_name" id="office_name" class="form-control input-xlarge" value="<?php echo $office['office_name']; ?>" />
										</div>
									<!-- IRODA CÍM -->
								        <div class="form-group">
											<label for="office_address" class="control-label">Cím <span class="required">*</span></label>
											<input type="text" name="office_address" id="office_address" class="form-control input-xlarge" value="<?php echo $office['office_address']; ?>"/>
										</div>	
									<!-- TELEFON -->
								        <div class="form-group">
											<label for="office_telefon" class="control-label">Telefon</label>
											<input type="text" name="office_telefon" id="office_telefon" class="form-control input-xlarge" value="<?php echo $office['office_telefon']; ?>"/>
										</div>	
									<!-- MOBILTELEFON -->	
										<div class="form-group">
											<label for="office_mobil" class="control-label">Mobil</label>
											<input type="text" name="office_mobil" id="office_mobil" class="form-control input-xlarge" value="<?php echo $office['office_mobil']; ?>"/>
										</div>
									<!-- MOBILTELEFON 2 -->	
										<div class="form-group">
											<label for="office_mobil_2" class="control-label">Mobil 2.</label>
											<input type="text" name="office_mobil_2" id="office_mobil_2" class="form-control input-xlarge" value="<?php echo $office['office_mobil_2']; ?>"/>
										</div>
									<!-- FAX -->	
										<div class="form-group">
											<label for="office_fax" class="control-label">Fax</label>
											<input type="text" name="office_fax" id="office_fax" class="form-control input-xlarge" value="<?php echo $office['office_fax']; ?>"/>
										</div>
									<!-- EMAIL -->	
										<div class="form-group">
											<label for="office_email" class="control-label">E-mail</label>
											<input type="text" name="office_email" id="office_email" class="form-control input-xlarge" value="<?php echo $office['office_email']; ?>"/>
										</div>
									<!-- EMAIL 2 -->	
										<div class="form-group">
											<label for="office_email_2" class="control-label">E-mail 2.</label>
											<input type="text" name="office_email_2" id="office_email_2" class="form-control input-xlarge" value="<?php echo $office['office_email_2']; ?>"/>
										</div>										
									<!-- NYITVATARTÁS -->	
										<div class="form-group">
											<label for="office_opening" class="control-label">Nyitvatartás</label>
		    								<textarea name="office_opening" id="office_opening" class="form-control input-xlarge" rows="5"><?php echo $office['office_opening']; ?></textarea>
        			                        <!-- <input type="text" name="office_opening" id="office_opening" class="form-control input-xlarge" /> -->
										</div>										
									<!-- HELYZET SZÉLESSÉGI KOORDINÁTA  -->
								        <div class="form-group">
											<label for="office_latitude" class="control-label">Szélességi koordináta</label>
											<input type="text" name="office_latitude" id="office_latitude" class="form-control input-xlarge" value="<?php echo $office['office_latitude']; ?>"/>
										</div>	
									<!-- HELYZET HOSSZÚSÁGI KOORDINÁTA  -->	
										<div class="form-group">
											<label for="office_longitude" class="control-label">Hosszúsági koordináta</label>
											<input type="text" name="office_longitude" id="office_longitude" class="form-control input-xlarge" value="<?php echo $office['office_longitude']; ?>"/>
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
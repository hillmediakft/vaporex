<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
		<!-- BEGIN PAGE HEADER-->
			<!-- BEGIN PAGE TITLE & BREADCRUMB-->
			<!-- 
			<h3 class="page-title">
				Előregisztráció <small>módosítása</small>
			</h3>
			-->		

			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="admin/home">Kezdőoldal</a> 
						<i class="fa fa-angle-right"></i>
					</li>
					<li><span>Előregisztráció módosítása</span></li>
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

					<form action="" method="POST" id="update_prereg">

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
									Előregisztráció módosítása
								</div>
								<div class="actions">
									<button class="btn green btn-sm" type="submit"><i class="fa fa-check"></i> Mentés</button>
									<a class="btn default btn-sm" href="admin/pre_register"><i class="fa fa-close"></i> Mégsem</a>
									<!-- <button class="btn default btn-sm" name="cancel" type="button">Mégsem</button>-->
								</div>							
							</div>

							<div class="portlet-body">

								<div class="space10"></div>							
								<div class="row">	
									<div class="col-md-12">						

									<!-- NÉV -->	
										<div class="form-group">
											<label for="name" class="control-label">Név <span class="required">*</span></label>
											<input type="text" name="name" id="name" class="form-control input-xlarge" value="<?php echo $content['name']; ?>"/>
										</div>
									<!-- ANYJA NEVE -->	
										<div class="form-group">
											<label for="mother_name" class="control-label">Anyja neve <span class="required">*</span></label>
											<input type="text" name="mother_name" id="mother_name" class="form-control input-xlarge" value="<?php echo $content['mother_name']; ?>"/>
										</div>
									<!-- SZÜLETÉSI HELY -->	
										<div class="form-group">
											<label for="birth_place" class="control-label">Születési hely <span class="required">*</span></label>
											<input type="text" name="birth_place" id="birth_place" class="form-control input-xlarge" value="<?php echo $content['birth_place']; ?>"/>
										</div>
									<!-- SZÜLETÉSI IDŐ -->	
										<div class="form-group">
											<label for="birth_time" class="control-label">Születési idő <span class="required">*</span></label>
											<input type="text" name="birth_time" id="birth_time" class="form-control input-xlarge" value="<?php echo $content['birth_time']; ?>"/>
										</div>
									<!-- NEMZETISÉG -->	
										<div class="form-group">
											<label for="nationality" class="control-label">Nemzetiség <span class="required">*</span></label>
											<input type="text" name="nationality" id="nationality" class="form-control input-xlarge" value="<?php echo $content['nationality']; ?>"/>
										</div>
										
										<hr/>
										
									<!-- DIÁKIGAZOLVÁNY SZÁMA -->	
										<div class="form-group">
											<label for="student_card_number" class="control-label">Diákigazolvány száma <span class="required">*</span></label>
											<input type="text" name="student_card_number" id="student_card_number" class="form-control input-xlarge" value="<?php echo $content['student_card_number']; ?>"/>
										</div>
									<!-- TAJ KÁRTYA SZÁMA -->	
										<div class="form-group">
											<label for="taj_number" class="control-label">TAJ szám <span class="required">*</span></label>
											<input type="text" name="taj_number" id="taj_number" class="form-control input-xlarge" value="<?php echo $content['taj_number']; ?>"/>
										</div>
									<!-- ADÓAZONOSÍTÓ JEL -->	
										<div class="form-group">
											<label for="tax_id" class="control-label">Adóazonosító jel <span class="required">*</span></label>
											<input type="text" name="tax_id" id="tax_id" class="form-control input-xlarge" value="<?php echo $content['tax_id']; ?>"/>
										</div>
									<!-- BANKSZÁMLA SZÁMA -->	
										<div class="form-group">
											<label for="bank_account_number" class="control-label">Bankszámla száma <span class="required">*</span></label>
											<input type="text" name="bank_account_number" id="bank_account_number" class="form-control input-xlarge" value="<?php echo $content['bank_account_number']; ?>"/>
										</div>
									<!-- BANKSZÁMLA SZÁMA -->	
										<div class="form-group">
											<label for="bank_name" class="control-label">Számlavezető bank neve <span class="required">*</span></label>
											<input type="text" name="bank_name" id="bank_name" class="form-control input-xlarge" value="<?php echo $content['bank_name']; ?>"/>
										</div>
										
										<hr/>
										
									<!-- ÁLLANDÓ LAKCÍM -->	
										<div class="form-group">
											<label for="permanent_address" class="control-label">Állandó lakcím <span class="required">*</span></label>
											<input type="text" name="permanent_address" id="permanent_address" class="form-control input-xlarge" value="<?php echo $content['permanent_address']; ?>"/>
										</div>
									<!-- ÁLLANDÓ LAKCÍM -->	
										<div class="form-group">
											<label for="contact_address" class="control-label">Elérhetőségi cím</label>
											<input type="text" name="contact_address" id="contact_address" class="form-control input-xlarge" value="<?php echo $content['contact_address']; ?>"/>
										</div>
									<!-- EMAIL CÍM -->	
										<div class="form-group">
											<label for="email_address" class="control-label">E-mail cím <span class="required">*</span></label>
											<input type="text" name="email_address" id="email_address" class="form-control input-xlarge" value="<?php echo $content['email_address']; ?>"/>
										</div>

									<!-- MOBILTELEFON -->	
										<div class="form-group">
											<label for="telefon_number" class="control-label">Mobiltelefon:</label>
											<input type="text" name="telefon_number" id="telefon_number" class="form-control input-xlarge" value="<?php echo $content['telefon_number']; ?>"/>
										</div>
										
										<hr/>
										
									<!-- ISKOLAI VÉGZETTSÉG -->	
										<div class="form-group">
											<label for="school_type" class="control-label">Iskolai végzettség <span class="required">*</span></label>
											<select name="school_type" class="form-control input-xlarge">
												<option id="altalanos" value="1" <?php echo ($content['school_type'] == 1) ? 'selected' : ''; ?>>Általános iskola</option>
												<option id="kozepiskola" value="2" <?php echo ($content['school_type'] == 2) ? 'selected' : ''; ?>>Középiskola</option>
												<option id="foiskola" value="3" <?php echo ($content['school_type'] == 3) ? 'selected' : ''; ?>>Főiskola / egyetem</option>
											</select>
										</div>

									<!-- Jelenlegi iskola adatai -->	
										<div class="form-group">
											<label for="school_data" class="control-label">Jelenelegi oktatási intézmény adatai <span class="required">*</span></label>
											<input type="text" name="school_data" id="school_data" class="form-control input-xlarge" value="<?php echo $content['school_data']; ?>"/>
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
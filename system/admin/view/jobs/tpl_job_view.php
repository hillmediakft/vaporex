<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
				<!-- BEGIN PAGE HEADER-->
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<!-- 
					<h3 class="page-title">
						Munka <small>részletek</small>
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
								<a href="admin/jobs">Munkák listája</a>
								<i class="fa fa-angle-right"></i>
							</li>
							<li>
								<a href="admin/jobs/view_job">Munka részletek</a>
							</li>
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
								<div class="caption"><i class="fa fa-cogs"></i>Munka részletek</div>
							</div>
			
							<div class="portlet-body">
								<div class="space10"></div>							
								<div class="row">
								<div class="col-md-6">		

										<p><strong>Munka azonosító száma: &nbsp;</strong> <?php echo $content[0]['job_id']; ?></p>
										<div class="space10"></div>

										<p><strong>Munka megnevezése: &nbsp;</strong> <?php echo $content[0]['job_title']; ?></p>
										<div class="space10"></div>

										<p><strong>Munkadó: &nbsp;</strong> <?php echo $content[0]['employer_name']; ?></p>
										<div class="space10"></div>

										<p><strong>Munka típusa: &nbsp;</strong><?php echo $content[0]['job_list_name']; ?></p>
										<div class="space10"></div>
										
										<p><strong>Munka leírása: &nbsp;</strong></p>
										<p><?php echo $content[0]['job_description']; ?></p>
										<div class="space10"></div>
										
										<p><strong>Munka feltételek: &nbsp;</strong></p>
										<p><?php echo $content[0]['job_conditions']; ?></p>
										<div class="space10"></div>

										<p><strong>Munka helye: &nbsp;</strong><?php echo ($content[0]['county_name'] == 'Budapest') ? 'Budapest ' . $content[0]['district_name'] . ' kerület' : $content[0]['city_name']; ?></p>
										<div class="space10"></div>

										<p><strong>Munkaidő: &nbsp;</strong><?php echo $content[0]['job_working_hours']; ?></p>
										<div class="space10"></div>
										
										<p><strong>Fizetés: &nbsp;</strong><?php echo $content[0]['job_pay']; ?></p>
										<div class="space10"></div>

										<p><strong>Munka lejárati ideje: &nbsp;</strong><?php echo (empty($content[0]['job_expiry_timestamp'])) ? 'nincs lejárati idő megadva' : date('Y-m-d', $content[0]['job_expiry_timestamp']); ?></p>
										<div class="space10"></div>	

										<p><strong>Létrehozás dátuma: &nbsp;</strong><?php echo (date('Y-m-d', $content[0]['job_create_timestamp'])); ?></p>
										<div class="space10"></div>	

										<p><strong>Módosítás dátuma: &nbsp;</strong><?php echo (empty($content[0]['job_update_timestamp'])) ? 'még nem módosították' : date('Y-m-d', $content[0]['job_update_timestamp']); ?></p>
										<div class="space10"></div>		

										<p><strong>Státusz: &nbsp;</strong><?php echo ($content[0]['job_status'] == 0) ? 'Inaktív' : 'Aktív'; ?></p>
										<div class="space10"></div>									
									</div>
								</div>	
									

							</div> <!-- END USER GROUPS PORTLET BODY-->
						</div> <!-- END USER GROUPS PORTLET-->
				</div> <!-- END COL-MD-12 -->
			</div> <!-- END ROW -->	
		</div> <!-- END PAGE CONTENT-->    
	</div> <!-- END PAGE CONTENT WRAPPER -->
</div><!-- END CONTAINER -->
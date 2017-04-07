<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
				<!-- BEGIN PAGE HEADER-->
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<!-- 
					<h3 class="page-title">
						Munka <small>kategóriák</small>
					</h3>
					-->
					
					<div class="page-bar">
						<ul class="page-breadcrumb">
							<li>
								<i class="fa fa-home"></i>
								<a href="admin/home">Kezdőoldal</a> 
								<i class="fa fa-angle-right"></i>
							</li>
							<li><span>Irodák listája</span></li>
						</ul>
					</div>
					<!-- END PAGE TITLE & BREADCRUMB-->
				<!-- END PAGE HEADER-->
		
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">

                        <div id="ajax_message"></div> 
						<!-- echo out the system feedback (error and success messages) -->
						<?php $this->renderFeedbackMessages(); ?>
	
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet">
							<div class="portlet-title">
								<div class="caption"><i class="fa fa-cogs"></i>Irodák listája</div>
								
									<div class="actions">
										<a href="admin/offices/insert" class="btn blue-steel btn-sm"><i class="fa fa-plus"></i> Iroda hozzáadása</a>
									</div>
								
							</div>
							<div class="portlet-body">
	



					<table class="table table-striped table-bordered table-hover" id="office_list">
						<thead>
							<tr>
								<th>Neve</th>
								<th>Cím</th>
								<th style="width:0px;"></th>
							</tr>
						</thead>
						<tbody>

					
		<?php foreach($offices as $value) { ?>

			<tr class="odd gradeX">
				<td><?php echo $value['office_name']; ?></td>
				<td><?php echo $value['office_address']; ?></td>
				
				<td>									
					<div class="actions">
						<div class="btn-group">
							<a class="btn btn-sm grey-steel" href="#" title="műveletek" data-toggle="dropdown" <?php echo (Session::get('user_role_id') <= 2) ? '' : 'disabled';?>>
								<i class="fa fa-cogs"></i>
							</a>
							<ul class="dropdown-menu pull-right">
								<?php if (Session::get('user_role_id') <= 2) { ?>	
									<li><a href="admin/offices/update/<?php echo $value['office_id'];?>"><i class="fa fa-pencil"></i> Szerkeszt</a></li>
								<?php } ?>
								
								<li><a class="delete_office_class" href="" data-id="<?php echo $value['office_id'];?>"><i class="fa fa-trash"></i> Töröl</a></li>
							</ul>
						</div>
					</div>
				</td>
				
			</tr>

		<?php } ?>	
		
						</tbody>
					</table>

								
							</div> <!-- END USER GROUPS PORTLET BODY-->
						</div> <!-- END USER GROUPS PORTLET-->
						

						
						
				</div> <!-- END COL-MD-12 -->
			</div> <!-- END ROW -->	
		</div> <!-- END PAGE CONTENT-->    
	</div> <!-- END PAGE CONTENT WRAPPER -->
</div> <!-- END CONTAINER -->
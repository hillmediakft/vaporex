<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<div class="page-content">
	<!-- BEGIN PAGE HEADER-->
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<!-- <h3 class="page-title">Munkák <small>listája</small></h3> -->
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="admin/home">Kezdőoldal</a> 
				</li>
			</ul>
		</div>
		<!-- END PAGE TITLE & BREADCRUMB-->
	<!-- END PAGE HEADER-->
		
		
		<!-- BEGIN PAGE CONTENT-->
		<div class="row">
			<div class="col-md-12">
				
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption"><i class="fa fa-cogs"></i>Regisztrált felhasználók</div>
							<div class="actions">
								<div class="btn-group">
									<a data-toggle="dropdown" href="#" class="btn btn-sm default">
										<i class="fa fa-wrench"></i> Eszközök <i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu pull-right">
										<li>
											<a href="#" id="print_register"><i class="fa fa-print"></i> Nyomtat </a>
										</li>
										<li>
											<a href="#" id="export_register"><i class="fa fa-file-excel-o"></i> Export CSV </a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="portlet-body">
<!-- *************************** regisztráltak TÁBLA *********************************** -->						
							
		<!-- echo out the system feedback (error and success messages) -->
		<?php $this->renderFeedbackMessages(); ?>				
		<div id="ajax_message"></div> 						
				
							
						<div class="table-container">
							<div class="table-actions-wrapper">
								<span>
								</span>
								<select class="table-group-action-input form-control input-inline input-small input-sm">
									<option value="">Válasszon</option>
									<option value="group_delete">Töröl</option>
								</select>
								<button class="btn btn-sm grey-cascade table-group-action-submit" title="Csoportos művelet végrehajtása"><i class="fa fa-check"></i> Csoportművelet</button>
							</div>							

							<table class="table table-striped table-bordered table-hover" id="register_subscribe_table">
								<thead>
									<tr role="row" class="heading">
										<th width="1%">
											<input type="checkbox" class="group-checkable">
										</th>
										<th width="10%">
											#id
										</th>
										<th width="15%">
											Név
										</th>
										<th width="15%">
											E-mail
										</th>
										<th width="10%">
											Status
										</th>
										<th width="10%">
											Hírlevél
										</th>
										<th width="1%">
											
										</th>
									</tr>
									<tr role="row" class="filter">
										<td>
										</td>
										<td>
											<input type="text" class="form-control form-filter input-sm" name="search_user_id">
										</td>
										<td>
											<input type="text" class="form-control form-filter input-sm" name="search_name">
										</td>
										<td>
											<input type="text" class="form-control form-filter input-sm" name="search_email">
										</td>
										<td>
											<select name="search_status" class="form-control form-filter input-sm">
												<option value="">Válasszon</option>
												<option value="1">Aktív</option>
												<option value="0">Inaktív</option>
											</select>								
										</td>
										<td>
											<select name="search_newsletter" class="form-control form-filter input-sm">
												<option value="">Válasszon</option>
												<option value="1">Kér hírlevelet</option>
												<option value="0">Nem kér hírlevelet</option>
											</select>												
										</td>
										<td>
											<div style="width:80px">
												<button class="btn btn-sm grey-cascade filter-submit margin-bottom" title="Szűrés indítása"><i class="fa fa-search"></i></button>
												<button class="btn btn-sm grey-cascade filter-cancel" title="Szűrési feltételek törlése"><i class="fa fa-times"></i></button>
											</div>
											<!-- <div class="margin-bottom-5"></div>-->
										</td>
									</tr>
								</thead>								
								<tbody>
								<!-- A PHP ÉS A DATATABLE GENERÁLJA A TARTALMAT -->
								</tbody>
							</table>	
						</div> <!-- table container end -->
							
							
						</div> <!-- END PORTLET BODY -->
					</div> <!-- END PORTLET -->
					

			</div>
		</div>
	</div>
		<!-- END PAGE CONTAINER-->    
</div>                                                            
		<!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <!-- <h3 class="page-title">Rendezvények <small>listája</small></h3> -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="admin/home">Kezdőoldal</a> 
                    <i class="fa fa-angle-right"></i>
                </li>
                <li><a href="admin/rendezvenyek">Rendezvények listája</a></li>
            </ul>
        </div>
        <!-- END PAGE TITLE & BREADCRUMB-->
        <!-- END PAGE HEADER-->


        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">

                <!-- RÉSZLETEK MEGJELENÍTÉSE MODAL -->	
                <div class="modal" id="ajax_modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content" id="modal_container"></div>
                    </div>
                </div>	
                <!-- RÉSZLETEK MEGJELENÍTÉSE MODAL END -->	

                <!-- echo out the system feedback (error and success messages) -->
                <?php $this->renderFeedbackMessages(); ?>				

                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-cogs"></i>Rendezvények listája</div>
                        <div class="actions">
                            <a href="admin/rendezvenyek" class="btn blue-madison btn-sm"><i class="fa fa-refresh"></i> Újratöltés</a>
                            <a href="admin/rendezvenyek/uj_rendezveny" class="btn blue-steel btn-sm"><i class="fa fa-plus"></i> Új rendezvény</a>
                            <!-- <button class="btn red btn-sm" name="delete_job_submit" value="submit" type="submit"><i class="fa fa-trash"></i> Csoportos törlés</button> -->
                            <div class="btn-group">
                                <a data-toggle="dropdown" href="#" class="btn btn-sm default">
                                    <i class="fa fa-wrench"></i> Eszközök <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="#" id="print_rendezvenyek"><i class="fa fa-print"></i> Nyomtat </a>
                                    </li>
                                    <li>
                                        <a href="#" id="export_rendezvenyek"><i class="fa fa-file-excel-o"></i> Export CSV </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
    
                        <!-- ****************** RENDEZVÉNYEK TÁBLA ************** -->						
                        <div id="ajax_message"></div> 						


                        <div class="table-container">
                            <div class="table-actions-wrapper">
                                <span>
                                </span>
                                <select class="table-group-action-input form-control input-inline input-small input-sm">
                                    <option value="">Válasszon</option>
                                    <option value="group_make_active">Aktív</option>
                                    <option value="group_make_inactive">Inaktív</option>
                                    <option value="group_delete">Töröl</option>
                                </select>
                                <button class="btn btn-sm grey-cascade table-group-action-submit" title="Csoportos művelet végrehajtása"><i class="fa fa-check"></i> Csoportművelet</button>
                            </div>							

                            <table class="table table-striped table-bordered table-hover" id="rendezvenyek">
                                <thead>
                                    <tr role="row" class="heading">
                                        <th width="1%">
                                            <input type="checkbox" class="group-checkable">
                                        </th>
                                        <th width="10%">
                                            #id
                                        </th>
                                        <th width="1%">
                                            Kép
                                        </th>
                                        <th width="10%">
                                            Város
                                        </th>
                                        <th width="10%">
                                            Név
                                        </th>
                                        <th width="10%">
                                            Helyszín
                                        </th>
                                        <th width="10%">
                                            Időpont
                                        </th>
                                        <th width="0%">
                                            Klikk
                                        </th>
                                        <th width="10%">
                                            Státusz
                                        </th>
                                        <th width="1%">

                                        </th>
                                    </tr>
                                    <tr role="row" class="filter">
                                        <td>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm" name="search_rendezveny_id">
                                        </td>
                                        <td></td>
                                        <td>
                                            <select name="search_city_id" class="form-control form-filter input-sm">
                                                <option value="">Válasszon</option>
                                                <?php foreach ($city_list as $value) { ?>
                                                    <option value="<?php echo $value['city_id']; ?>"><?php echo $value['city_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <select name="search_status" class="form-control form-filter input-sm">
                                                <option value="">Válasszon</option>
                                                <option value="1">Aktív</option>
                                                <option value="0">Inaktív</option>
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
<div id="loadingDiv" style="display:none;"><img src="public/admin_assets/img/loader.gif"></div>	
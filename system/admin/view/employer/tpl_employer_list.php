<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
                <!-- <h3 class="page-title">Munkaadók <small>listája</small></h3> -->
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="admin/home">Kezdőoldal</a> 
                    <i class="fa fa-angle-right"></i>
                </li>
                <li><span>Munkaadók listája</span></li>
            </ul>
        </div>
        <!-- END PAGE TITLE & BREADCRUMB-->
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->

                <!-- ÜZENETEK -->
                <div id="ajax_message"></div> 						
                <?php $this->renderFeedbackMessages(); ?>				

                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-cogs"></i>Munkaadók listája</div>

                        <div class="actions">
                            <a href="admin/employer/insert" class="btn blue-steel btn-sm"><i class="fa fa-plus"></i> Új munkaadó</a>
                            <div class="btn-group">
                                <a data-toggle="dropdown" href="#" class="btn btn-sm default">
                                    <i class="fa fa-wrench"></i> Eszközök <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="#" id="print_employer"><i class="fa fa-print"></i> Nyomtat </a>
                                    </li>
                                    <li>
                                        <a href="#" id="export_employer"><i class="fa fa-file-excel-o"></i> Export CSV </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="portlet-body">

                        <!-- *************************** EMPLOYER TÁBLA *********************************** -->						

                        <table class="table table-striped table-bordered table-hover" id="employer">
                            <thead>
                                <tr>
                                    <th title="Azonosító szám">#id</th>
                                    <th>Cég neve</th>
                                    <th>Cím</th>
                                    <th>Kapcsolattartó</th>
                                    <th>Telefonszám</th>
                                    <th>E-mail</th>
                                    <th title="Munkák száma ennél a munkaadónál">Munkák</th>
                                    <th>Státusz</th>
                                    <th style="width:0px;"></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($all_employer as $value) { ?>
                                    <tr class="odd gradeX">
                                        <td>#<?php echo $value['employer_id']; ?></td>
                                        <td><?php echo $value['employer_name']; ?></td>
                                        <td><?php echo $value['employer_address']; ?></td>
                                        <td><?php echo $value['employer_contact_person']; ?></td>
                                        <td><?php echo $value['employer_contact_tel']; ?></td>
                                        <td><?php echo $value['employer_contact_email']; ?></td>
                                        <?php
                                        // megszámoljuk, hogy az éppen aktuális munkaadónak mennyi eleme van a jobs tábla job_employer_id oszlopában
                                        $counter = 0;
                                        foreach ($job_counter as $v) {
                                            if ($value['employer_id'] == $v['job_employer_id']) {
                                                $counter++;
                                            }
                                        }
                                        ?>
                                        <td><?php echo $counter; ?></td>
                                        <?php if ($value['employer_status'] == 1) { ?>
                                            <td><span class="label label-sm label-success">Aktív</span></td>
                                        <?php } ?>
                                        <?php if ($value['employer_status'] == 0) { ?>
                                            <td><span class="label label-sm label-danger">Inaktív</span></td>
                                        <?php } ?>				
                                        <td>									
                                            <div class="actions">
                                                <div class="btn-group">
                                                    <a class="btn btn-sm grey-steel" title="Műveletek" href="#" data-toggle="dropdown">
                                                        <i class="fa fa-cogs"></i>
                                                    </a>
                                                    <ul class="dropdown-menu pull-right">

                                                        <?php if ((Session::get('user_role_id') < 3)) { ?>	
                                                            <li><a href="<?php echo $this->registry->site_url . 'employer/update/' . $value['employer_id']; ?>"><i class="fa fa-pencil"></i> Szerkeszt</a></li>
                                                        <?php }; ?>

                                                        <?php if ((Session::get('user_role_id') < 3) && $counter == 0) { ?>	
                                                            <li><a href="<?php echo $this->registry->site_url . 'employer/delete/' . $value['employer_id']; ?>" id="delete_employer_<?php echo $value['employer_id']; ?>"> <i class="fa fa-trash"></i> Töröl</a></li>
                                                        <?php }; ?>

                                                        <?php if ((Session::get('user_role_id') < 3)) { ?>		
                                                            <?php if ($value['employer_status'] == 1) { ?>
                                                                <li><a rel="<?php echo $value['employer_id']; ?>" href="admin/employer/change_status" id="make_inactive_<?php echo $value['employer_id']; ?>" data-action="make_inactive"><i class="fa fa-ban"></i> Blokkol</a></li>
                                                            <?php } ?>
                                                            <?php if ($value['employer_status'] == 0) { ?>
                                                                <li><a rel="<?php echo $value['employer_id']; ?>" href="admin/employer/change_status" id="make_active_<?php echo $value['employer_id']; ?>" data-action="make_active"><i class="fa fa-check"></i> Aktivál</a></li>
                                                            <?php } ?>
                                                        <?php }; ?>	
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>	
                            </tbody>
                        </table>	
                    </div>
                </div><!-- END EXAMPLE TABLE PORTLET-->

            </div>
        </div>

        <div id="loadingDiv" style="display:none;"></div>	
    </div><!-- END PAGE CONTAINER-->    
</div><!-- END PAGE CONTENT WRAPPER -->
</div><!-- END CONTAINER -->

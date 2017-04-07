<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <!-- 
        <h3 class="page-title">
                Szolgáltatás <small>kategóriák</small>
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
                    <a href="admin/szolgaltatasok">Szolgáltatások listája</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li><span>Szolgáltatás kategóriák</span></li>
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
                        <div class="caption"><i class="fa fa-cogs"></i>Szolgáltatás kategóriák</div>

                        <div class="actions">
                            <a href="admin/szolgaltatasok/category_insert" class="btn blue-steel btn-sm"><i class="fa fa-plus"></i> Új kategória</a>

                        </div>

                    </div>
                    <div class="portlet-body">




                        <table class="table table-striped table-bordered table-hover" id="szolgaltatasok_category">
                            <thead>
                                <tr>
                                    <th style="width:1%;">kép</th>
                                    <th>Kategória neve</th>
                                    <th>Szolgáltatások ebben a kategóriában</th>
                                    <th style="width:0px;"></th>
                                </tr>
                            </thead>
                            <tbody>


                                <?php foreach ($all_szolgaltatasok_category as $value) { ?>

                                    <tr class="odd gradeX">
                                        <td>
                                            <img src="<?php echo Config::get('szolgaltatascategoryphoto.upload_path') . Util::thumb_path($value['szolgaltatas_list_photo']); ?>" alt="" />
                                        </td>
                                        <td><?php echo $value['szolgaltatas_list_name']; ?></td>
                                        <?php
                                        // megszámoljuk, hogy az éppen aktuális kategóriának mennyi eleme van a szolgaltatasok tábla szolgaltatasok_category_id oszlopában
                                        $counter = 0;
                                        foreach ($category_counter as $v) {
                                            if ($value['szolgaltatas_list_id'] == $v['szolgaltatas_category_id']) {
                                                $counter++;
                                            }
                                        }
                                        ?>
                                        <td><?php echo $counter; ?></td>


                                        <td>									
                                            <div class="actions">
                                                <div class="btn-group">
                                                    <a class="btn btn-sm grey-steel" href="#" title="műveletek" data-toggle="dropdown" <?php echo (Session::get('user_role_id') <= 2) ? '' : 'disabled'; ?>>
                                                        <i class="fa fa-cogs"></i>
                                                    </a>
                                                    <ul class="dropdown-menu pull-right">
                                                        <?php if (Session::get('user_role_id') <= 2) { ?>	
                                                            <li><a href="admin/szolgaltatasok/category_update/<?php echo $value['szolgaltatas_list_id']; ?>"><i class="fa fa-pencil"></i> Szerkeszt</a></li>
                                                            <li><a href="admin/szolgaltatasok/category_delete/<?php echo $value['szolgaltatas_list_id']; ?>" id="delete_category_<?php echo $value['szolgaltatas_list_id']; ?>"><i class="fa fa-trash"></i> Töröl</a></li>
                                                            <?php } ?>
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
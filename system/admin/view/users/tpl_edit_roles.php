<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Felhasználói jogosultságok <small>kezelése</small>
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="admin/home">Kezdőoldal</a> 
                    <i class="fa fa-angle-right"></i>
                </li>
                <li><a href="#">Felhasználói jogosultságok</a></li>
            </ul>
        </div>
        <!-- END PAGE TITLE & BREADCRUMB-->
        <!-- END PAGE HEADER-->


        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                
              <!-- echo out the system feedback (error and success messages) -->
                <?php $this->renderFeedbackMessages(); ?>
     
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-cog"></i>Jogosultságok szerkesztése</div>

                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            Felhasználói csoport: <span class="label label-info"><?php echo $role['role_name']; ?></span>

                        </div>


                        <form action="admin/users/edit_roles/<?Php echo $role['role_id']; ?>" method="POST" id="edit_roles">				
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr class="info">
                                        <th>Jogosultság</th>
                                        <th>Leírás</th>
                                        <th>Engedélyezés</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php foreach ($role_permissions as $value) { ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $value['perm_key']; ?></td>
                                            <td><?php echo $value['perm_desc']; ?></td>
                                            <td>
                                                <div class="form-group">
                                                    <select name="<?php echo $value['perm_key']; ?>" class="form-control small" <?php echo($value['perm_key'] == 'menu_home') ? 'disabled' : '';?>>
                                                        <option value="0" <?php echo(!$value['bool']) ? 'selected' : '';?>>Tiltott</option>
                                                        <option value="1" <?php echo($value['bool']) ? 'selected' : '';?>>Engedélyezett</option>
                                                    </select>
                                                </div>

                                               
                                            </td>

                                        </tr>
                                    <?php } ?>



                                </tbody>
                            </table>

                            <button class="btn green submit" type="submit" value="Mentés" name="submit_edit_roles">Mentés <i class="fa fa-check"></i></button>

                        </form>

                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>


    </div>
    <!-- END PAGE CONTAINER-->    
</div>                                                            
<!-- END PAGE -->
</div>
<!-- END CONTAINER -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><a href="<?php echo $create_search_year_link; ?>"
                            class="btn btn-primary pull-right" style="margin-top:-30px"><span
                                class="glyphicon glyphicon-plus-sign"></span> Add search year </a></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="searchyear" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width:2%">Sr.No</th>
                                <th>Search Year</th>
                                <th style="width:5%">Status</th>
                                <th style="width:15%"> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach (@$searchyeargetlists as $sn => $searchyear):
                                $delete_search_year_link_str = str_replace("{id}", $searchyear->searchyear_id, $delete_search_year_link);
                                $edit_search_year_link_str = str_replace("{id}", $searchyear->searchyear_id, $edit_search_year_link);
                                //$preview_url  = ($nomination->menu_type == 3) ? $nomination->menu_link : $this->route->site_url($nomination->menu_link);
                                // $view_nomination_link_str = str_replace("{id}", $nomination->id, $view_nomination_link);
                                ?>
                                <tr>
                                    <td style="text-align:center">
                                        <?= ++$sn; ?>
                                    </td>
                                    <td>
                                        <?= $searchyear->search_year ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php if ($searchyear->status == 1) {
                                            echo '<i class="fa fa-flag" aria-hidden="true"  style="color:green"></i>';
                                        } else {
                                            echo '<i class="fa fa-flag" aria-hidden="true" style="color:red"></i>';
                                        } ?>
                                    </td>
                                    <td>
                                        <!--  Form Start  --->
                                    <form method="post">
                                        <?php
                                        if ($is_superadmin == 1) { ?>
                                        <a href="<?php echo $edit_search_year_link_str; ?>" name="menu_update"
                                            class="iconSize">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="<?php echo $delete_search_year_link_str; ?>"
                                            onClick="return confirm('Are you sure you want to delete? ');"
                                            class="iconSize" name="delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <?php
                                        if (@$_GET['status'] == 0 && $searchyear->status != 1) {
                                            echo '<i class="fa fa-eye sy-publish-button" style="color:#007bff"></i>';
                                        }
                                        } else if ($is_admin == 1) { ?>
                                        <a href="<?php echo $edit_search_year_link_str; ?>" name="menu_update"
                                            class="iconSize">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="<?php echo $delete_search_year_link_str; ?>"
                                            onClick="return confirm('Are you sure you want to delete? ');"
                                            class="iconSize" name="delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <?php
                                        if (@$_GET['status'] == 0 && $searchyear->status != 1) {
                                            echo '<i class="fa fa-eye sy-publish-button" style="color:#007bff"></i>';
                                        }else{
                                            echo '<i class="fa fa-eye sy-unpublish-button" style="color:red;cursor:pointer" title="Unpublished"></i>';
                                        }
                                        } elseif ($is_uploader == 1) { ?>
                                        <a href="<?php echo $edit_search_year_link_str; ?>" name="menu_update"
                                            class="iconSize">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="<?php echo $delete_search_year_link_str; ?>"
                                            onClick="return confirm('Are you sure you want to delete?');"
                                            class="iconSize" name="delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <?php } else {
                                            if (@$_GET['status'] == 0 && $searchyear->status != 1) {
                                                echo '<i class="fa fa-eye sy-publish-button" style="color:#007bff"></i>';
                                            }
                                        }
                                        ?>
                                        <input type="hidden" value="<?= $searchyear->searchyear_id ?>" name="searchyear_id"
                                            id="searchyear_id">
                                    </form>
                                    <!--  Form Start  --->
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php //} 
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
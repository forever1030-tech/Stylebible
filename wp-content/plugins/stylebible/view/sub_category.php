<?php

function sub_category_manage(){
?>
    <script>
        var ajaxUrl = '<?php echo esc_url(home_url('/wp-admin/admin-ajax.php')); ?>';
    </script>
    <p id="success"></p>
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Manage <b>Sub Category</b></h2>
                </div>
                <div class="col-sm-6">
                    <a href="#addSubcategoryModal" class="btn btn-success" data-toggle="modal"><i class="material-icons"></i> <span>Add Sub Category</span></a>
                    <a href="JavaScript:void(0);" class="btn btn-danger" id="delete_multiple"><i class="material-icons"></i> <span>Delete</span></a>                       
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>
                        <span class="custom-checkbox">
                            <input type="checkbox" id="selectAll">
                            <label for="selectAll"></label>
                        </span>
                    </th>
                    <th>ID</th>
                    <th>Sub Category</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
            <?php
            global $wpdb;
            $result = $wpdb->get_results("SELECT * FROM wp_stylebible_sub_categories");
            $i=1;
            foreach ($result as $print)   
            {
            ?>
            <tr>
                <td>
                    <span class="custom-checkbox">
                        <input type="checkbox" class="user_checkbox" data-user-id="<?php echo $print->sub_cat_id; ?>">
                        <label for="checkbox2"></label>
                    </span>
                </td>
                <td><?php echo $i; ?></td>
                <td><?php echo $print->sub_cat_name; ?></td>
                <td>
                    <a href="#editSubcategoryModal" class="edit" data-toggle="modal">
                        <i class="material-icons update" data-toggle="tooltip"
                        data-id="<?php echo $print->sub_cat_id;?>" 
                        data-name="<?php echo $print->sub_cat_name;?>"
                        title="Edit"></i>
                    </a>
                    <a href="#deleteSubcategoryModal" class="delete" data-id="<?php echo $print->sub_cat_id; ?>" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" 
                     title="Delete"></i></a>
                </td>
            </tr>
            <?php 
            $i++;
            }
            ?>
            </tbody>
        </table>
            
    </div>
    <!-- Add Modal HTML -->
    <div id="addSubcategoryModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="user_form">
                    <div class="modal-header">                      
                        <h4 class="modal-title">Add Sub Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">                    
                        <div class="form-group">
                            <label>Sub Category</label>
                            <input type="text" id="sub_category" name="sub_category" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="1" name="type">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <a class="btn btn-success" id="btn-add">Add</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
    <div id="editSubcategoryModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="update_form">
                    <div class="modal-header">                      
                        <h4 class="modal-title">Edit Sub Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_u" name="id" class="form-control" required>                 
                        <div class="form-group">
                            <label>Sub Category</label>
                            <input type="text" id="sub_category_u" name="sub_category" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <input type="hidden" value="2" name="type">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <button type="button" class="btn btn-info" id="update">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Modal HTML -->
    <div id="deleteSubcategoryModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">                      
                        <h4 class="modal-title">Delete Sub Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_d" name="id" class="form-control">                  
                        <p>Are you sure you want to delete this sub category?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <button type="button" class="btn btn-danger" id="delete">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
}
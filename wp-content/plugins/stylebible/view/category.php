<?php

function category_manage(){
?>
    <script>
        var ajaxUrl = '<?php echo esc_url(home_url('/wp-admin/admin-ajax.php')); ?>';
    </script>
    <p id="success"></p>
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Manage <b>Category</b></h2>
                </div>
                <div class="col-sm-6">
                    <a href="#addCategoryModal" class="btn btn-success" data-toggle="modal"><i class="material-icons"></i> <span>Add Category</span></a>
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
                    <th>Category</th>
                    <th>Order Number</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
            <?php
            global $wpdb;
            $result = $wpdb->get_results("SELECT * FROM wp_stylebible_categories");
            $i=1;
            foreach ($result as $print)   
            {
            ?>
            <tr>
                <td>
                    <span class="custom-checkbox">
                        <input type="checkbox" class="user_checkbox" data-user-id="<?php echo $print->category_id; ?>">
                        <label for="checkbox2"></label>
                    </span>
                </td>
                <td><?php echo $i; ?></td>
                <td><?php echo $print->category_name; ?></td>
                <td><?php echo $print->order_number; ?></td>
                <td>
                    <a href="#editCategoryModal" class="edit" data-toggle="modal">
                        <i class="material-icons update" data-toggle="tooltip"
                        data-id="<?php echo $print->category_id;?>" 
                        data-name="<?php echo $print->category_name;?>"
                        data-order="<?php echo $print->order_number;?>"
                        title="Edit"></i>
                    </a>
                    <a href="#deleteCategoryModal" class="delete" data-id="<?php echo $print->category_id; ?>" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" 
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
    <div id="addCategoryModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="user_form">
                    <div class="modal-header">                      
                        <h4 class="modal-title">Add Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">                    
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" id="category" name="category" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Order Number</label>
                            <input type="number" id="order" name="order" class="form-control" min="0" max="1000" value="0" required>
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
    <div id="editCategoryModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="update_form">
                    <div class="modal-header">                      
                        <h4 class="modal-title">Edit Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_u" name="id" class="form-control" required>                 
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" id="category_u" name="category" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Order Number</label>
                            <input type="number" id="order_u" name="order" class="form-control" min="0" max="1000" value="0" required>
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
    <div id="deleteCategoryModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">                      
                        <h4 class="modal-title">Delete Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_d" name="id" class="form-control">                  
                        <p>Are you sure you want to delete this category?</p>
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
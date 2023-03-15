<?php
function city_manage(){
?>
    <script>
        var ajaxUrl = '<?php echo esc_url(home_url('/wp-admin/admin-ajax.php')); ?>';
    </script>
    <p id="success"></p>
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Manage <b>City</b></h2>
                </div>
                <div class="col-sm-6">
                    <a href="#addCityModal" class="btn btn-success" data-toggle="modal"><i class="material-icons"></i> <span>Add City</span></a>
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
                    <th>City</th>
                    <th>Currency Unit</th>
					<th>ACTION</th>
                </tr>
            </thead>
            <tbody>
            <?php
            global $wpdb;
            $result = $wpdb->get_results("SELECT * FROM wp_stylebible_cities");
            $i=1;
            foreach ($result as $print)   
            {
            ?>
            <tr>
                <td>
                    <span class="custom-checkbox">
                        <input type="checkbox" class="user_checkbox" data-user-id="<?php echo $print->city_id; ?>">
                        <label for="checkbox2"></label>
                    </span>
                </td>
                <td><?php echo $i; ?></td>
                <td><?php echo $print->city_name; ?></td>
				<td><?php echo $print->currency_unit; ?></td>
                <td>
                    <a href="#editCityModal" class="edit" data-toggle="modal">
                        <i class="material-icons update" data-toggle="tooltip"
                        data-id="<?php echo $print->city_id;?>" 
                        data-name="<?php echo $print->city_name;?>"
						data-currency="<?php echo $print->currency_unit;?>"
                        title="Edit"></i>
                    </a>
                    <a href="#deleteCityModal" class="delete" data-id="<?php echo $print->city_id; ?>" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" 
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
    <div id="addCityModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="user_form">
                    <div class="modal-header">                      
                        <h4 class="modal-title">Add City</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">                    
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" id="city" name="city" class="form-control" required>
                        </div>
						<div class="form-group">
                            <label>Currency Unit</label>
                            <input type="text" id="currency" name="currency" class="form-control" required>
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
    <div id="editCityModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="update_form">
                    <div class="modal-header">                      
                        <h4 class="modal-title">Edit City</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_u" name="id" class="form-control" required>                 
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" id="city_u" name="city" class="form-control" required>
                        </div>
						<div class="form-group">
                            <label>Currency Unit</label>
                            <input type="text" id="currency_u" name="currency" class="form-control" required>
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
    <div id="deleteCityModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">                      
                        <h4 class="modal-title">Delete City</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_d" name="id" class="form-control">                  
                        <p>Are you sure you want to delete this city?</p>
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
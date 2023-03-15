<?php

function establishment_manage(){
?>
    <script>
        var ajaxUrl = '<?php echo esc_url(home_url('/wp-admin/admin-ajax.php')); ?>';
    </script>
    <p id="success"></p>
    <div class="table-wrapper-est">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Manage <b>Establishment</b></h2>
                </div>
                <div class="col-sm-6">
                    <a href="#addEstablishmentModal" class="btn btn-success" data-toggle="modal"><i class="material-icons"></i> <span>Add Establishment</span></a>
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
                    <th>Establishment Name</th>
                    <th>Area</th>
                    <th>Address</th>
                    <th>Website Url</th>
                    <th>Instagram Url</th>
                    <th>Tiktok</th> 
                    <th>Why we love it</th>
                    <th>Price</th>
                    <th>Is deleted</th>
                    <th>Author</th>
                    <th>Create at</th>
                    <th>Rating</th>
                    <th>Hidden gem</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
            <?php
            global $wpdb;
            $result=$wpdb->get_results("SELECT
                    wp_stylebible_establishments.*,
                    wp_stylebible_cities.city_id,
                    wp_stylebible_categories.category_id,
                    wp_stylebible_sub_categories.sub_cat_id 
            FROM
                    ( SELECT establishment_id, city_id, cat_id, sub_cat_id FROM wp_stylebible_match_list GROUP BY establishment_id ) match_list,
                    wp_stylebible_establishments,
                    wp_stylebible_cities,
                    wp_stylebible_categories,
                    wp_stylebible_sub_categories 
            WHERE
                    match_list.establishment_id = wp_stylebible_establishments.establishment_id 
                    AND match_list.city_id = wp_stylebible_cities.city_id 
                    AND match_list.cat_id = wp_stylebible_categories.category_id 
                    AND match_list.sub_cat_id = wp_stylebible_sub_categories.sub_cat_id 
                    -- AND wp_stylebible_establishments.is_deleted = 'n' 
            ORDER BY
                    establishment_id");
            $i=1;
            foreach ($result as $print)   
            {
            ?>
            <tr>
                <td>
                    <span class="custom-checkbox">
                        <input type="checkbox" class="user_checkbox" data-user-id="<?php echo $print->establishment_id; ?>">
                        <label for="checkbox2"></label>
                    </span>
                </td>
                <td><?php echo $i; ?></td>
                <td><?php echo $print->establishment_name; ?></td>
                <td><?php echo $print->area; ?></td>
                <td><?php echo $print->address; ?></td>
                <td><?php echo $print->website_url; ?></td>
                <td><?php echo $print->instagram_url; ?></td>
                <td><?php echo $print->tiktok; ?></td>
                <td><?php echo $print->why_we_love_it; ?></td>
                <td><?php echo $print->price; ?></td>
                <td><?php echo $print->is_deleted; ?></td>
                <td><?php echo $print->author; ?></td>
                <td><?php echo $print->create_at; ?></td>
                <td><?php echo $print->rating; ?></td>
                <td><?php echo $print->hidden_gem; ?></td>
                <td>
                    <a href="#editEstablishmentModal" class="edit" data-toggle="modal">
                        <i class="material-icons update" data-toggle="tooltip"
                        data-id="<?php echo $print->establishment_id;?>" 
                        data-name="<?php echo $print->establishment_name;?>"
                        data-area="<?php echo $print->area;?>"
                        data-address="<?php echo $print->address;?>"
                        data-website-url="<?php echo $print->website_url;?>"
                        data-instagram-url="<?php echo $print->instagram_url;?>"
                        data-tiktok="<?php echo $print->tiktok;?>"
                        data-love="<?php echo $print->why_we_love_it;?>"
                        data-price="<?php echo $print->price;?>"
                        data-deleted="<?php echo $print->is_deleted;?>"
                        data-author="<?php echo $print->author;?>"
                        data-rating="<?php echo $print->rating;?>"
                        data-hidden-gem="<?php echo $print->hidden_gem;?>"
                        data-city-id="<?php echo $print->city_id;?>"
                        data-category-id="<?php echo $print->category_id;?>"
                        data-sub-category-id="<?php echo $print->sub_cat_id;?>"
                        title="Edit"></i>
                    </a>
                    <a href="#deleteEstablishmentModal" class="delete" data-id="<?php echo $print->establishment_id; ?>" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" 
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
    <div id="addEstablishmentModal" class="modal fade">
        <div class="modal-dialog modal-est">
            <div class="modal-content">
                <form id="user_form">
                    <div class="modal-header">                      
                        <h4 class="modal-title">Add Establishment</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="flex">
                            <div class="form-group margin-right-15">
                                <label>Establishment</label>
                                <input type="text" id="establishment" name="establishment" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Area</label>
                                <input type="text" id="area" name="area" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" id="address" name="address" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Website Url</label>
                            <input type="url" id="website_url" name="website_url" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Instagram Url</label>
                            <input type="url" id="instagram_url" name="instagram_url" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tiktok</label>
                            <input type="url" id="tiktok" name="tiktok" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Why we love it</label>
                            <textarea id="love" name="love" class="form-control" rows="4" cols="50" required></textarea>
                        </div>       
                        <div class="flex">
                            <div class="form-group price margin-right-15">
                                <label>Price</label>
                                <input type="text" id="price" name="price" class="form-control" required>
                            </div>
                            <div class="form-group author margin-right-15">
                                <label>Author</label>
                                <input type="text" id="author" name="author" class="form-control" required>
                            </div>
                            <div class="form-group rating margin-right-15">
                                <label>Rating</label>
                                <input type="number" id="rating" name="rating" class="form-control" min="0" max="1000" value="0" required>
                            </div>
                            <div class="form-group margin-right-15">
                                <label>Is deleted</label><br>
                                <select id="is_deleted" name="is_deleted">
                                    <option value="y">YES</option>
                                    <option value="n">NO</option>    
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Hidden gem</label><br>
                                <select id="hidden_gem" name="hidden_gem">
                                    <option value="1">YES</option>
                                    <option value="0">NO</option>    
                                </select>
                            </div>    
                        </div>
                        <div class="flex">
                            <div class="form-group margin-right-15">
                                <label>City</label><br>
                                <select id="city_id" name="city_id">
                                <?php
                                    global $wpdb;
                                    $result = $wpdb->get_results("SELECT * FROM wp_stylebible_cities"); 
                                    echo $result;    
                                    foreach ($result as $print)   
                                    {?>
                                        <option value="<?php echo $print->city_id; ?>"><?php echo $print->city_name; ?></option>    
                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                            <div class="form-group margin-right-15">
                                <label>Category</label><br>
                                <select id="category_id" name="category_id">
                                <?php
                                    global $wpdb;
                                    $result = $wpdb->get_results("SELECT * FROM wp_stylebible_categories"); 
                                    echo $result;    
                                    foreach ($result as $print)   
                                    {?>
                                        <option value="<?php echo $print->category_id; ?>"><?php echo $print->category_name; ?></option>    
                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Sub Category</label><br>
                                <select id="sub_category_id" name="sub_category_id">
                                <?php
                                    global $wpdb;
                                    $result = $wpdb->get_results("SELECT * FROM wp_stylebible_sub_categories"); 
                                    echo $result;    
                                    foreach ($result as $print)   
                                    {?>
                                        <option value="<?php echo $print->sub_cat_id; ?>"><?php echo $print->sub_cat_name; ?></option>    
                                <?php
                                    }
                                ?>
                                </select>
                            </div>
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
    <div id="editEstablishmentModal" class="modal fade">
        <div class="modal-dialog modal-est">
            <div class="modal-content">
                <form id="update_form">
                    <div class="modal-header">                      
                        <h4 class="modal-title">Edit Establishment</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_u" name="id" class="form-control" required>                 
                        <div class="flex">
                            <div class="form-group margin-right-15">
                                <label>Establishment</label>
                                <input type="text" id="establishment_u" name="establishment" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Area</label>
                                <input type="text" id="area_u" name="area" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" id="address_u" name="address" class="form-control" required>
                        </div>    
                        <div class="form-group">
                            <label>Website Url</label>
                            <input type="url" id="website_url_u" name="website_url" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Instagram Url</label>
                            <input type="url" id="instagram_url_u" name="instagram_url" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tiktok</label>
                            <input type="url" id="tiktok_u" name="tiktok" class="form-control" required>
                        </div>                            
                        <div class="form-group">
                            <label>Why we love it</label>
                            <textarea id="love_u" name="love" class="form-control" rows="4" cols="50" required></textarea>
                        </div>
                        <div class="flex">
                            <div class="form-group price margin-right-15">
                                <label>Price</label>
                                <input type="text" id="price_u" name="price" class="form-control" required>
                            </div>
                            <div class="form-group author margin-right-15">
                                <label>Author</label>
                                <input type="text" id="author_u" name="author" class="form-control" required>
                            </div>
                            <div class="form-group rating margin-right-15">
                                <label>Rating</label>
                                <input type="number" id="rating_u" name="rating" class="form-control" min="0" max="1000" required>
                            </div>
                            <div class="form-group margin-right-15">
                                <label>Is deleted</label><br>
                                <select id="is_deleted_u" name="is_deleted">
                                    <option value="y">YES</option>
                                    <option value="n">NO</option>    
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Hidden gem</label><br>
                                <select id="hidden_gem_u" name="hidden_gem">
                                    <option value="1">YES</option>
                                    <option value="0">NO</option>    
                                </select>
                            </div>    
                        </div>
                        <div class="flex">
                            <div class="form-group margin-right-15">
                                <label>City</label><br>
                                <select id="city_id_u" name="city_id">
                                <?php
                                    global $wpdb;
                                    $result = $wpdb->get_results("SELECT * FROM wp_stylebible_cities"); 
                                    echo $result;    
                                    foreach ($result as $print)   
                                    {?>
                                        <option value="<?php echo $print->city_id; ?>"><?php echo $print->city_name; ?></option>    
                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                            <div class="form-group margin-right-15">
                                <label>Category</label><br>
                                <select id="category_id_u" name="category_id">
                                <?php
                                    global $wpdb;
                                    $result = $wpdb->get_results("SELECT * FROM wp_stylebible_categories"); 
                                    echo $result;    
                                    foreach ($result as $print)   
                                    {?>
                                        <option value="<?php echo $print->category_id; ?>"><?php echo $print->category_name; ?></option>    
                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Sub Category</label><br>
                                <select id="sub_category_id_u" name="sub_category_id">
                                <?php
                                    global $wpdb;
                                    $result = $wpdb->get_results("SELECT * FROM wp_stylebible_sub_categories"); 
                                    echo $result;    
                                    foreach ($result as $print)   
                                    {?>
                                        <option value="<?php echo $print->sub_cat_id; ?>"><?php echo $print->sub_cat_name; ?></option>    
                                <?php
                                    }
                                ?>
                                </select>
                            </div>
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
    <div id="deleteEstablishmentModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">                      
                        <h4 class="modal-title">Delete Establishment</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_d" name="id" class="form-control">                  
                        <p>Are you sure you want to delete this establishment?</p>
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
}?>
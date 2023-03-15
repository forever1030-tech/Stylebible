<?php
function my_enqueue_sub_category($hook) {
	if( $hook == "stylebible_page_sub_category_plugin" ) {
	    wp_enqueue_script('my_custom_ajax_sub_category', plugin_dir_url(__FILE__) . '../ajax/ajax_sub_category.js');
    }
}
add_action('admin_enqueue_scripts', 'my_enqueue_sub_category');

add_action( 'wp_ajax_crud_sub_category',       	'crud_sub_category' );
add_action( 'wp_ajax_nopriv_crud_sub_category',	'crud_sub_category' );

function crud_sub_category() {
	global $wpdb;
	switch ($_POST['type']) {
		case 1:
			$sub_category = $_POST['sub_category'];
			$result = $wpdb->insert( 'wp_stylebible_sub_categories', [ 'sub_cat_name' => $sub_category ]);
			echo json_encode(['result' => $result]);
			break;
		case 2:
			$id = $_POST['id'];
			$sub_category = $_POST['sub_category'];
			$result = $wpdb -> update('wp_stylebible_sub_categories', ['sub_cat_name' => $sub_category], ['sub_cat_id' => $id]);
			echo json_encode(['result' => $result]);
			break;
		case 3:
			$id=$_POST['id'];
			$result=$wpdb->delete('wp_stylebible_sub_categories', ['sub_cat_id' => $id]);
			echo $id;
			break;
		case 4:
			$id=$_POST['id'];
			$wpdb->query("DELETE FROM wp_stylebible_sub_categories WHERE sub_cat_id IN($id)");
			echo $id;
			break;
		default:
			break;
	}
	wp_die();
}


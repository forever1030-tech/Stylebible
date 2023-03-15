<?php
function my_enqueue_category($hook) {
	if( $hook == "stylebible_page_category_plugin" ) {
    	wp_enqueue_script('my_custom_ajax_category', plugin_dir_url(__FILE__) . '../ajax/ajax_category.js');
    }
}
add_action('admin_enqueue_scripts', 'my_enqueue_category');

add_action( 'wp_ajax_crud_category',       	'crud_category' );
add_action( 'wp_ajax_nopriv_crud_category',	'crud_category' );

function crud_category() {
	global $wpdb;
	switch ($_POST['type']) {
		case 1:
			$category = $_POST['category'];
			$order = $_POST['order'];
			$result = $wpdb->insert( 'wp_stylebible_categories', [ 'category_name' => $category, 'order_number' => $order ]);
			echo json_encode(['result' => $result]);
			break;
		case 2:
			$id = $_POST['id'];
			$category = $_POST['category'];
			$order = $_POST['order'];
			$result = $wpdb -> update('wp_stylebible_categories', ['category_name' => $category, 'order_number' => $order], ['category_id' => $id]);
			echo json_encode(['result' => $result]);
			break;
		case 3:
			$id=$_POST['id'];
			$result=$wpdb->delete('wp_stylebible_categories', ['category_id' => $id]);
			echo $id;
			break;
		case 4:
			$id=$_POST['id'];
			$wpdb->query("DELETE FROM wp_stylebible_categories WHERE category_id IN($id)");
			echo $id;
			break;
		default:
			break;
	}
	wp_die();
}
?>
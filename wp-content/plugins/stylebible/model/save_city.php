<?php
function my_enqueue_city($hook) {
	if( $hook == "toplevel_page_stylebible_plugin" ) {
	    wp_enqueue_script('my_custom_ajax_city', plugin_dir_url(__FILE__) . '../ajax/ajax_city.js');
    }
}
add_action('admin_enqueue_scripts', 'my_enqueue_city');

add_action( 'wp_ajax_crud_city',       	'crud_city' );
add_action( 'wp_ajax_nopriv_crud_city',	'crud_city' );

function crud_city() {
	global $wpdb;
	switch ($_POST['type']) {
		case 1:
			$city = $_POST['city'];
			$currency = $_POST['currency'];
			$result = $wpdb->insert( 'wp_stylebible_cities', [ 'city_name' => $city, 'currency_unit' => $currency]);
			echo json_encode(['result' => $result]);
			break;
		case 2:
			$id = $_POST['id'];
			$city = $_POST['city'];
			$currency = $_POST['currency'];
			$result = $wpdb -> update('wp_stylebible_cities', ['city_name' => $city, 'currency_unit' => $currency], ['city_id' => $id]);
			echo json_encode(['result' => $result]);
			break;
		case 3:
			$id=$_POST['id'];
			$result=$wpdb->delete('wp_stylebible_cities', ['city_id' => $id]);
			echo $id;
			break;
		case 4:
			$id=$_POST['id'];
			$wpdb->query("DELETE FROM wp_stylebible_cities WHERE city_id IN($id)");
			echo $id;
			break;
		default:
			break;
	}
	wp_die();
}


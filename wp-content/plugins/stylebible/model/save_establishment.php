<?php
function my_enqueue_establishment($hook) {
	if( $hook == "stylebible_page_establishment_plugin" ) {
	    wp_enqueue_script('my_custom_ajax_establishment', plugin_dir_url(__FILE__) . '../ajax/ajax_establishment.js');
    }
}
add_action('admin_enqueue_scripts', 'my_enqueue_establishment');

add_action( 'wp_ajax_crud_establishment',       	'crud_establishment' );
add_action( 'wp_ajax_nopriv_crud_establishment',	'crud_establishment' );

function crud_establishment() {
	global $wpdb;
	switch ($_POST['type']) {
		case 1:
			$establishment = $_POST['establishment'];
			$area = $_POST['area'];
			$address = $_POST['address'];
			$website_url = $_POST['website_url'];
			$instagram_url = $_POST['instagram_url'];
			$tiktok = $_POST['tiktok'];
			$love = $_POST['love'];
			$price = $_POST['price'];
			$is_deleted = $_POST['is_deleted'];
			$author = $_POST['author'];
			$rating = $_POST['rating'];
			$hidden_gem = $_POST['hidden_gem'];
			$city_id = $_POST['city_id'];
			$category_id = $_POST['category_id'];
			$sub_category_id = $_POST['sub_category_id'];
			$result = $wpdb->insert( 'wp_stylebible_establishments', [ 'establishment_name' => $establishment, 'area' => $area, 'address' => $address, 'website_url' => $website_url, 'instagram_url' => $instagram_url, 'tiktok' => $tiktok, 'why_we_love_it' => $love, 'price' => $price, 'is_deleted' => $is_deleted, 'author' => $author, 'create_at' => current_time('mysql'),	 'rating' => $rating, 'hidden_gem' => $hidden_gem]);
			$establishment_id=$wpdb->insert_id;
			$wpdb->insert('wp_stylebible_match_list', ['establishment_id' => $establishment_id, 'city_id' => $city_id, 'cat_id' => $category_id, 'sub_cat_id' => $sub_category_id]);
			echo json_encode(['result' => $result]);
			break;
		case 2:
			$id = $_POST['id'];
			$establishment = $_POST['establishment'];
			$area = $_POST['area'];
			$address = $_POST['address'];
			$website_url = $_POST['website_url'];
			$instagram_url = $_POST['instagram_url'];
			$tiktok = $_POST['tiktok'];
			$love = $_POST['love'];
			$price = $_POST['price'];
			$is_deleted = $_POST['is_deleted'];
			$author = $_POST['author'];
			$rating = $_POST['rating'];
			$hidden_gem = $_POST['hidden_gem'];
			$city_id = $_POST['city_id'];
			$category_id = $_POST['category_id'];
			$sub_category_id = $_POST['sub_category_id'];
			$result = $wpdb->update('wp_stylebible_establishments', ['establishment_name' => $establishment, 'area' => $area, 'address' => $address, 'website_url' => $website_url, 'instagram_url' => $instagram_url, 'tiktok' => $tiktok, 'why_we_love_it' => $love, 'price' => $price, 'is_deleted' => $is_deleted, 'author' => $author, 'rating' => $rating, 'hidden_gem' => $hidden_gem], ['establishment_id' => $id]);
			$wpdb->update('wp_stylebible_match_list', ['city_id' => $city_id, 'cat_id' => $category_id, 'sub_cat_id' => $sub_category_id], ['establishment_id' => $id]);
			echo json_encode(['result' => $result]);
			break;
		case 3:
			$id=$_POST['id'];
			$wpdb->delete('wp_stylebible_establishments', ['establishment_id' => $id]);
			$wpdb->delete('wp_stylebible_match_list', ['establishment_id' => $id]);
			echo $id;
			break;
		case 4:
			$id=$_POST['id'];
			$wpdb->query("DELETE FROM wp_stylebible_establishments WHERE establishment_id IN($id)");
			$wpdb->query("DELETE FROM wp_stylebible_match_list WHERE establishment_id IN($id)");
			echo $id;
			break;
		default:
			break;
	}
	wp_die();
}


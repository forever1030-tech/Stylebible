<?php
function my_enqueue_excel($hook) {
	if( $hook == "stylebible_page_excel_plugin" ) {
		wp_enqueue_script('bootstrap-file-style', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-filestyle/2.1.0/bootstrap-filestyle.min.js');
        wp_enqueue_script('my_custom_excel_import_js', plugin_dir_url(__FILE__) . '../assets/js/excel.js');
    }
}

add_action('admin_enqueue_scripts', 'my_enqueue_excel');

add_action( 'wp_ajax_import_excel',       	'import_excel' );
add_action( 'wp_ajax_nopriv_import_excel',	'import_excel' );

function import_excel() {
	global $wpdb;
	$excelData = $_POST['excelJsonData'];

	$cities			=	$wpdb->get_results('SELECT * FROM wp_stylebible_cities', ARRAY_A);
	$categories 	=	$wpdb->get_results('SELECT * FROM wp_stylebible_categories', ARRAY_A);
	$sub_categories	=	$wpdb->get_results('SELECT * FROM wp_stylebible_sub_categories', ARRAY_A);

	@set_time_limit(0);
	foreach( $excelData as $data ) {
		$establishment_id = store_establishment( $data );
		
		$category_array = explode('and', $data['category']);
		
		foreach( $category_array as $category ) {
			matching_ids([
				'establishment_id'	=>	$establishment_id,
				'city_id'			=>	get_id_by( 'city',		$data['city'],			$cities			),
				'cat_id'			=>	get_id_by( 'category',	trim($category),		$categories		),
				'sub_cat_id'		=>	get_id_by( 'sub_cat',	$data['sub_category'],	$sub_categories	),
			]);
		}
	}

	echo json_encode([ 'result' => true ]);

	wp_die();
}

function store_establishment( $info ) {
	global $wpdb;

	$establishment_id = $wpdb->get_var( 'SELECT establishment_id from wp_stylebible_establishments where establishment_name = \'' . $info['establishment_name'] . '\'' );
	if( !empty( $establishment_id ) ) return $establishment_id;

	$insert_data = [
		'establishment_name'	=>	(string)$info['establishment_name'],
		'area'					=>  (string)$info['area'],
		'address'				=>  (string)$info['address'],
		'website_url'			=>	(string)$info['website_url'],
		'instagram_url'			=>	(string)$info['instagram_url'],
		'tiktok'				=>	(string)$info['tiktok'],
		'why_we_love_it'		=>	(string)$info['why_we_love_it'],
		'price'					=>	$info['price'],
		'is_deleted'			=>	'n',
		'author'				=>	(string)$info['author'],
		'create_at'				=>	current_time('mysql'),
		'rating'				=>	0,
		'hidden_gem'			=>	$info['hidden_gem'] == "YES" ? 1 : 0
	];
	$wpdb->insert('wp_stylebible_establishments', $insert_data);

	return $wpdb->insert_id;
}

function matching_ids( $matching_info ) {
	global $wpdb;

	$match_id = $wpdb->get_var('SELECT
									match_id
								from
									wp_stylebible_match_list
								where
									establishment_id = ' . $matching_info['establishment_id'] . '
									and cat_id = ' . $matching_info['cat_id'] . '
									and sub_cat_id = ' . $matching_info['sub_cat_id']
								);

	if( !empty( $match_id ) ) return $match_id;

	$wpdb->insert( 'wp_stylebible_match_list', $matching_info );

	return $wpdb->insert_id;
}

function get_id_by( $key, $name, $info_by_key ) {
	$id = 0;

	foreach( $info_by_key as $row ) {
		if( strtolower($row[$key . '_name']) === strtolower($name) ) {
			$id = $row[$key . '_id'];
			break;
		}
	}
	return $id;
}
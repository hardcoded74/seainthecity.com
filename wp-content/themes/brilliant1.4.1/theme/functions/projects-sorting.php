<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Projects Sorting
 * Created by CMSMasters
 * 
 */


function cmsmasters_enable_projects_sort() {
	add_submenu_page('edit.php?post_type=portfolio', __('Sort Projects', 'cmsmasters'), __('Sort Projects', 'cmsmasters'), 'edit_posts', basename(__FILE__), 'cmsmasters_sort_projects');
}

add_action('admin_menu' , 'cmsmasters_enable_projects_sort'); 


function cmsmasters_sort_projects() {
	$projects = new WP_Query('post_type=portfolio&posts_per_page=-1&orderby=menu_order&order=ASC');
	?>
	<div class="wrap">
		<h2><?php _e('Sort Projects', 'cmsmasters'); ?> <img src="<?php echo home_url(); ?>/wp-admin/images/wpspin_light.gif" id="loading-animation" /></h2>
		<ul id="projects-list">
		<?php while ($projects->have_posts()) : $projects->the_post(); ?>
			<li id="<?php the_id(); ?>">
				<table>
					<tr>
						<td><?php the_title(); ?></td>
						<td>
							<span><?php 
							if (has_post_thumbnail()) {
								echo get_the_post_thumbnail(get_the_ID(), 'thumbnail', array( 
									'alt' => cmsms_title(get_the_ID(), false), 
									'title' => cmsms_title(get_the_ID(), false), 
									'style' => 'width:50px; height:50px;' 
								));
							}
							?></span>
						</td>
					</tr>
				</table>
			</li>
		<?php endwhile; ?>
		</ul>
	</div>
	<?php
}

function cmsmasters_projects_print_scripts() {
	global $pagenow;
	
	if (in_array($pagenow, array('edit.php')) && isset($_GET['post_type']) && $_GET['post_type'] == 'portfolio') {
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('cmsmasters_projects', get_template_directory_uri() . '/theme/administrator/js/sorting.js');
	}
}

add_action('admin_print_scripts', 'cmsmasters_projects_print_scripts');


function cmsmasters_projects_print_styles() {
	global $pagenow;
	
	if (in_array($pagenow, array('edit.php')) && isset($_GET['post_type']) && $_GET['post_type'] == 'portfolio') {
		wp_enqueue_style('cmsmasters_projects', get_template_directory_uri() . '/theme/administrator/css/sorting.css');
	}
}

add_action('admin_print_styles', 'cmsmasters_projects_print_styles');


function cmsmasters_save_projects_order() {
	global $wpdb;
	
	$order = explode(',', $_POST['order']);
	$counter = 0;
	
	foreach ($order as $projects_id) {
		$wpdb->update($wpdb->posts, array('menu_order' => $counter), array('ID' => $projects_id));
		
		$counter++;
	}
	
	die(1);
}

add_action('wp_ajax_projects_sort', 'cmsmasters_save_projects_order');

?>
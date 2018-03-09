<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Portfolio Post Type
 * Created by CMSMasters
 * 
 */


class Portfolio {
    private $meta_fields = array('pt_images', 'pt_format');
    
    function Portfolio() { 
        $portfolio_labels = array( 
            'menu_name' => __('Portfolio', 'cmsmasters'), 
            'parent_item_colon' => __('Portfolio', 'cmsmasters'), 
            'name' => __('Portfolio Projects', 'cmsmasters'), 
            'all_items' => __('All Projects', 'cmsmasters'), 
            'singular_name' => __('Project', 'cmsmasters'), 
            'add_new' => __('Add New Project', 'cmsmasters'), 
            'add_new_item' => __('Add New Project', 'cmsmasters'), 
            'edit_item' => __('Edit Project', 'cmsmasters'), 
            'new_item' => __('New Project', 'cmsmasters'), 
            'view_item' => __('View Project', 'cmsmasters'), 
            'search_items' => __('Search Projects', 'cmsmasters'), 
            'not_found' => __('No Projects found', 'cmsmasters'), 
            'not_found_in_trash' => __('No Projects found in Trash', 'cmsmasters') 
        );
        
        $portfolio_args = array( 
            'labels' => $portfolio_labels, 
            'public' => true, 
			'has_archive' => true, 
            'show_ui' => true, 
            '_builtin' => false, 
            '_edit_link' => 'post.php?post=%d', 
            'capability_type' => 'post', 
            'hierarchical' => false, 
            'rewrite' => array( 
				'slug' => 'portfolio', 
				'with_front' => true 
			), 
            'query_var' => 'portfolio', 
            'menu_position' => 51, 
            'supports' => array( 
				'title', 
				'editor', 
				'excerpt', 
				'thumbnail', 
				'author', 
				'comments', 
				'revisions', 
				'trackbacks', 
				'page-attributes', 
				'custom-fields' 
			) 
       );
        
        register_post_type('portfolio', $portfolio_args);
        
        add_filter('manage_edit-portfolio_columns', array(&$this, 'edit_columns'));
        add_filter('manage_edit-portfolio_sortable_columns', array(&$this, 'edit_sortable_columns'));
        
        add_action('admin_init', array(&$this, 'admin_init'));
        
        register_taxonomy('pt-sort-categ', array('portfolio'), array(
			'hierarchical' => true, 
			'label' => __('Project Categories', 'cmsmasters'), 
			'singular_label' => __('Project Category', 'cmsmasters'), 
			'rewrite' => array( 
				'slug' => 'pt-sort-categ', 
				'with_front' => true 
			) 
		));
		
        register_taxonomy('pt-tags', array('portfolio'), array(
			'hierarchical' => false, 
			'label' => __('Project Tags', 'cmsmasters'), 
			'singular_label' => __('Project Tag', 'cmsmasters'), 
			'rewrite' => array( 
				'slug' => 'pt-tags', 
				'with_front' => true 
			) 
		));
		
        register_taxonomy('pt-categ', array('portfolio'), array(
			'hierarchical' => true, 
			'label' => __('Portfolio Types', 'cmsmasters'), 
			'singular_label' => __('Portfolio Type', 'cmsmasters'), 
			'rewrite' => array( 
				'slug' => 'pt-categ', 
				'with_front' => true 
			) 
		));
        
        flush_rewrite_rules(false);
        
        add_action('manage_posts_custom_column', array(&$this, 'custom_columns'));
        add_action('template_redirect', array(&$this, 'template_redirect'));
        add_action('wp_insert_post', array(&$this, 'wp_insert_post'), 10, 2);
    }
    
    function edit_columns($columns) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Project Title', 'cmsmasters'),
            'pt_thumb' => __('Project Thumbnail', 'cmsmasters'),
            'pt_format' => __('Format', 'cmsmasters'),
            'pt_description' => __('Project Description', 'cmsmasters'),
            'pt_sort_categ' => __('Projects Categories', 'cmsmasters'),
            'pt_tags' => __('Projects Tags', 'cmsmasters'),
            'pt_order' => __('Order Number', 'cmsmasters')
        );
        
        return $columns;
    }
    
    function template_redirect() {
        global $wp;
        
        if (isset($wp->query_vars['post_type']) && $wp->query_vars['post_type'] == 'portfolio') {
            include(TEMPLATEPATH . '/theme/pages/project.php');
            
            die();
        }
    }
    
    function custom_columns($column) {
        switch ($column) {
            case 'pt_thumb':
                if (has_post_thumbnail() != '') {
					echo get_the_post_thumbnail(get_the_ID(), 'thumbnail', array( 
						'alt' => cmsms_title(get_the_ID(), false), 
						'title' => cmsms_title(get_the_ID(), false), 
						'style' => 'width:75px; height:75px;' 
					));
                } else {
                    echo '<em>' . __('It is no thumbnail', 'cmsmasters') . '</em>';
                }
                break;
            case 'pt_format':
                if (get_post_meta(get_the_ID(), 'pt_format', true) != '') {
                    echo '<em>' . ucfirst(get_post_meta(get_the_ID(), 'pt_format', true)) . '</em>';
                } else {
                    echo '<em>' . __('Album', 'cmsmasters') . '</em>';
                }
                break;
            case 'pt_description':
                if (has_excerpt() || get_the_content() != '') {
                    theme_excerpt(20);
                } else {
                    echo '<em>' . __('It is no description', 'cmsmasters') . '</em>';
                }
                break;
            case 'pt_sort_categ':
                if (get_the_terms(0, 'pt-sort-categ') != '') {
                    $pt_sort_categs = get_the_terms(0, 'pt-sort-categ');
                    $pt_sort_categs_html = array();
                    
                    foreach ($pt_sort_categs as $pt_sort_categ) {
                        array_push($pt_sort_categs_html, '<a href="' . get_term_link($pt_sort_categ->slug, 'pt-sort-categ') . '">' . $pt_sort_categ->name . '</a>');
                    }
                    
                    echo implode($pt_sort_categs_html, ', ');
                } else {
                    echo '<em>' . __('It is no categories', 'cmsmasters') . '</em>';
                }
                break;
            case 'pt_tags':
                if (get_the_terms(0, 'pt-tags') != '') {
                    $pt_tags = get_the_terms(0, 'pt-tags');
                    $pt_tag_html = array();
                    
                    foreach ($pt_tags as $pt_tag) {
                        array_push($pt_tag_html, '<a href="' . get_term_link($pt_tag->slug, 'pt-tags') . '">' . $pt_tag->name . '</a>');
                    }
                    
                    echo implode($pt_tag_html, ', ');
                } else {
                    echo '<em>' . __('It is no tags', 'cmsmasters') . '</em>';
                }
                break;
            case 'pt_order':
                $custom_post = get_post(get_the_ID());
                $custom = $custom_post->menu_order;
                
                echo $custom;
                break;
        }
    }
    
    function edit_sortable_columns($columns) {
        $columns['pt_order'] = 'pt_order';
        
        return $columns;
    }
    
    function wp_insert_post($post_id, $post = null) {
        if ($post->post_type == 'portfolio') {
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
				return;
			}
			
            if (!current_user_can('edit_post', $post_id)) {
                return;
			}
			
            foreach ($this->meta_fields as $key) {
                $value = @$_POST[$key];
				$custom = get_post_custom($post_id);
				
				if (is_array($value)) {
					delete_post_meta($post_id, $key);
                    
                    foreach ($value as $entry) {
						add_post_meta($post_id, $key, $entry);
					}
					
					continue;
				}
				
				if (array_key_exists($key, $custom)) {
					update_post_meta($post_id, $key, $value);
				} else {
					add_post_meta($post_id, $key, $value);
				}
            }
        }
    }
    
    function admin_init() {
        add_meta_box('pt_format', __('Format', 'cmsmasters'), array(&$this, 'meta_format'), 'portfolio', 'side', 'high');
        add_meta_box('pt_images', __('Attached Images', 'cmsmasters'), array(&$this, 'meta_images'), 'portfolio', 'side', 'low');
    }
    
    function meta_format() {
        global $post;
        
        $meta_value = get_post_meta($post->ID, 'pt_format', true);
        
        if ($meta_value != '') {
            $selected = $meta_value;
        } else {
            $selected = 'album';
        }
        
        $project_format = array(
            'album' => __('Album', 'cmsmasters'), 
            'slider' => __('Slider', 'cmsmasters'), 
            'video' => __('Video', 'cmsmasters') 
        );
        
        echo '<div id="project-formats-select">';
        
        foreach ($project_format as $key => $value) {
            echo '<input type="radio" value="' . $key . '" id="project-format-' . $key . '" class="project-format" name="pt_format"';
            
            if ($selected == $key) {
                echo ' checked="checked"';
            }
            
            echo '> ' . 
            '<label for="project-format-' . $key . '">' . $value . '</label>' . 
            '<br />';
        }
        
        echo '</div>';
    }
    
    function meta_images() {
        global $post;
        
        $custom = get_post_custom($post->ID);
        $imgs = $custom['pt_images'][0];
        
        function get_attachments($postID, $type, $theone) {
            $args = array(
                'post_type' => 'attachment',
                'numberposts' => -1,
                'post_status' => null,
                'post_parent' => $postID,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            );
            
            $attachments = get_posts($args);
            
            if ($attachments) {
                $ci = 0;
                
                echo '<img src="' . get_site_url() . '/wp-admin/images/wpspin_light.gif" id="loading-animation" style="float:right; display:none;" alt="" />' . 
                '<p>' . __('Project Images', 'cmsmasters') . ':</p>' . 
                '<ul id="folio_imgs" style="padding:0 0 0 5px">';
                
                foreach ($attachments as $attachment) {
                    $image = wp_get_attachment_image_src($attachment->ID, 'thumbnail');
                    
                    echo '<li style="float:left; display:block; margin:0 5px 5px 0;" id="' . $attachment->ID . '">' . 
						'<a class="thickbox" title="' . __('Add an Image', 'cmsmasters') . '" href="media-upload.php?post_id=' . $postID . '&type=image&TB_iframe=1&width=640&height=525" style="display:block; width:57px; height:57px; cursor:move;">' . 
							'<img style="border:1px solid #dfdfdf; dispalay:block;" src="' . $image[0] . '" height="55" width="55" alt="" />' . 
						'</a>' . 
					'</li>';
                    
                    $ci++;
                }
                
                echo '</ul>' . 
				'<input type="hidden" name="' . $type . '" value="' . $ci . '" />' . 
				'<div style="clear:both;"></div>' . 
                '<p>' . __('Choose images and close the window', 'cmsmasters') . '.<br />' . __('Your images were added', 'cmsmasters') . '.<br /><br /><em>' . __('Note', 'cmsmasters') . ': ' . __('thumbnails will appear only after page reloading', 'cmsmasters') . '.</em></p>';
            } else {
                echo '<p><em><a class="thickbox" title="' . __('Add an Image', 'cmsmasters') . '" href="media-upload.php?post_id=' . $postID . '&type=image&TB_iframe=1&width=640&height=525">' . __('Please upload images', 'cmsmasters') . '</a></em></p>' . 
                '<p>' . __('Choose images and close the window', 'cmsmasters') . '.<br />' . __('Your images were added', 'cmsmasters') . '.<br /><br /><em>' . __('Note', 'cmsmasters') . ': ' . __('thumbnails will appear only after page reloading', 'cmsmasters') . '.</em></p>';
            }
        }
        
        get_attachments($post->ID, 'pt_images', $imgs);
    }
}

?>
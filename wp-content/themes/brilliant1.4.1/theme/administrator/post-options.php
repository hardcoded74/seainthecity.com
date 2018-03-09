<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.3
 * 
 * Admin Panel Posts, Pages & Projects Options
 * Created by CMSMasters
 * 
 */


function cmsmasters_meta_boxes($meta_name = false) {
    global $themename;
	
    require(CMSMASTERS_CLASSES . '/var.php');
    
    $blog_post_share = ($blog_post_share) ? 'true' : 'false';
    $blog_post_aboutauthor = ($blog_post_aboutauthor) ? 'true' : 'false';
    $blog_post_related = ($blog_post_related) ? 'true' : 'false';
    $blog_post_popular = ($blog_post_popular) ? 'true' : 'false';
    $blog_post_recent = ($blog_post_recent) ? 'true' : 'false';
    $portfolio_post_share = ($portfolio_post_share) ? 'true' : 'false';
    $portfolio_post_aboutauthor = ($portfolio_post_aboutauthor) ? 'true' : 'false';
    $portfolio_post_related = ($portfolio_post_related) ? 'true' : 'false';
    $portfolio_post_popular = ($portfolio_post_popular) ? 'true' : 'false';
    $portfolio_post_recent = ($portfolio_post_recent) ? 'true' : 'false';
    
    $meta_boxes = array(
        'generalpost' => array(
            'id' => 'cmsmasters_generalpost_meta',
            'title' => $themename . ' ' . __('Post Options', 'cmsmasters'),
            'function' => 'cmsmasters_generalpost_meta_box',
            'noncename' => 'cmsmasters_generalpost',
            'fields' => array(
                'post_link_text_meta' => array(
                    'name' => 'post_link_text',
                    'type' => 'text_placeholder',
                    'width' => 'full',
                    'default' => '',
                    'placeholder' => __('Enter link text here', 'cmsmasters') . '...',
                    'hidden' => 'hidden',
                    'title' => __('Enter Link Text', 'cmsmasters'),
                    'description' => __('Enter the link that you would like to display on this item.', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'post_link_link_meta' => array(
                    'name' => 'post_link_link',
                    'type' => 'text_placeholder',
                    'width' => 'full',
                    'default' => '',
                    'placeholder' => __('Enter link adress here', 'cmsmasters') . '...',
                    'hidden' => 'hidden',
                    'title' => __('Link adress', 'cmsmasters'),
                    'description' => __('Enter the link adress that you would like to display on this item.', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'post_video_link_meta' => array(
                    'name' => 'post_video_link',
                    'type' => 'text',
                    'width' => 'full',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Video Link', 'cmsmasters'),
                    'description' => __('Enter the link to video that you would like to display on this item.', 'cmsmasters') . ' <br />' . __('Note', 'cmsmasters') . ': ' . __('you can use link to youtube or vimeo for embeded video', 'cmsmasters') . ' (http://www.youtube.com/watch?v=IyaFEBI_L24) <br />' . __('or urls to video files for video player in format', 'cmsmasters') . ' <strong>' . __('first_file_extensions: first_file_url, second_file_extensions: second_file_url', 'cmsmasters') . '</strong> <br />(mp4: http://video-js.zencoder.com/oceans-clip.mp4, ogv: http://video-js.zencoder.com/oceans-clip.ogv).',
                    'label' => '',
                    'margin' => true
                ),
                'post_audio_link_meta' => array(
                    'name' => 'post_audio_link',
                    'type' => 'text',
                    'width' => 'full',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Audio Link', 'cmsmasters'),
                    'description' => __('Enter the link to audio that you would like to display on this item.', 'cmsmasters') . ' <br />' . __('Note', 'cmsmasters') . ': ' . __('you can use urls to audio files for audioo player in format', 'cmsmasters') . ' <strong>' . __('first_file_extensions: first_file_url, second_file_extensions: second_file_url', 'cmsmasters') . '</strong> <br />(mp3: http://www.jplayer.org/audio/mp3/Miaow-01-Tempered-song.mp3, ogg: http://www.jplayer.org/audio/ogg/Miaow-01-Tempered-song.ogg).',
                    'label' => '',
                    'margin' => true
                ),
                'selected_layout_meta' => array(
                    'name' => 'page_layout',
                    'type' => 'radio_three',
                    'default' => $blog_post_layout,
                    'hidden' => '',
                    "value" => "sidebar_bg",
                    "value2" => "sidebar_bg sidebar_left",
                    "value3" => "nobg",
                    'desc' => 'Right Sidebar',
                    'desc2' => 'Left Sidebar',
                    'desc3' => 'Full Width',
                    'title' => __('Page Layout Type', 'cmsmasters'),
                    'description' => __('Choose current page layout type.', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'selected_sidebar_meta' => array(
                    'name' => 'selected_sidebar',
                    'type' => 'select_sidebar',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Custom Sidebar', 'cmsmasters'),
                    'description' => __('Select the custom sidebar that you would like to display on this page.', 'cmsmasters') . ' <br />' . __('Note', 'cmsmasters') . ': ' . __('first you will need to create a custom sidebar in your themes option panel before it will show up here.', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'post_more_text_meta' => array(
                    'name' => 'post_more_text',
                    'type' => 'text',
                    'width' => '',
                    'default' => __('Read More', 'cmsmasters'),
                    'hidden' => '',
                    'title' => __('Post Read More Button Text', 'cmsmasters'),
                    'description' => __('Enter the post read more button text that you would like to display on this item.', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'sharing_box_active_meta' => array(
                    'name' => 'sharing_box_active',
                    'type' => 'radio',
                    'default' => $blog_post_share,
                    'hidden' => '',
                    'title' => __('Sharing Box Visibility', 'cmsmasters'),
                    'description' => __('Choose sharing box visibility for current article.', 'cmsmasters'),
                    'desc' => __('Enable Sharing Box', 'cmsmasters'),
                    'desc2' => __('Disable Sharing Box', 'cmsmasters'),
                    'value' => 'true',
                    'value2' => 'false',
                    'label' => '',
                    'margin' => true
                ),
                'author_box_active_meta' => array(
                    'name' => 'author_box_active',
                    'type' => 'radio',
                    'default' => $blog_post_aboutauthor,
                    'hidden' => '',
                    'title' => __('About Author Box Visibility', 'cmsmasters'),
                    'description' => __('Choose about author box visibility for current article.', 'cmsmasters'),
                    'desc' => __('Enable About Author Box', 'cmsmasters'),
                    'desc2' => __('Disable About Author Box', 'cmsmasters'),
                    'value' => 'true',
                    'value2' => 'false',
                    'label' => '',
                    'margin' => true
                ),
                'posts_box_related_active_meta' => array(
                    'name' => 'posts_box_related_active',
                    'type' => 'radio',
                    'default' => $blog_post_related,
                    'hidden' => '',
                    'title' => __('Related Posts Box Visibility', 'cmsmasters'),
                    'description' => __('Choose related posts box visibility for current article.', 'cmsmasters'),
                    'desc' => __('Enable Related Posts Box', 'cmsmasters'),
                    'desc2' => __('Disable Related Posts Box', 'cmsmasters'),
                    'value' => 'true',
                    'value2' => 'false',
                    'label' => '',
                    'margin' => true
                ),
                'posts_box_popular_active_meta' => array(
                    'name' => 'posts_box_popular_active',
                    'type' => 'radio',
                    'default' => $blog_post_popular,
                    'hidden' => '',
                    'title' => __('Popular Posts Box Visibility', 'cmsmasters'),
                    'description' => __('Choose popular posts box visibility for current article.', 'cmsmasters'),
                    'desc' => __('Enable Popular Posts Box', 'cmsmasters'),
                    'desc2' => __('Disable Popular Posts Box', 'cmsmasters'),
                    'value' => 'true',
                    'value2' => 'false',
                    'label' => '',
                    'margin' => true
                ),
                'posts_box_recent_active_meta' => array(
                    'name' => 'posts_box_recent_active',
                    'type' => 'radio',
                    'default' => $blog_post_recent,
                    'hidden' => '',
                    'title' => __('Recent Posts Box Visibility', 'cmsmasters'),
                    'description' => __('Choose recent posts box visibility for current article.', 'cmsmasters'),
                    'desc' => __('Enable Recent Posts Box', 'cmsmasters'),
                    'desc2' => __('Disable Recent Posts Box', 'cmsmasters'),
                    'value' => 'true',
                    'value2' => 'false',
                    'label' => '',
                    'margin' => true
                ),
                'middlesidebar_active_meta' => array(
                    'name' => 'middlesidebar_active',
                    'type' => 'radio',
                    'default' => 'false',
                    'hidden' => '',
                    'title' => __('Middle Horizontal Sidebar', 'cmsmasters'),
                    'description' => __('Choose current page middle horizontal sidebar visibility here.', 'cmsmasters'),
                    'label' => '',
                    'desc' => __('Enable Middle Sidebar', 'cmsmasters'),
                    'desc2' => __('Disable Middle Sidebar', 'cmsmasters'),
                    'value' => 'true',
                    'value2' => 'false',
                    'margin' => false
                )
            )
        ),
        
        'generalpage' => array(
            'id' => 'cmsmasters_generalpage_meta',
            'title' => $themename . ' ' . __('General Page Options', 'cmsmasters'),
            'function' => 'cmsmasters_generalpage_meta_box',
            'noncename' => 'cmsmasters_generalpage',
            'fields' => array(
                'selected_layout_meta' => array(
                    'name' => 'page_layout',
                    'type' => 'radio_three',
                    'default' => 'sidebar_bg',
                    'hidden' => '',
                    "value" => "sidebar_bg",
                    "value2" => "sidebar_bg sidebar_left",
                    "value3" => "nobg",
                    'desc' => __('Right Sidebar', 'cmsmasters'),
                    'desc2' => __('Left Sidebar', 'cmsmasters'),
                    'desc3' => __('Full Width', 'cmsmasters'),
                    'title' => __('Page Layout Type', 'cmsmasters'),
                    'description' => __('Choose current page layout type.', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'selected_sidebar_meta' => array(
                    'name' => 'selected_sidebar',
                    'type' => 'select_sidebar',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Custom Sidebar', 'cmsmasters'),
                    'description' => __('Select the custom sidebar that you would like to display on this page.', 'cmsmasters') . ' <br />' . __('Note', 'cmsmasters') . ': ' . __('first you will need to create a custom sidebar in your themes option panel before it will show up here.', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'selected_numbercolumns_sidebar_meta' => array(
                    'name' => 'selected_numbercolumns_sidebar',
                    'type' => 'select_numbercolumns_sidebar',
                    'width' => '',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Column Number', 'cmsmasters'),
                    'description' => __('Select the number of columns for current page.', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'selected_numbercolumns_full_meta' => array(
                    'name' => 'selected_numbercolumns_full',
                    'type' => 'select_numbercolumns_full',
                    'width' => '',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Column Number', 'cmsmasters'),
                    'description' => __('Select the number of columns for current page.', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'selected_order_type_meta' => array(
                    'name' => 'selected_order_type',
                    'type' => 'select_order',
                    'width' => '',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Order Type', 'cmsmasters'),
                    'description' => __('Select the posts order type', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'selected_order_meta' => array(
                    'name' => 'selected_order',
                    'type' => 'radio',
                    'width' => '',
                    'default' => 'DESC',
                    'hidden' => 'hidden',
                    "value" => "DESC",
                    "value2" => "ASC",
                    'desc' => __('DESC', 'cmsmasters'),
                    'desc2' => __('ASC', 'cmsmasters'),
                    'title' => __('Order', 'cmsmasters'),
                    'description' => __('Select the order.', 'cmsmasters') . ' <br />' . __('Note', 'cmsmasters') . ': ' . __('from larger to smaller or backwords', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'selected_perpage_meta' => array(
                    'name' => 'selected_perpage',
                    'type' => 'spinner',
                    'default' => '10',
                    'hidden' => 'hidden',
                    'min' => '1',
                    'max' => '100',
                    'step' => '1',
                    'title' => __('Items Per Page', 'cmsmasters'),
                    'description' => __('Type the number of items per page', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'blog_categ_meta' => array(
                    'name' => 'blog_categ',
                    'type' => 'select_categ',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Blog Category', 'cmsmasters'),
                    'description' => __('Select the blog category that you would like to display on this page.', 'cmsmasters') . ' <br />' . __('Note', 'cmsmasters') . ': ' . __('first you will need to create a category of posts in posts tab of admin panel before it will show up here.', 'cmsmasters') . ' <br />(' . __('if you not choose any category than all posts will be shown on this page', 'cmsmasters') . ')',
                    'label' => '',
                    'margin' => true
                ),
                'portfolio_categ_meta' => array(
                    'name' => 'portfolio_categ',
                    'type' => 'select_post_type_categ',
                    'post_type' => 'pt-categ',
                    'width' => '',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Portfolio Type', 'cmsmasters'),
                    'description' => __('Select the type of portfolio that you would like to display on this page.', 'cmsmasters') . ' <br />' . __('Note', 'cmsmasters') . ': ' . __('first you will need to create a type of portfolio in portfolio post type tab of admin panel before it will show up here.', 'cmsmasters') . ' <br />(' . __('if you not choose any type than all portfolio will be shown on this page', 'cmsmasters') . ')',
                    'label' => '',
                    'margin' => true
                ),
                'filter_active_meta' => array(
                    'name' => 'filter_active',
                    'type' => 'radio',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Items Filter & Sort', 'cmsmasters'),
                    'description' => __('Choose current page items filter & sort visibility here.', 'cmsmasters'),
                    'label' => '',
                    'desc' => __('Enable Filter & Sort', 'cmsmasters'),
                    'desc2' => __('Disable Filter & Sort', 'cmsmasters'),
                    'value' => 'true',
                    'value2' => 'false',
                    'margin' => true
                ),
                'middlesidebar_active_meta' => array(
                    'name' => 'middlesidebar_active',
                    'type' => 'radio',
                    'default' => 'false',
                    'hidden' => '',
                    'title' => __('Middle Horizontal Sidebar', 'cmsmasters'),
                    'description' => __('Choose current page middle horizontal sidebar visibility here.', 'cmsmasters'),
                    'label' => '',
                    'desc' => __('Enable Middle Sidebar', 'cmsmasters'),
                    'desc2' => __('Disable Middle Sidebar', 'cmsmasters'),
                    'value' => 'true',
                    'value2' => 'false',
                    'margin' => false
                )
            )
        ),
        
        'generalportfolio' => array(
            'id' => 'cmsmasters_generalportfolio_meta',
            'title' => $themename . ' ' . __('Project Options', 'cmsmasters'),
            'function' => 'cmsmasters_generalportfolio_meta_box',
            'noncename' => 'cmsmasters_generalportfolio',
            'fields' => array(
                'selected_numbercolumns_sidebar_album_meta' => array(
                    'name' => 'selected_numbercolumns_sidebar_album',
                    'type' => 'album_numbercolumns_sidebar',
                    'width' => '',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Column Number', 'cmsmasters'),
                    'description' => __('Select the number of columns for current project.', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'selected_numbercolumns_full_album_meta' => array(
                    'name' => 'selected_numbercolumns_full_album',
                    'type' => 'album_numbercolumns_full',
                    'width' => '',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Column Number', 'cmsmasters'),
                    'description' => __('Select the number of columns for current project.', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'project_video_link_meta' => array(
                    'name' => 'project_video_link',
                    'type' => 'text',
                    'width' => 'full',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Video Link', 'cmsmasters'),
                    'description' => __('Enter the link to video that you would like to display on this item.', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'selected_layout_meta' => array(
                    'name' => 'page_layout',
                    'type' => 'radio_three',
                    'default' => $portfolio_post_layout,
                    'hidden' => '',
                    "value" => "sidebar_bg",
                    "value2" => "sidebar_bg sidebar_left",
                    "value3" => "nobg",
                    'desc' => __('Right Sidebar', 'cmsmasters'),
                    'desc2' => __('Left Sidebar', 'cmsmasters'),
                    'desc3' => __('Full Width', 'cmsmasters'),
                    'title' => __('Page Layout Type', 'cmsmasters'),
                    'description' => __('Choose current page layout type.', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'selected_sidebar_meta' => array(
                    'name' => 'selected_sidebar',
                    'type' => 'select_sidebar',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Custom Sidebar', 'cmsmasters'),
                    'description' => __('Select the custom sidebar that you would like to display on this page.', 'cmsmasters') . ' <br />' . __('Note', 'cmsmasters') . ': ' . __('first you will need to create a custom sidebar in your themes option panel before it will show up here.', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'project_more_meta' => array(
                    'name' => 'project_more',
                    'type' => 'text',
                    'width' => '',
                    'default' => __('View Project', 'cmsmasters'),
                    'hidden' => '',
                    'title' => __('Project Read More Button Text', 'cmsmasters'),
                    'description' => __('Enter the portfolio project reed more button text that you would like to display on this item.', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'project_cover_meta' => array(
                    'name' => 'project_cover',
                    'type' => 'radio',
                    'width' => '',
                    'default' => 'false',
                    'hidden' => '',
                    'value' => 'true',
                    'value2' => 'false',
                    'desc' => __('Cover', 'cmsmasters'),
                    'desc2' => __('Project Format', 'cmsmasters'),
                    'title' => __('Portfolio Page Display Type', 'cmsmasters'),
                    'description' => __('Choose portfolio page display type cover that links to project page or project format (slider, video, cover with lightbox).', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'sharing_box_active_meta' => array(
                    'name' => 'sharing_box_active',
                    'type' => 'radio',
                    'default' => $portfolio_post_share,
                    'hidden' => '',
                    'title' => __('Sharing Box Visibility', 'cmsmasters'),
                    'description' => __('Choose sharing box visibility for current project.', 'cmsmasters'),
                    'desc' => __('Enable Sharing Box', 'cmsmasters'),
                    'desc2' => __('Disable Sharing Box', 'cmsmasters'),
                    'value' => 'true',
                    'value2' => 'false',
                    'label' => '',
                    'margin' => true
                ),
                'author_box_active_meta' => array(
                    'name' => 'author_box_active',
                    'type' => 'radio',
                    'default' => $portfolio_post_aboutauthor,
                    'hidden' => '',
                    'title' => __('About Author Box Visibility', 'cmsmasters'),
                    'description' => __('Choose about author box visibility for current project.', 'cmsmasters'),
                    'desc' => __('Enable About Author Box', 'cmsmasters'),
                    'desc2' => __('Disable About Author Box', 'cmsmasters'),
                    'value' => 'true',
                    'value2' => 'false',
                    'label' => '',
                    'margin' => true
                ),
                'posts_box_related_active_meta' => array(
                    'name' => 'posts_box_related_active',
                    'type' => 'radio',
                    'default' => $portfolio_post_related,
                    'hidden' => '',
                    'title' => __('Related Projects Box Visibility', 'cmsmasters'),
                    'description' => __('Choose related projects box visibility for current project.', 'cmsmasters'),
                    'desc' => __('Enable Related Projects Box', 'cmsmasters'),
                    'desc2' => __('Disable Related Projects Box', 'cmsmasters'),
                    'value' => 'true',
                    'value2' => 'false',
                    'label' => '',
                    'margin' => true
                ),
                'posts_box_popular_active_meta' => array(
                    'name' => 'posts_box_popular_active',
                    'type' => 'radio',
                    'default' => $portfolio_post_popular,
                    'hidden' => '',
                    'title' => __('Popular Projects Box Visibility', 'cmsmasters'),
                    'description' => __('Choose popular projects box visibility for current project.', 'cmsmasters'),
                    'desc' => __('Enable Popular Projects Box', 'cmsmasters'),
                    'desc2' => __('Disable Popular Projects Box', 'cmsmasters'),
                    'value' => 'true',
                    'value2' => 'false',
                    'label' => '',
                    'margin' => true
                ),
                'posts_box_recent_active_meta' => array(
                    'name' => 'posts_box_recent_active',
                    'type' => 'radio',
                    'default' => $portfolio_post_recent,
                    'hidden' => '',
                    'title' => __('Recent Projects Box Visibility', 'cmsmasters'),
                    'description' => __('Choose recent projects box visibility for current project.', 'cmsmasters'),
                    'desc' => __('Enable Recent Projects Box', 'cmsmasters'),
                    'desc2' => __('Disable Recent Projects Box', 'cmsmasters'),
                    'value' => 'true',
                    'value2' => 'false',
                    'label' => '',
                    'margin' => true
                ),
                'middlesidebar_active_meta' => array(
                    'name' => 'middlesidebar_active',
                    'type' => 'radio',
                    'default' => 'false',
                    'hidden' => '',
                    'title' => __('Middle Horizontal Sidebar', 'cmsmasters'),
                    'description' => __('Choose current page middle horizontal sidebar visibility here.', 'cmsmasters'),
                    'label' => '',
                    'desc' => __('Enable Middle Sidebar', 'cmsmasters'),
                    'desc2' => __('Disable Middle Sidebar', 'cmsmasters'),
                    'value' => 'true',
                    'value2' => 'false',
                    'margin' => false
                )
            )
        ),
		
		'bgtools' => array(
			'id' => 'cmsmasters_bgtools_meta',
			'title' => $themename.' Custom Background Options',
			'function' => 'cmsmasters_bgtools_meta_box',
			'noncename' => 'cmsmasters_bgtools',
			'fields' => array(
				'bgtools_active_meta' => array(
					'name' => 'bgtools_active',
					'type' => 'radio',
					'default' => '',
					'hidden' => '',
					'title' => __('Custom Background Options', 'cmsmasters'),
					'description' => __("Choose 'Use Custom Background Options' if you want use it on this item.", 'cmsmasters'),
					'label' => '',
					'desc' => __('Use Default Background Options', 'cmsmasters'),
					'desc2' => __('Use Custom Background Options', 'cmsmasters'),
					'value' => 'false',
					'value2' => 'true',
					'margin' => false
				),
				'bgtools_color_meta' => array(
					'name' => 'bgtools_color',
					'type' => 'color',
					'default' => $custom_background_color,
					'hidden' => 'hidden',
					'title' => __('Custom Background Color', 'cmsmasters'),
					'description' => __('Choose your custom background color for this page.', 'cmsmasters'),
					'label' => '',
					'margin' => true
				),
				'bgtools_image_meta' => array(
					'name' => 'bgtools_image',
					'type' => 'bgs',
					'default' => $custom_background_img,
					'hidden' => 'hidden',
					'title' => __('Custom Background Image', 'cmsmasters'),
					'description' => __('Choose your custom background image for this page.', 'cmsmasters'),
					'label' => '',
					'margin' => false
				)
			)
		),
        
        'slidertools' => array(
            'id' => 'cmsmasters_slidertools_meta',
            'title' => $themename . ' ' . __('Page Slider Options', 'cmsmasters'),
            'function' => 'cmsmasters_slidertools_meta_box',
            'noncename' => 'cmsmasters_slidertools',
            'fields' => array(
                'slidertools_active_meta' => array(
                    'name' => 'slidertools_active',
                    'type' => 'radio',
                    'default' => '',
                    'hidden' => '',
                    'title' => __('Page Slider', 'cmsmasters'),
                    'description' => __('Choose current page slider visibility.', 'cmsmasters'),
                    'label' => '',
                    'desc' => __('Disable Slider', 'cmsmasters'),
                    'desc2' => __('Enable Slider', 'cmsmasters'),
                    'value' => 'false',
                    'value2' => 'true',
                    'margin' => false
                ),
                'slidertools_slider_id_meta' => array(
                    'name' => 'slidertools_slider_id',
                    'type' => 'select_slider',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Slider Name', 'cmsmasters'),
                    'description' => __('Select slider for current page.', 'cmsmasters'),
                    'label' => '',
                    'margin' => false
                )
            )
        ),
        
        'headingtools' => array(
            'id' => 'cmsmasters_headingtools_meta',
            'title' => $themename . ' ' . __('Page Heading Options', 'cmsmasters'),
            'function' => 'cmsmasters_headingtools_meta_box',
            'noncename' => 'cmsmasters_headingtools',
            'fields' => array(
                'headingtools_active_meta' => array(
                    'name' => 'headingtools_active',
                    'type' => 'radio_toggle',
                    'default' => 'disabled',
                    'hidden' => '',
                    'title' => __('Custom Page Heading', 'cmsmasters'),
                    'description' => __('Choose current page heading style here.', 'cmsmasters'),
                    'label' => '',
                    'desc' => __('Use Default Heading', 'cmsmasters'),
                    'desc2' => __('Use Custom Heading', 'cmsmasters'),
                    'desc3' => __('Use Top Sidebar', 'cmsmasters'),
                    'desc4' => __('Disable Heading', 'cmsmasters'),
                    'value' => 'default',
                    'value2' => 'custom',
                    'value3' => 'sidebar',
                    'value4' => 'disabled',
                    'margin' => false
                ),
                'headingtools_title_meta' => array(
                    'name' => 'headingtools_title',
                    'type' => 'text',
                    'width' => 'full',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Custom Heading Title', 'cmsmasters'),
                    'description' => __('Enter your custom heading title for this page.', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'headingtools_description_meta' => array(
                    'name' => 'headingtools_description',
                    'type' => 'text',
                    'default' => '',
                    'hidden' => 'hidden',
                    'width' => 'full',
                    'title' => __('Custom Heading Description', 'cmsmasters'),
                    'description' => __('Enter your custom heading description text for this page.', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'headingtools_icon_meta' => array(
                    'name' => 'headingtools_icon',
                    'type' => 'choose_icon',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Custom Heading Icon', 'cmsmasters'),
                    'description' => __('Choose your custom heading icon for this page.', 'cmsmasters') . ' <br />' . __('Note', 'cmsmasters') . ': ' . __('also you can download your own icon from CMSMasters Admin Panel > General Options > Theme Icons', 'cmsmasters'),
                    'label' => '',
                    'margin' => false
                )
            )
        ),
        
        'breadtools' => array(
            'id' => 'cmsmasters_breadtools_meta',
            'title' => $themename . ' ' . __('Custom Breadcrumbs Options', 'cmsmasters'),
            'function' => 'cmsmasters_breadtools_meta_box',
            'noncename' => 'cmsmasters_breadtools',
            'fields' => array(
                'selected_breadcrumbs_active_meta' => array(
                    'name' => 'selected_breadcrumbs_active',
                    'type' => 'radio_three',
                    'default' => '',
                    'hidden' => '',
                    'title' => __('Custom Breadcrumbs', 'cmsmasters'),
                    'description' => __('Choose "Use Custom Breadcrumbs" if you want use it on this item.', 'cmsmasters'),
                    'label' => '',
                    'desc' => __('Use Default Breadcrumbs', 'cmsmasters'),
                    'desc2' => __('Use Custom Breadcrumbs', 'cmsmasters'),
                    'desc3' => __('Disable Breadcrumbs', 'cmsmasters'),
                    'value' => 'false',
                    'value2' => 'true',
                    'value3' => 'disable',
                    'margin' => false
                ),
                'selected_breadcrumbs_meta' => array(
                    'name' => 'selected_breadcrumbs',
                    'type' => 'add_item',
                    'default' => '',
                    'hidden' => 'hidden',
                    'width' => 'small',
                    'title' => __('Custom Breadcrumbs', 'cmsmasters'),
                    'description' => __('Enter your custom breadcrumbs text and link, or choose page and add it to your breadcrumbs list that you would like to show on this page between home page link and current page name.', 'cmsmasters'),
                    'label' => __('Page Name', 'cmsmasters'),
                    'label2' => __('Page Link', 'cmsmasters'),
                    'margin' => false
                ),
                'selected_breadcrumbs_links_meta' => array(
                    'name' => 'selected_breadcrumbs_links',
                    'type' => 'hidden',
                    'default' => '',
                    'hidden' => 'hidden',
                    'width' => '',
                    'title' => '',
                    'description' => '',
                    'label' => '',
                    'margin' => false
                )
            )
        ),
        
        'seotools' => array(
            'id' => 'cmsmasters_seotools_meta',
            'title' => $themename . ' ' . __('Custom SEO Options', 'cmsmasters'),
            'function' => 'cmsmasters_seotools_meta_box',
            'noncename' => 'cmsmasters_seotools',
            'fields' => array(
                'seotools_active_meta' => array(
                    'name' => 'seotools_active',
                    'type' => 'radio',
                    'default' => '',
                    'hidden' => '',
                    'title' => __('Custom SEO Options', 'cmsmasters'),
                    'description' => __('Choose "Use Custom SEO Options" if you want use it on this item.', 'cmsmasters'),
                    'label' => '',
                    'desc' => __('Use Default SEO Options', 'cmsmasters'),
                    'desc2' => __('Use Custom SEO Options', 'cmsmasters'),
                    'value' => 'false',
                    'value2' => 'true',
                    'margin' => false
                ),
                'seotools_title_meta' => array(
                    'name' => 'seotools_title',
                    'type' => 'text',
                    'default' => '',
                    'hidden' => 'hidden',
                    'width' => 'full',
                    'title' => __('Custom Title', 'cmsmasters'),
                    'description' => __('Enter your custom this item title.', 'cmsmasters') . ' <br />' . __('Note', 'cmsmasters') . ': ' . __('we recommend you enter no more than 60 characters', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'seotools_description_meta' => array(
                    'name' => 'seotools_description',
                    'type' => 'textarea',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Custom Description', 'cmsmasters'),
                    'description' => __('Enter your custom this item description.', 'cmsmasters') . ' <br />' . __('Note', 'cmsmasters') . ': ' . __('we recommend you enter no more than 160 characters', 'cmsmasters'),
                    'label' => '',
                    'margin' => true
                ),
                'seotools_keywords_meta' => array(
                    'name' => 'seotools_keywords',
                    'type' => 'textarea',
                    'default' => '',
                    'hidden' => 'hidden',
                    'title' => __('Custom Keywords', 'cmsmasters'),
                    'description' => __('Enter your custom this item keywords.', 'cmsmasters'),
                    'label' => '',
                    'margin' => false
                )
            )
        )
    );
    
    if ($meta_name) {
        return $meta_boxes[$meta_name];
    } else {
        return $meta_boxes;
    }
}

function cmsmasters_add_meta_box($box_name) {
    global $post;
    
    $meta_box = cmsmasters_meta_boxes($box_name);
    
    foreach ($meta_box['fields'] as $meta_id => $meta_field) {
        $existing_value = get_post_meta($post->ID, $meta_field['name'], true);
        $value = ($existing_value != '') ? $existing_value : $meta_field['default'];
        $margin = ($meta_field['margin']) ? ' class="add_margin"' : ' class="remove_margin"';
        
        if ($meta_field['description']) {
            $switch = ' <a class="switch" href="">[+] ' . __('more info', 'cmsmasters') . '</a>';
            $description = '<p class="description">' . $meta_field['description'] . '</p>' . "\n";
        } else {
            $switch = '';
            $description = '';
        }
        ?>
        <div id="<?php echo $meta_id; ?>" class="cmsmasters-post-control<?php echo ' ' . $meta_field['hidden']; ?>">
            <p><strong><?php echo $meta_field['title']; ?></strong><?php echo $switch; ?></p>
            <?php 
            if ($description) {
                echo $description;
            } 
            switch ($meta_field['type']) {
            case 'textarea':
            ?>
                <p<?php echo $margin; ?>>
                    <textarea id="<?php echo $meta_field['name']; ?>" name="<?php echo $meta_field['name']; ?>" cols="40" rows="2"><?php echo $value; ?></textarea>
                    <br />
                    <label for="<?php echo $meta_field['name']; ?>"><?php echo $meta_field['label']; ?></label>
                </p>
                <?php
                break;
            case 'text':
                $width = ($meta_field['width']) ? ' ' . $meta_field['width'] : '';
			?>
                <p<?php echo $margin; ?>>
                    <input type="text" value="<?php echo $value; ?>" name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" class="text_input<?php echo $width; ?>"/>
                    <br />
                    <label for="<?php echo $meta_field['name']; ?>"><?php echo $meta_field['label']; ?></label>
                </p>
                <?php
                break;
            case 'text_placeholder':
                $width = ($meta_field['width']) ? ' ' . $meta_field['width'] : '';
			?>
                <p<?php echo $margin; ?>>
                    <input type="text" placeholder="<?php echo $meta_field['placeholder']; ?>" value="<?php echo $value; ?>" name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" class="text_input<?php echo $width; ?>"/>
                    <br />
                    <label for="<?php echo $meta_field['name']; ?>"><?php echo $meta_field['label']; ?></label>
                </p>
                <?php
                break;
            case 'add_item':
                $width = ($meta_field['width']) ? ' ' . $meta_field['width'] : '';
			?>
                <div style="overflow:hidden;" id="<?php echo $meta_field['name']; ?>_container">
                    <div class="fr" style="padding-left:20px; width:50%;">
                        <p>
                            <a href="#" id="<?php echo $meta_field['name']; ?>_cancel" style="display:none; float:right; margin-right:10px;"><?php _e('Cancel', 'cmsmasters'); ?></a>
                            <label for="<?php echo $meta_field['name']; ?>_name" style="display:block; padding-bottom:5px;"><?php echo __('Enter', 'cmsmasters') . ' ' . $meta_field['label']; ?></label>
                            <input type="text" value="" name="<?php echo $meta_field['name']; ?>_name" id="<?php echo $meta_field['name']; ?>_name" class="text_input<?php echo $width; ?>" />
                        </p>
                        <p>
                            <label for="<?php echo $meta_field['name']; ?>_value" style="display:block; padding-bottom:5px;"><?php echo __('Enter', 'cmsmasters') . ' ' . $meta_field['label2']; ?></label>
                            <input type="text" value="" name="<?php echo $meta_field['name']; ?>_value" id="<?php echo $meta_field['name']; ?>_value" class="text_input<?php echo $width; ?>" />
                        </p>
                        <p>
                            <label for="<?php echo $meta_field['name']; ?>_select_value" style="display:block; padding-bottom:5px;"><?php _e('Or Select Page', 'cmsmasters'); ?></label>
                            <select name="<?php echo $meta_field['name']; ?>_select_value" id="<?php echo $meta_field['name']; ?>_select_value" style="width:100%; padding-top:3px; padding-bottom:3px; height:2.2em;">
                                <option value="" selected="selected"><?php _e('Select Page Name & Link', 'cmsmasters'); ?>&nbsp;</option>
                                <?php
                                $page_links = get_pages();
                                
                                if (is_array($page_links) && !empty($page_links)) {
                                    foreach ($page_links as $page_link) {
										echo "<option value='" . get_page_link($page_link->ID) . "'>$page_link->post_title</option>\n";
                                    }
                                }
                                ?>
                            </select>
                        </p>
                        <p>
                            <input type="button" value="<?php _e('Delete Item', 'cmsmasters'); ?>" name="<?php echo $meta_field['name']; ?>_delete" id="<?php echo $meta_field['name']; ?>_delete" class="button fr" style="display:none;" />
                            <input type="button" value="<?php _e('Update Item', 'cmsmasters'); ?>" name="<?php echo $meta_field['name']; ?>_update" id="<?php echo $meta_field['name']; ?>_update" class="button" style="display:none;" />
                            <input type="button" value="<?php _e('Add Item', 'cmsmasters'); ?>" name="<?php echo $meta_field['name']; ?>_add" id="<?php echo $meta_field['name']; ?>_add" class="button" />
                        </p>
                    </div>
                    <div class="<?php echo $meta_field['name']; ?>_list delete_item_list">
                    <?php
                    $breadcrumbs = get_post_meta(get_the_ID(), 'selected_breadcrumbs', true);
                    $breadcrumbs_links = get_post_meta(get_the_ID(), 'selected_breadcrumbs_links', true);
                    
                    $breadcrbs = explode(';', $breadcrumbs);
                    $breadcrbls = explode(';', $breadcrumbs_links);
                    $brcrmb = 0;
                    
                    foreach ($breadcrbs as $breadcrb) {
                        if ($breadcrb != '') {
                            echo '<a href="' . $breadcrbls[$brcrmb] . '" class="delete_item">' . $breadcrb . '</a>';
                            
                            $brcrmb = $brcrmb + 1;
                        }
                    }
                    ?>
                    </div>
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        var itemlist = jQuery('.<?php echo $meta_field['name']; ?>_list');
                        
                        itemlist.sortable( {
                            placeholder : 'ui-sortable-placeholder',
                            forcePlaceholderSize : true,
                            cursor : 'move',
                            update : function (event, ui) {
                                var valnames = '';
                                var vallinks = '';
                                
                                itemlist.find('a').each(function () {
                                    if (valnames === '') {
                                        valnames = jQuery(this).html();
                                    } else {
                                        valnames = valnames + ';' + jQuery(this).html();
                                    }
                                    
                                    if (vallinks === '') {
                                        vallinks = jQuery(this).attr('href');
                                    } else {
                                        vallinks = vallinks + ';' + jQuery(this).attr('href');
                                    }
                                } );
                                
                                jQuery('#<?php echo $meta_field['name']; ?>').val(valnames);
                                jQuery('#<?php echo $meta_field['name']; ?>_links').val(vallinks);
                            }
                        } );
                        
                        itemlist.find('a.delete_item').live('click', function () {
                            jQuery('#<?php echo $meta_field['name']; ?>_container a.delete_item.activeitem').removeClass('activeitem');
                            jQuery(this).addClass('activeitem');
                            jQuery('#<?php echo $meta_field['name']; ?>_add').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_update').show();
                            jQuery('#<?php echo $meta_field['name']; ?>_delete').show();
                            jQuery('#<?php echo $meta_field['name']; ?>_cancel').show();
                            jQuery('#<?php echo $meta_field['name']; ?>_name').val(jQuery(this).html());
                            jQuery('#<?php echo $meta_field['name']; ?>_value').val(jQuery(this).attr('href'));
                            
                            return false;
                        } );
                        
                        jQuery('#<?php echo $meta_field['name']; ?>_add').click(function () {
                            var updatetext = jQuery('#<?php echo $meta_field['name']; ?>_name').val();
                            var updatelink = jQuery('#<?php echo $meta_field['name']; ?>_value').val();
                            
                            if (updatetext === '' || updatelink === '') {
                                alert('<?php _e('Enter breadcrumb text and link!', 'cmsmasters'); ?>');
                                
                                return false;
                            }
                            
                            itemlist.append('<a href="' + updatelink + '" class="delete_item">' + updatetext + '</a>');
                            
                            var valnames = '';
                            var vallinks = '';
                            
                            itemlist.find('a').each(function () {
                                if (valnames === '') {
                                    valnames = jQuery(this).html();
                                } else {
                                    valnames = valnames + ';' + jQuery(this).html();
                                }
                                
                                if (vallinks === '') {
                                    vallinks = jQuery(this).attr('href');
                                } else {
                                    vallinks = vallinks + ';' + jQuery(this).attr('href');
                                }
                            } );
                            
                            jQuery('#<?php echo $meta_field['name']; ?>').val(valnames);
                            jQuery('#<?php echo $meta_field['name']; ?>_links').val(vallinks);
                            jQuery('#<?php echo $meta_field['name']; ?>_name').val('');
                            jQuery('#<?php echo $meta_field['name']; ?>_value').val('');
                            
                            return false;
                        } );
                        
                        jQuery('#<?php echo $meta_field['name']; ?>_delete').click(function () {
                            jQuery('#<?php echo $meta_field['name']; ?>_container a.delete_item.activeitem').remove();
                            
                            var valnames = '';
                            var vallinks = '';
                            
                            itemlist.find('a').each(function () {
                                if (valnames === '') {
                                    valnames = jQuery(this).html();
                                } else {
                                    valnames = valnames + ';' + jQuery(this).html();
                                }
                                
                                if (vallinks === '') {
                                    vallinks = jQuery(this).attr('href');
                                } else {
                                    vallinks = vallinks + ';' + jQuery(this).attr('href');
                                }
                            } );
                            
                            jQuery('#<?php echo $meta_field['name']; ?>').val(valnames);
                            jQuery('#<?php echo $meta_field['name']; ?>_links').val(vallinks);
                            jQuery('#<?php echo $meta_field['name']; ?>_name').val('');
                            jQuery('#<?php echo $meta_field['name']; ?>_value').val('');
                            jQuery('#<?php echo $meta_field['name']; ?>_update').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_delete').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_cancel').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_add').show();
                            
                            return false;
                        } );
                        
                        jQuery('#<?php echo $meta_field['name']; ?>_update').click(function () {
                            var updatetext = jQuery('#<?php echo $meta_field['name']; ?>_name').val();
                            var updatelink = jQuery('#<?php echo $meta_field['name']; ?>_value').val();
                            
                            jQuery('#<?php echo $meta_field['name']; ?>_container a.delete_item.activeitem').attr( { href : updatelink } ).html(updatetext);
                            
                            var valnames = '';
                            var vallinks = '';
                            
                            itemlist.find('a').each(function () {
                                if (valnames === '') {
                                    valnames = jQuery(this).html();
                                } else {
                                    valnames = valnames + ';' + jQuery(this).html();
                                }
                                
                                if (vallinks === '') {
                                    vallinks = jQuery(this).attr('href');
                                } else {
                                    vallinks = vallinks+';'+jQuery(this).attr('href');
                                }
                            } );
                            
                            jQuery('#<?php echo $meta_field['name']; ?>').val(valnames);
                            jQuery('#<?php echo $meta_field['name']; ?>_links').val(vallinks);
                            jQuery('#<?php echo $meta_field['name']; ?>_container a.delete_item.activeitem').removeClass('activeitem');
                            jQuery('#<?php echo $meta_field['name']; ?>_name').val('');
                            jQuery('#<?php echo $meta_field['name']; ?>_value').val('');
                            jQuery('#<?php echo $meta_field['name']; ?>_update').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_delete').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_cancel').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_add').show();
                            
                            return false;
                        } );
                        
                        jQuery('#<?php echo $meta_field['name']; ?>_select_value').change(function () {
                            var updatename = jQuery('#<?php echo $meta_field['name']; ?>_select_value option:selected').html();
                            var updatelink = jQuery('#<?php echo $meta_field['name']; ?>_select_value').val();
                            
                            if (updatelink !== '') {
                                jQuery('#<?php echo $meta_field['name']; ?>_name').val(updatename);
                                jQuery('#<?php echo $meta_field['name']; ?>_value').val(updatelink);
                            }
                        } );
                        
                        jQuery('#<?php echo $meta_field['name']; ?>_cancel').click(function () {
                            jQuery('#<?php echo $meta_field['name']; ?>_container a.delete_item.activeitem').removeClass('activeitem');
                            jQuery('#<?php echo $meta_field['name']; ?>_name').val('');
                            jQuery('#<?php echo $meta_field['name']; ?>_value').val('');
                            jQuery('#<?php echo $meta_field['name']; ?>_update').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_delete').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_cancel').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_add').show();
                            
                            return false;
                        } );
                    } );
                </script>
                <p<?php echo $margin; ?> style="padding:0;">
                    <input type="hidden" value="<?php echo $value; ?>" name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" class="text_input" />
                </p>
                <?php
                break;
            case 'add_item_two':
                $width = ($meta_field['width']) ? ' ' . $meta_field['width'] : '';
			?>
                <div style="overflow:hidden;" id="<?php echo $meta_field['name']; ?>_container">
                    <div class="fr" style="padding-left:20px; width:50%;">
                        <p>
                            <a href="#" id="<?php echo $meta_field['name']; ?>_cancel" style="display:none; float:right; margin-right:10px;"><?php _e('Cancel', 'cmsmasters'); ?></a>
                            <label for="<?php echo $meta_field['name']; ?>_name" style="display:block; padding-bottom:5px;"><?php echo __('Enter', 'cmsmasters') . ' ' . $meta_field['label']; ?></label>
                            <input type="text" value="" name="<?php echo $meta_field['name']; ?>_name" id="<?php echo $meta_field['name']; ?>_name" class="text_input<?php echo $width; ?>" />
                        </p>
                        <p>
                            <label for="<?php echo $meta_field['name']; ?>_value" style="display:block; padding-bottom:5px;"><?php echo __('Enter', 'cmsmasters') . ' ' . $meta_field['label2']; ?></label>
                            <input type="text" value="" name="<?php echo $meta_field['name']; ?>_value" id="<?php echo $meta_field['name']; ?>_value" class="text_input<?php echo $width; ?>" />
                        </p>
                        <p>
                            <input type="button" value="<?php _e('Delete Item', 'cmsmasters'); ?>" name="<?php echo $meta_field['name']; ?>_delete" id="<?php echo $meta_field['name']; ?>_delete" class="button fr" style="display:none;" />
                            <input type="button" value="<?php _e('Update Item', 'cmsmasters'); ?>" name="<?php echo $meta_field['name']; ?>_update" id="<?php echo $meta_field['name']; ?>_update" class="button" style="display:none;" />
                            <input type="button" value="<?php _e('Add Item', 'cmsmasters'); ?>" name="<?php echo $meta_field['name']; ?>_add" id="<?php echo $meta_field['name']; ?>_add" class="button" />
                        </p>
                    </div>
                    <div class="<?php echo $meta_field['name']; ?>_list delete_item_list">
                    <?php
                    $atts = get_post_meta(get_the_ID(), 'product_atts', true);
                    $atts_vals = get_post_meta(get_the_ID(), 'product_atts_vals', true);
                    
                    $attrs = explode(';', $atts);
                    $attrvs = explode(';', $atts_vals);
                    $numbatt = 0;
                    
                    foreach ($attrs as $attr) {
                        if ($attr != '') {
                            echo '<a href="#" class="delete_item"><span class="attname">' . $attr . '</span><span class="attval">' . $attrvs[$numbatt] . '</span></a>';
                            
                            $numbatt = $numbatt + 1;
                        }
                    }
                    ?>
                    </div>
                </div>
				<script type="text/javascript">
					jQuery(document).ready(function () {
						var itemlist = jQuery('.<?php echo $meta_field['name']; ?>_list');
						
						itemlist.sortable( {
							placeholder : 'ui-sortable-placeholder',
							forcePlaceholderSize : true,
							cursor : 'move',
							update : function (event, ui) {
								var valnames = '';
								var vallinks = '';
								
								itemlist.find('a').each(function () {
									if (valnames === '') {
										valnames = jQuery(this).find('span.attname').html();
									} else {
										valnames = valnames + ';' + jQuery(this).find('span.attname').html();
									}
									
									if (vallinks === '') {
										vallinks = jQuery(this).find('span.attval').html();
									} else {
										vallinks = vallinks + ';' + jQuery(this).find('span.attval').html();
									}
								} );
								
								jQuery('#<?php echo $meta_field['name']; ?>').val(valnames);
								jQuery('#<?php echo $meta_field['name']; ?>_vals').val(vallinks);
							}
						} );
						
						itemlist.find('a.delete_item').live('click', function () {
							jQuery('#<?php echo $meta_field['name']; ?>_container a.delete_item.activeitem').removeClass('activeitem');
							jQuery(this).addClass('activeitem');
							jQuery('#<?php echo $meta_field['name']; ?>_add').hide();
							jQuery('#<?php echo $meta_field['name']; ?>_update').show();
							jQuery('#<?php echo $meta_field['name']; ?>_delete').show();
							jQuery('#<?php echo $meta_field['name']; ?>_cancel').show();
							jQuery('#<?php echo $meta_field['name']; ?>_name').val(jQuery(this).find('span.attname').html());
							jQuery('#<?php echo $meta_field['name']; ?>_value').val(jQuery(this).find('span.attval').html());
							
							return false;
						} );
						
						jQuery('#<?php echo $meta_field['name']; ?>_add').click(function () {
							var updatetext = jQuery('#<?php echo $meta_field['name']; ?>_name').val();
							var updatelink = jQuery('#<?php echo $meta_field['name']; ?>_value').val();
							
							if (updatetext === '' || updatelink === '') {
								alert('<?php _e('Enter attribute name and value!', 'cmsmasters'); ?>');
								
								return false;
							}
							
							itemlist.append('<a href="#" class="delete_item"><span class="attname">' + updatetext + '</span><span class="attval">' + updatelink + '</span></a>');
							
							var valnames = '';
							var vallinks = '';
							
							itemlist.find('a').each(function () {
								if (valnames === '') {
									valnames = jQuery(this).find('span.attname').html();
								} else {
									valnames = valnames + ';' + jQuery(this).find('span.attname').html();
								}
								
								if (vallinks === '') {
									vallinks = jQuery(this).find('span.attval').html();
								} else {
									vallinks = vallinks + ';' + jQuery(this).find('span.attval').html();
								}
							} );
							
							jQuery('#<?php echo $meta_field['name']; ?>').val(valnames);
							jQuery('#<?php echo $meta_field['name']; ?>_vals').val(vallinks);
							jQuery('#<?php echo $meta_field['name']; ?>_name').val('');
							jQuery('#<?php echo $meta_field['name']; ?>_value').val('');
							
							return false;
						} );
						
						jQuery('#<?php echo $meta_field['name']; ?>_delete').click(function () {
							jQuery('#<?php echo $meta_field['name']; ?>_container a.delete_item.activeitem').remove();
							
							var valnames = '';
							var vallinks = '';
							
							itemlist.find('a').each(function () {
								if (valnames === '') {
									valnames = jQuery(this).find('span.attname').html();
								} else {
									valnames = valnames + ';' + jQuery(this).find('span.attname').html();
								}
								
								if (vallinks === '') {
									vallinks = jQuery(this).find('span.attval').html();
								} else {
									vallinks = vallinks + ';' + jQuery(this).find('span.attval').html();
								}
							} );
							
							jQuery('#<?php echo $meta_field['name']; ?>').val(valnames);
							jQuery('#<?php echo $meta_field['name']; ?>_vals').val(vallinks);
							jQuery('#<?php echo $meta_field['name']; ?>_name').val('');
							jQuery('#<?php echo $meta_field['name']; ?>_value').val('');
							jQuery('#<?php echo $meta_field['name']; ?>_update').hide();
							jQuery('#<?php echo $meta_field['name']; ?>_delete').hide();
							jQuery('#<?php echo $meta_field['name']; ?>_cancel').hide();
							jQuery('#<?php echo $meta_field['name']; ?>_add').show();
							
							return false;
						} );
						
						jQuery('#<?php echo $meta_field['name']; ?>_update').click(function () {
							var updatetext = jQuery('#<?php echo $meta_field['name']; ?>_name').val();
							var updatelink = jQuery('#<?php echo $meta_field['name']; ?>_value').val();
							
							jQuery('#<?php echo $meta_field['name']; ?>_container a.delete_item.activeitem').find('span.attname').html(updatetext);
							jQuery('#<?php echo $meta_field['name']; ?>_container a.delete_item.activeitem').find('span.attval').html(updatelink);
							
							var valnames = '';
							var vallinks = '';
							
							itemlist.find('a').each(function () {
								if (valnames === '') {
									valnames = jQuery(this).find('span.attname').html();
								} else {
									valnames = valnames + ';' + jQuery(this).find('span.attname').html();
								}
								
								if (vallinks === '') {
									vallinks = jQuery(this).find('span.attval').html();
								} else {
									vallinks = vallinks + ';' + jQuery(this).find('span.attval').html();
								}
							} );
							
							jQuery('#<?php echo $meta_field['name']; ?>').val(valnames);
							jQuery('#<?php echo $meta_field['name']; ?>_vals').val(vallinks);
							jQuery('#<?php echo $meta_field['name']; ?>_container a.delete_item.activeitem').removeClass('activeitem');
							jQuery('#<?php echo $meta_field['name']; ?>_name').val('');
							jQuery('#<?php echo $meta_field['name']; ?>_value').val('');
							jQuery('#<?php echo $meta_field['name']; ?>_update').hide();
							jQuery('#<?php echo $meta_field['name']; ?>_delete').hide();
							jQuery('#<?php echo $meta_field['name']; ?>_cancel').hide();
							jQuery('#<?php echo $meta_field['name']; ?>_add').show();
							
							return false;
						} );
						
						jQuery('#<?php echo $meta_field['name']; ?>_cancel').click(function () {
							jQuery('#<?php echo $meta_field['name']; ?>_container a.delete_item.activeitem').removeClass('activeitem');
							jQuery('#<?php echo $meta_field['name']; ?>_name').val('');
							jQuery('#<?php echo $meta_field['name']; ?>_value').val('');
							jQuery('#<?php echo $meta_field['name']; ?>_update').hide();
							jQuery('#<?php echo $meta_field['name']; ?>_delete').hide();
							jQuery('#<?php echo $meta_field['name']; ?>_cancel').hide();
							jQuery('#<?php echo $meta_field['name']; ?>_add').show();
							
							return false;
						} );
					} );
				</script>
				<p<?php echo $margin; ?> style="padding:0;">
					<input type="hidden" value="<?php echo $value; ?>" name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" class="text_input" />
				</p>
                <?php
                break;
            case 'add_item_one':
                $width = ($meta_field['width']) ? ' ' . $meta_field['width'] : '';
			?>
                <div style="overflow:hidden;" id="<?php echo $meta_field['name']; ?>_container">
                    <div class="fr" style="padding-left:20px; width:50%;">
                        <p>
                            <a href="#" id="<?php echo $meta_field['name']; ?>_cancel" style="display:none; float:right; margin-right:10px;"><?php _e('Cancel', 'cmsmasters'); ?></a>
                            <label for="<?php echo $meta_field['name']; ?>_name" style="display:block; padding-bottom:5px;"><?php echo __('Enter', 'cmsmasters') . ' ' . $meta_field['label']; ?></label>
                            <input type="text" value="" name="<?php echo $meta_field['name']; ?>_name" id="<?php echo $meta_field['name']; ?>_name" class="text_input<?php echo $width; ?>" />
                        </p>
                        <p>
                            <input type="button" value="<?php _e('Delete Item', 'cmsmasters'); ?>" name="<?php echo $meta_field['name']; ?>_delete" id="<?php echo $meta_field['name']; ?>_delete" class="button fr" style="display:none;" />
                            <input type="button" value="<?php _e('Update Item', 'cmsmasters'); ?>" name="<?php echo $meta_field['name']; ?>_update" id="<?php echo $meta_field['name']; ?>_update" class="button" style="display:none;" />
                            <input type="button" value="<?php _e('Add Item', 'cmsmasters'); ?>" name="<?php echo $meta_field['name']; ?>_add" id="<?php echo $meta_field['name']; ?>_add" class="button" />
                        </p>
                    </div>
                    <div class="<?php echo $meta_field['name']; ?>_list delete_item_list">
                    <?php
                    $atts = get_post_meta(get_the_ID(), 'project_features', true);
                    $attrs = explode(';', $atts);
                    
                    foreach ($attrs as $attr) {
                        if ($attr !== '') {
                            echo '<a href="#" class="delete_item">' . $attr . '</a>';
                        }
                    }
                    ?>
                    </div>
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        var itemlist = jQuery('.<?php echo $meta_field['name']; ?>_list');
                        
                        itemlist.sortable( {
                            placeholder : 'ui-sortable-placeholder',
                            forcePlaceholderSize : true,
                            cursor : 'move',
                            update : function (event, ui) {
                                var valnames = '';
								
                                itemlist.find('a').each(function(){
                                    if (valnames === '') {
                                        valnames = jQuery(this).html();
                                    } else {
                                        valnames = valnames + ';' + jQuery(this).html();
                                    }
                                } );
								
                                jQuery('#<?php echo $meta_field['name']; ?>').val(valnames);
                            }
                        } );
						
                        itemlist.find('a.delete_item').live('click', function () {
                            jQuery('#<?php echo $meta_field['name']; ?>_container a.delete_item.activeitem').removeClass('activeitem');
                            jQuery(this).addClass('activeitem');
                            jQuery('#<?php echo $meta_field['name']; ?>_add').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_update').show();
                            jQuery('#<?php echo $meta_field['name']; ?>_delete').show();
                            jQuery('#<?php echo $meta_field['name']; ?>_cancel').show();
                            jQuery('#<?php echo $meta_field['name']; ?>_name').val(jQuery(this).html());
							
                            return false;
                        } );
						
                        jQuery('#<?php echo $meta_field['name']; ?>_add').click(function () {
                            var updatetext = jQuery('#<?php echo $meta_field['name']; ?>_name').val();
							
                            if (updatetext === '') {
                                alert('<?php _e('Enter feature text!', 'cmsmasters'); ?>');
                                
                                return false;
                            }
                            
                            itemlist.append('<a href="#" class="delete_item">' + updatetext + '</a>');
                            
                            var valnames = '';
                            
                            itemlist.find('a').each(function () {
                                if (valnames === '') {
                                    valnames = jQuery(this).html();
                                } else {
                                    valnames = valnames + ';' + jQuery(this).html();
                                }
                            } );
                            
                            jQuery('#<?php echo $meta_field['name']; ?>').val(valnames);
                            jQuery('#<?php echo $meta_field['name']; ?>_name').val('');
                            
                            return false;
                        } );
						
                        jQuery('#<?php echo $meta_field['name']; ?>_delete').click(function () {
                            jQuery('#<?php echo $meta_field['name']; ?>_container a.delete_item.activeitem').remove();
                            
                            var valnames = '';
                            
                            itemlist.find('a').each(function () {
                                if (valnames === '') {
                                    valnames = jQuery(this).html();
                                } else {
                                    valnames = valnames + ';' + jQuery(this).html();
                                }
                            } );
                            
                            jQuery('#<?php echo $meta_field['name']; ?>').val(valnames);
                            jQuery('#<?php echo $meta_field['name']; ?>_name').val('');
                            jQuery('#<?php echo $meta_field['name']; ?>_update').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_delete').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_cancel').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_add').show();
                            
                            return false;
                        } );
                        
                        jQuery('#<?php echo $meta_field['name']; ?>_update').click(function () {
                            var updatetext = jQuery('#<?php echo $meta_field['name']; ?>_name').val();
                            var valnames = '';
                            
                            jQuery('#<?php echo $meta_field['name']; ?>_container a.delete_item.activeitem').html(updatetext);
                            
                            itemlist.find('a').each(function () {
                                if (valnames === '') {
                                    valnames = jQuery(this).html();
                                } else {
                                    valnames = valnames + ';' + jQuery(this).html();
                                }
                            } );
                            
                            jQuery('#<?php echo $meta_field['name']; ?>').val(valnames);
                            jQuery('#<?php echo $meta_field['name']; ?>_container a.delete_item.activeitem').removeClass('activeitem');
                            jQuery('#<?php echo $meta_field['name']; ?>_name').val('');
                            jQuery('#<?php echo $meta_field['name']; ?>_update').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_delete').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_cancel').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_add').show();
                            
                            return false;
                        } );
						
                        jQuery('#<?php echo $meta_field['name']; ?>_cancel').click(function () {
                            jQuery('#<?php echo $meta_field['name']; ?>_container a.delete_item.activeitem').removeClass('activeitem');
                            jQuery('#<?php echo $meta_field['name']; ?>_name').val('');
                            jQuery('#<?php echo $meta_field['name']; ?>_update').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_delete').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_cancel').hide();
                            jQuery('#<?php echo $meta_field['name']; ?>_add').show();
                            
                            return false;
                        } );
                    } );
                </script>
                <p<?php echo $margin; ?> style="padding:0;">
                    <input type="hidden" value="<?php echo $value; ?>" name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" class="text_input" />
                </p>
                <?php
                break;
            case 'choose_icon':
            ?>
                <div style="overflow:hidden;">
                    <ul id="<?php echo $meta_field['name']; ?>_icons" class="iconslist">
                    <?php
                    $themeicons = array();
                    
                    if (is_dir(TEMPLATEPATH . '/images/theme_icons/')) {
                        if (opendir(TEMPLATEPATH . '/images/theme_icons/')) {
                            $open_dirs = opendir(TEMPLATEPATH . '/images/theme_icons/');
                            
                            while ((readdir($open_dirs)) != false) {
                                $themeicon = readdir($open_dirs);
                                
                                if ( 
									stristr($themeicon, '.png') != false || 
									stristr($themeicon, '.jpg') != false || 
									stristr($themeicon, '.jpeg') != false || 
									stristr($themeicon, '.gif') != false || 
									stristr($themeicon, '.ico') != false 
								) { 
                                    $themeicons[] = $themeicon;
                                }
                            }
                        }
                    }
                    
                    foreach ($themeicons as $themeicon) {
                        if ($themeicon != '') {
                            if ($value == get_template_directory_uri() . '/images/theme_icons/' . $themeicon) {
                                echo '<li><a href="' . get_template_directory_uri() . '/images/theme_icons/' . $themeicon . '" class="active_icon"><img src="' . get_template_directory_uri() . '/images/theme_icons/' . $themeicon . '" alt="' . $themeicon . '" width="24" height="24" /></a></li>';
                            } else {
                                echo '<li><a href="' . get_template_directory_uri() . '/images/theme_icons/' . $themeicon . '"><img src="' . get_template_directory_uri() . '/images/theme_icons/' . $themeicon . '" alt="' . $themeicon . '" width="24" height="24" /></a></li>';
                            }
                        }
                    }
                    ?>
                    </ul>
                    <div style="clear:both;"></div>
                    <br />
                    <a href="#" id="<?php echo $meta_field['name']; ?>_remove" style="padding-left:10px;"><?php _e('Disable Heading Icon', 'cmsmasters'); ?></a>
                    <br /><br />
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        jQuery('#<?php echo $meta_field['name']; ?>_icons li a').click(function () {
                            jQuery('#<?php echo $meta_field['name']; ?>_icons li a').removeClass('active_icon');
                            jQuery(this).addClass('active_icon');
                            jQuery('#<?php echo $meta_field['name']; ?>').val(jQuery(this).attr('href'));
                            
                            return false;
                        } );
						
                        jQuery('#<?php echo $meta_field['name']; ?>_remove').click(function () {
                            jQuery('#<?php echo $meta_field['name']; ?>_icons li a').removeClass('active_icon');
                            jQuery('#<?php echo $meta_field['name']; ?>').val('');
                            
                            return false;
                        } );
                    } );
                </script>
                <p<?php echo $margin; ?> style="padding:0;">
                    <input type="hidden" value="<?php echo $value; ?>" name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" class="text_input" />
                </p>
                <?php
                break;
            case 'hidden':
            ?>
                <p<?php echo $margin; ?>>
                    <input type="hidden" value="<?php echo $value; ?>" name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" class="text_input" /></p>
                <?php
                break;
            case 'spinner':
            ?>
                <p<?php echo $margin; ?>>
                    <input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" type="text" value="<?php echo $value; ?>" size="5" />
                    <script type="text/javascript">
                        jQuery(document).ready(function () {
                            jQuery('#<?php echo $meta_field['name']; ?>').spinner( {
                                min : <?php echo $meta_field['min']; ?>, 
                                max : <?php echo $meta_field['max']; ?>, 
                                step : <?php echo $meta_field['step']; ?>
                            } );
                        } );
                    </script>
                </p>
                <?php
                break;
            case 'spinner_null':
            ?>
                <p<?php echo $margin; ?>>
                    <input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" type="text" value="<?php echo $value; ?>" size="5" />
                    <script type="text/javascript">
                        jQuery(document).ready(function () {
                            jQuery('#<?php echo $meta_field['name']; ?>').spinner( {
                                min : <?php echo $meta_field['min']; ?>, 
                                max : <?php echo $meta_field['max']; ?>, 
                                step : <?php echo $meta_field['step']; ?>,
                                allowNull : true
                            } );
                        } );
                    </script>
                </p>
                <?php
                break;
            case 'color':
            ?>
                <div style="padding-top:7px;">
					<input size="10" name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" type="color" value="<?php echo $value; ?>" class="data_hex_color" style="background-position:repeat; float:left; margin-top:-3px;" data-hex="true" />
                    <div style="clear:both;"></div>
                    <p<?php echo $margin; ?> style="padding-bottom:8px;"></p>
                </div>
                <?php
                break;
            case 'bgs':
			?>
                <div id="<?php echo $meta_field['name']; ?>_container">
                    <div class="select_bgs" id="<?php echo $meta_field['name']; ?>_patterns_bgs" style="padding-top:10px;">
                        <span class="fl" style="display:block; width:140px; padding:1px 0 0;"><?php _e('Patterns', 'cmsmasters'); ?></span>
						<?php
						foreach (get_theme_bgs('pageBg') as $option) {
							if ($option->bg_type == 'bg_t') {
								if ($value != '') {
									$opt_id = str_replace(get_template_directory_uri() . '/images/bgs/', '', $value);
									
									if (strstr($opt_id, $option->bg_url) != false) {
										$selected = ' class="selected"';
									} else {
										$selected = '';
									}
								} else {
									if ($value == $option->bg_url) {
										$selected = ' class="selected"';
									} else {
										$selected = '';
									}
								}
								
								if ($option->bg_url != '') {
									echo "<a$selected href='" . get_template_directory_uri() . "/images/bgs/" . $option->bg_url . "' style='background-image:url(" . get_template_directory_uri() . "/images/bgs/" . $option->bg_thumb_url . ");'>&nbsp;</a>";
								}
							}
						}
						?>
                    </div>
                    <div class="select_bgs" id="<?php echo $meta_field['name']; ?>_transparents_bgs">
                        <span class="fl" style="display:block; width:140px; padding:1px 0 0;"><?php _e('Transparent Images', 'cmsmasters'); ?></span>
                        <?php
                        foreach (get_theme_bgs('pageBg') as $option) {
                            if ($option->bg_type == 'bg_t_i') {
                                if ($value != '') {
                                    $opt_id = str_replace(get_template_directory_uri() . '/images/bgs/', '', $value);
									
                                    if (strstr($opt_id, $option->bg_url) != false) {
                                        $selected = ' class="selected"';
                                    } else {
                                        $selected = '';
                                    }
                                } else {
                                    if ($value == $option->bg_url) {
                                        $selected = ' class="selected"';
                                    } else {
                                        $selected = '';
                                    }
                                }
								
                                if ($option->bg_url != '') {
                                    echo "<a$selected href='" . get_template_directory_uri() . "/images/bgs/" . $option->bg_url . "' style='background-image:url(" . get_template_directory_uri() . "/images/bgs/" . $option->bg_thumb_url . ");'>&nbsp;</a>";
                                }
                            }
                        }
                        ?>
                    </div>
                    <div class="select_bgs" id="<?php echo $meta_field['name']; ?>_images_bgs">
                        <span class="fl" style="display:block; width:140px; padding:1px 0 0;"><?php _e('Background Images', 'cmsmasters'); ?></span>
						<?php
						foreach (get_theme_bgs('pageBg') as $option) {
							if ($option->bg_type == 'bg_i') {
								if ($value != '') {
									$opt_id = str_replace(get_template_directory_uri() . '/images/bgs/', '', $value);
									
									if (strstr($opt_id, $option->bg_url) != false) {
										$selected = ' class="selected"';
									} else {
										$selected = '';
									}
								} else {
									if ($value == $option->bg_url) {
										$selected = ' class="selected"';
									} else {
										$selected = '';
									}
								}
								
								if ($option->bg_url != '') {
									echo "<a$selected href='" . get_template_directory_uri() . "/images/bgs/" . $option->bg_url . "' style='background-image:url(" . get_template_directory_uri() . "/images/bgs/" . $option->bg_thumb_url . ");'>&nbsp;</a>";
								}
							}
						}
						?>
                    </div>
                    <p<?php echo $margin; ?> style="padding:0;">
                        <input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" type="hidden" value="<?php echo $value; ?>" />
                    </p>
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        jQuery('#<?php echo $meta_field['name']; ?>_container a').click(function () {
                            jQuery('#<?php echo $meta_field['name']; ?>_container a').removeClass('selected');
                            jQuery(this).addClass('selected');
                            jQuery('#<?php echo $meta_field['name']; ?>').val(jQuery(this).attr('href'));
                			
                            return false;
                        } );
                    } );
                </script>
                </p>
                <?php
                break;
            case 'radio':
			?>
                <p<?php echo $margin; ?>>
                    <label style="display:block; padding-bottom:5px;">
						<input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" type="radio" value="<?php echo $meta_field['value']; ?>"<?php 
						if ($value == $meta_field['value'] || $value == '') {
							echo ' checked="checked"';
						} 
						?> style="margin-top:0;" /> 
						<?php echo $meta_field['desc']; ?>
					</label>
                    <label style="display:block; padding-bottom:5px;">
						<input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>_2" type="radio" value="<?php echo $meta_field['value2']; ?>"<?php 
						if ($value == $meta_field['value2']) {
							echo ' checked="checked"';
						} 
						?> style="margin-top:0;" /> 
						<?php echo $meta_field['desc2']; ?>
					</label>
                </p>
                <?php
                break;
            case 'radio_three':
			?>
                <p<?php echo $margin; ?>>
					<label style="display:block; padding-bottom:5px;">
						<input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" class="selector" type="radio" value="<?php echo $meta_field['value']; ?>"<?php 
						if ($value == $meta_field['value'] || $value == '') {
							echo ' checked="checked"';
						} ?> style="margin-top:0;" /> 
						<?php echo $meta_field['desc']; ?>
					</label>
                    <label style="display:block; padding-bottom:5px;">
						<input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>_2" class="selector" type="radio" value="<?php echo $meta_field['value2']; ?>"<?php 
						if ($value == $meta_field['value2']) {
							echo ' checked="checked"';
						} 
						?> style="margin-top:0;" /> 
						<?php echo $meta_field['desc2']; ?>
					</label>
                    <label style="display:block; padding-bottom:5px;">
						<input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>_3" class="selector" type="radio" value="<?php echo $meta_field['value3']; ?>"<?php 
						if ($value == $meta_field['value3']) {
							echo ' checked="checked"';
						} 
						?> style="margin-top:0;" /> 
						<?php echo $meta_field['desc3']; ?>
					</label>
				</p>
				<?php
				break;
			case 'radio_toggle':
			?>
                <p<?php echo $margin; ?>>
					<label style="display:block; padding-bottom:5px;">
						<input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" class="selector" type="radio" value="<?php echo $meta_field['value']; ?>"<?php 
						if ($value == $meta_field['value'] || $value == '') {
							echo ' checked="checked"';
						} ?> style="margin-top:0;" /> 
						<?php echo $meta_field['desc']; ?>
					</label>
                    <label style="display:block; padding-bottom:5px;">
						<input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>_2" class="selector" type="radio" value="<?php echo $meta_field['value2']; ?>"<?php 
						if ($value == $meta_field['value2']) {
							echo ' checked="checked"';
						} ?> style="margin-top:0;" /> 
						<?php echo $meta_field['desc2']; ?>
					</label>
                    <label style="display:block; padding-bottom:5px;">
						<input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>_3" class="selector" type="radio" value="<?php echo $meta_field['value3']; ?>"<?php 
						if ($value == $meta_field['value3']) {
							echo ' checked="checked"';
						} ?> style="margin-top:0;" /> 
						<?php echo $meta_field['desc3']; ?>
					</label>
					<label style="display:block; padding-bottom:5px;">
						<input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>_4" class="selector" type="radio" value="<?php echo $meta_field['value4']; ?>"<?php 
						if ($value == $meta_field['value4']) {
							echo ' checked="checked"';
						} ?> style="margin-top:0;" /> 
						<?php echo $meta_field['desc4']; ?>
					</label>
                </p>
				<?php
				break;
			case 'checkbox':
			?>
                <p<?php echo $margin; ?>>
                    <input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" type="checkbox" value="<?php echo $meta_field['value']; ?>"<?php 
					if ($existing_value == $meta_field['value']) {
						echo ' checked="checked"';
					} ?> /> 
					<?php echo $meta_field['desc']; ?>
                </p>
				<?php
				break;
			case 'select_order':
			?>
				<p<?php echo $margin; ?>>
					<select name="<?php echo $meta_field['name']; ?>">
						<option value="date"<?php 
							if ($existing_value == 'date') { 
								echo ' selected="selected"'; 
							} 
						?>><?php _e('Order by Date', 'cmsmasters'); ?>&nbsp;</option>
						<option value="menu_order"<?php 
							if ($existing_value == 'menu_order') { 
								echo ' selected="selected"'; 
							} 
						?>><?php _e('Menu Order', 'cmsmasters'); ?>&nbsp;</option>
						<option value="rand"<?php 
							if ($existing_value == 'rand') { 
								echo ' selected="selected"'; 
							} 
						?>><?php _e('Random Order', 'cmsmasters'); ?>&nbsp;</option>
					</select>
				</p>
				<?php
				break;
			case 'select_categ':
			?>
                <p<?php echo $margin; ?>>
                    <select name="<?php echo $meta_field['name']; ?>">
                        <option value=""<?php 
						if ($existing_value == '') {
							echo ' selected="selected"';
						} ?>><?php _e('Select a Blog Category', 'cmamasters'); ?>&nbsp;</option>
                        <?php
                        $categs = get_categories();
						
                        foreach ($categs as $categ) {
                            if ($existing_value == $categ->cat_ID) {
                                echo "<option value='$categ->cat_ID' selected='selected'>$categ->cat_name</option>\n";
                            } else {
                                echo "<option value='$categ->cat_ID'>$categ->cat_name</option>\n";
                            }
                        }
                        ?>
                    </select>
                </p>
				<?php
				break;
			case 'select_sidebar':
			?>
                <p<?php echo $margin; ?>>
                    <select name="<?php echo $meta_field['name']; ?>">
                        <option value=""<?php 
						if ($existing_value == '') {
							echo ' selected="selected"';
						} 
						?>><?php _e('Select a Sidebar', 'cmamasters'); ?>&nbsp;</option>
                        <?php
                        $sidebars = sidebar_generator_cmsmasters::get_sidebars();
						
                        if (is_array($sidebars) && !empty($sidebars)) {
                            foreach ($sidebars as $sidebar) {
                                if ($existing_value == $sidebar) {
                                    echo "<option value='$sidebar' selected='selected'>$sidebar</option>\n";
                                } else {
                                    echo "<option value='$sidebar'>$sidebar</option>\n";
                                }
                            }
                        }
                        ?>
                    </select>
                </p>
                <?php
                break;
			case 'select_post_type_categ':
			?>
                <p<?php echo $margin; ?>>
                    <select name="<?php echo $meta_field['name']; ?>">
                        <option value=""<?php 
						if ($existing_value == '') {
							echo ' selected="selected"';
						} 
						?>><?php echo __('Select a', 'cmsmasters') . ' ' . $meta_field['title']; ?>&nbsp;</option>
						<?php
						$pt_categs = get_terms($meta_field['post_type'], 'orderby=name&hide_empty=0');
						
						if (is_array($pt_categs) && !empty($pt_categs)) {
							foreach ($pt_categs as $pt_categ) {
								if ($existing_value == $pt_categ->slug) {
									echo "<option value='$pt_categ->slug' selected='selected'>$pt_categ->name</option>\n";
								} else {
									echo "<option value='$pt_categ->slug'>$pt_categ->name</option>\n";
								}
							}
						}
						?>
                    </select>
                </p>
				<?php
				break;
            case 'select_slider':
                global $wpdb, $shortname;
				
                $sliderManager = new cmsmsSliderManager();
			?>
				<p<?php echo $margin; ?>>
					<select name="<?php echo $meta_field['name']; ?>" style="min-width:200px;">
                <?php
                $sliders = $sliderManager->getSliders();
				
                if (!empty($sliders)) {
                    foreach ($sliders as $slider) {
                        if ($existing_value == $slider['slider_id']) {
                            echo '<option selected="selected" value="' . $slider[slider_id] . '">' . $slider[option_value] . '</option>';
                        } else {
                            echo '<option value="' . $slider[slider_id] . '">' . $slider[option_value] . '</option>';
                        }
                    }
                } else {
					echo '<option value="">' . __('You Need Create Slider', 'cmsmasters') . '</option>';
				}
                ?>
					</select>
				</p>
                <?php
                break;
            case 'select_numbercolumns_full':
			?>
                <p<?php echo $margin; ?>>
                    <select name="<?php echo $meta_field['name']; ?>">
                        <option value=""<?php 
						if ($existing_value == '') {
							echo ' selected="selected"';
						} 
						?>><?php _e('Select a Number of Columns', 'cmsmasters'); ?>&nbsp;</option>
                        <option value="one_block"<?php 
						if ($existing_value == 'one_block') {
							echo ' selected="selected"';
						} 
						?>><?php _e('One Column', 'cmsmasters'); ?>&nbsp;</option>
                        <option value="two_blocks"<?php 
						if ($existing_value == 'two_blocks') {
							echo ' selected="selected"';
						} 
						?>><?php _e('Two Columns', 'cmsmasters'); ?>&nbsp;</option>
                        <option value="three_blocks"<?php 
						if ($existing_value == 'three_blocks') {
							echo ' selected="selected"';
						} 
						?>><?php _e('Three Columns', 'cmsmasters'); ?>&nbsp;</option>
                        <option value="four_blocks"<?php 
						if ($existing_value == 'four_blocks') {
							echo ' selected="selected"';
						} 
						?>><?php _e('Four Columns', 'cmsmasters'); ?>&nbsp;</option>
                    </select>
                </p>
                <?php
                break;
            case 'select_numbercolumns_sidebar':
			?>
                <p<?php echo $margin; ?>>
                    <select name="<?php echo $meta_field['name']; ?>">
                        <option value=""<?php 
						if ($existing_value == '') {
							echo ' selected="selected"';
						} 
						?>><?php _e('Select a Number of Columns', 'cmsmasters'); ?>&nbsp;</option>
                        <option value="one_block"<?php 
						if ($existing_value == 'one_block') {
							echo ' selected="selected"';
						} 
						?>><?php _e('One Column', 'cmsmasters'); ?>&nbsp;</option>
                        <option value="two_blocks"<?php 
						if ($existing_value == 'two_blocks') {
							echo ' selected="selected"';
						} 
						?>><?php _e('Two Columns', 'cmsmasters'); ?>&nbsp;</option>
                        <option value="three_blocks"<?php 
						if ($existing_value == 'three_blocks') {
							echo ' selected="selected"';
						} 
						?>><?php _e('Three Columns', 'cmsmasters'); ?>&nbsp;</option>
                    </select>
                </p>
                <?php
                break;
            case 'album_numbercolumns_full':
                ?>
                <p<?php echo $margin; ?>>
                    <select name="<?php echo $meta_field['name']; ?>">
                        <option value=""<?php 
						if ($existing_value == '') {
							echo ' selected="selected"';
						} 
						?>><?php _e('Select a Number of Columns', 'cmsmasters'); ?>&nbsp;</option>
                        <option value="one_block"<?php 
						if ($existing_value == 'one_block') {
							echo ' selected="selected"';
						} 
						?>><?php _e('One Column', 'cmsmasters'); ?>&nbsp;</option>
                        <option value="two_blocks"<?php 
						if ($existing_value == 'two_blocks') {
							echo ' selected="selected"';
						} 
						?>><?php _e('Two Columns', 'cmsmasters'); ?>&nbsp;</option>
                        <option value="three_blocks"<?php 
						if ($existing_value == 'three_blocks') {
							echo ' selected="selected"';
						} 
						?>><?php _e('Three Columns', 'cmsmasters'); ?>&nbsp;</option>
                        <option value="four_blocks"<?php 
						if ($existing_value == 'four_blocks') {
							echo ' selected="selected"';
						} 
						?>><?php _e('Four Columns', 'cmsmasters'); ?>&nbsp;</option>
                    </select>
                </p>
                <?php
                break;
            case 'album_numbercolumns_sidebar':
			?>
                <p<?php echo $margin; ?>>
                    <select name="<?php echo $meta_field['name']; ?>">
                        <option value=""<?php 
						if ($existing_value == '') {
							echo ' selected="selected"';
						} 
						?>><?php _e('Select a Number of Columns', 'cmsmasters'); ?>&nbsp;</option>
                        <option value="one_block"<?php 
						if ($existing_value == 'one_block') {
							echo ' selected="selected"';
						} 
						?>><?php _e('One Column', 'cmsmasters'); ?>&nbsp;</option>
                        <option value="two_blocks"<?php 
						if ($existing_value == 'two_blocks') {
							echo ' selected="selected"';
						} 
						?>><?php _e('Two Columns', 'cmsmasters'); ?>&nbsp;</option>
                        <option value="three_blocks"<?php 
						if ($existing_value == 'three_blocks') {
							echo ' selected="selected"';
						} 
						?>><?php _e('Three Columns', 'cmsmasters'); ?>&nbsp;</option>
                    </select>
                </p>
                <?php
                break;
            case 'choose_pattern':
            ?>
                <div style="overflow:hidden;">
                    <ul id="<?php echo $meta_field['name']; ?>_patterns" class="patternslist">
                    <?php
                    $patterns = array('01.png', '02.png', '03.png', '04.png', '05.png', '06.png', '07.png', '08.png', '09.png', '10.png', '11.png', '12.png', '13.png', '14.png', '15.png', '16.png', '17.png', '18.png', '19.png', '20.png', '21.png', '22.png', '23.png', '24.png', '25.png', '26.png', '27.png', '28.png', '29.png', '30.png', '31.png', '32.png', '33.png');
                    
                    foreach ($patterns as $pattern) {
                        if ($pattern != '') {
                            if ($value == get_template_directory_uri() . '/images/patterns/' . $pattern) {
                                echo '<li><a href="' . get_template_directory_uri() . '/images/patterns/' . $pattern . '" style="background-image:url(' . get_template_directory_uri() . '/images/patterns/' . $pattern . '); display:block; width:24px; height:24px;" class="active_pattern"></a></li>';
                            } else {
                                echo '<li><a href="' . get_template_directory_uri() . '/images/patterns/' . $pattern . '" style="background-image:url(' . get_template_directory_uri() . '/images/patterns/' . $pattern . '); display:block; width:24px; height:24px;"></a></li>';
                            }
                        }
                    }
                    ?>
                    </ul>
                    <div style="clear:both;"></div>
                    <br />
                    <a href="#" id="<?php echo $meta_field['name']; ?>_remove" style="padding-left:10px;"><?php _e('Disable Pattern', 'cmsmasters'); ?></a>
                    <br /><br />
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        jQuery('#<?php echo $meta_field['name']; ?>_patterns li a').click(function () {
                            jQuery('#<?php echo $meta_field['name']; ?>_patterns li a').removeClass('active_pattern');
                            jQuery(this).addClass('active_pattern');
                            jQuery('#<?php echo $meta_field['name']; ?>').val(jQuery(this).attr('href'));
                            
                            return false;
                        } );
						
                        jQuery('#<?php echo $meta_field['name']; ?>_remove').click(function () {
                            jQuery('#<?php echo $meta_field['name']; ?>_patterns li a').removeClass('active_pattern');
                            jQuery('#<?php echo $meta_field['name']; ?>').val('');
                            
                            return false;
                        } );
                    } );
                </script>
                <p<?php echo $margin; ?> style="padding:0;">
                    <input type="hidden" value="<?php echo $value; ?>" name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" class="text_input" />
                </p>
                <?php
                break;
			}
			?>
        </div>
    <?php } ?>
    <input type="hidden" value="<?php echo wp_create_nonce(plugin_basename(__FILE__)); ?>" id="<?php echo $meta_box['noncename']; ?>_noncename" name="<?php echo $meta_box['noncename']; ?>_noncename" />
    <?php
}

function cmsmasters_save_meta($post_id) {
    $meta_boxes = cmsmasters_meta_boxes();
	
    global $wp;
	
    foreach ($meta_boxes as $meta_box) {
        if (isset($_POST['post_type']) && $_POST['post_type'] == 'post') {
            if (!wp_verify_nonce($_POST['cmsmasters_generalpost_noncename'], plugin_basename(__FILE__))) {
                return $post_id;
			}
        }
		
        if (isset($_POST['post_type']) && $_POST['post_type'] == 'page') {
            if (!wp_verify_nonce($_POST['cmsmasters_generalpage_noncename'], plugin_basename(__FILE__))) {
                return $post_id;
			}
        }
		
        if ($wp->query_vars["post_type"] == 'portfolio') {
            if (!wp_verify_nonce($_POST['cmsmasters_generalportfolio_noncename'], plugin_basename(__FILE__))) {
                return $post_id;
			}
        }
    }
	
    if (isset($_POST['post_type']) && $_POST['post_type'] == 'page') {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
		}
    } elseif ($wp->query_vars["post_type"] == 'portfolio') {
        if (!current_user_can('edit_portfolio', $post_id)) {
            return $post_id;
		}
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
		}
    }
	
    if (isset($_GET['post']) && isset($_GET['bulk_edit'])) {
        return $post_id;
	}
	
    foreach ($meta_boxes as $meta_box) {
        foreach ($meta_box['fields'] as $meta_field) {
            $current_data = get_post_meta($post_id, $meta_field['name'], true);
            $new_data = (isset($_POST[$meta_field['name']]) && $_POST[$meta_field['name']] != '') ? $_POST[$meta_field['name']] : '';
			
            if (isset($current_data) && $current_data != '') {
                if ($new_data == '') {
                    delete_post_meta($post_id, $meta_field['name']);
                } elseif ($new_data != $current_data) {
                    update_post_meta($post_id, $meta_field['name'], $new_data);
				}
            } elseif ($new_data != '') {
                add_post_meta($post_id, $meta_field['name'], $new_data, true);
            }
        }
    }
}

function cmsmasters_generalpost_meta_box() {
    cmsmasters_add_meta_box('generalpost');
}

function cmsmasters_generalpage_meta_box() {
    cmsmasters_add_meta_box('generalpage');
}

function cmsmasters_generalportfolio_meta_box() {
    cmsmasters_add_meta_box('generalportfolio');
}

function cmsmasters_bgtools_meta_box() {
    cmsmasters_add_meta_box('bgtools');
}

function cmsmasters_slidertools_meta_box() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function () { 
            jQuery('input[type="color"]').mColorPicker( { 
				imageFolder : '<?php echo get_template_directory_uri(); ?>/theme/administrator/images/mColorPicker/' 
			} ); 
        } );
    </script>
<?php if (version_compare(get_bloginfo('version'), '3.5') < 0) { ?>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/js/jquery-ui-1.8.12.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/js/spinner.js"></script>
<?php } else { ?>
	<style type="text/css">
		.postbox .ui-spinner {
			display:inline-block;
			position:relative;
			top:auto;
			left:auto;
		}
		
		.postbox .ui-spinner .ui-spinner-input {
			border-color:#b7b7b7;
			border-left:0;
			border-right:0;
			text-align:center;
			padding:7px 3px 6px;
			margin:0 30px;
			-webkit-border-radius:0;
			-moz-border-radius:0;
			border-radius:0;
		}
		
		.postbox .ui-spinner-button {padding:0;}
		
		.postbox .ui-spinner-button.ui-corner-tr {right:0;}
		
		.postbox .ui-spinner-button.ui-corner-br {left:0;}
		
		.postbox .ui-spinner-button .ui-icon-triangle-1-n, 
		.postbox .ui-spinner-button .ui-icon-triangle-1-s {color:transparent;}
	</style>
    <?php
	}
	
    cmsmasters_add_meta_box('slidertools');
}

function cmsmasters_headingtools_meta_box() {
    cmsmasters_add_meta_box('headingtools');
}

function cmsmasters_breadtools_meta_box() {
    cmsmasters_add_meta_box('breadtools');
}

function cmsmasters_seotools_meta_box() {
    cmsmasters_add_meta_box('seotools');
}

function cmsmasters_add_meta_boxes() {
    $meta_boxes = cmsmasters_meta_boxes();
	
    $i = 1;
	
    foreach ($meta_boxes as $meta_box) {
        if ($i == 1 || $i == 4 || $i == 5 || $i == 6 || $i == 7 || $i == 8) {
            add_meta_box($meta_box['id'], $meta_box['title'], $meta_box['function'], 'post', 'normal', 'high');
        }
		
        if ($i == 3 || $i == 4 || $i == 5 || $i == 6 || $i == 7 || $i == 8) {
            add_meta_box($meta_box['id'], $meta_box['title'], $meta_box['function'], 'portfolio', 'normal', 'high');
        }
		
        if ($i == 2 || $i == 4 || $i == 5 || $i == 6 || $i == 7 || $i == 8) {
            add_meta_box($meta_box['id'], $meta_box['title'], $meta_box['function'], 'page', 'normal', 'high');
        }
		
        $i++;
    }
	
    add_action('save_post', 'cmsmasters_save_meta');
}

add_action('admin_menu', 'cmsmasters_add_meta_boxes')

?>
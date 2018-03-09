<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Breadcrumbs
 * Changed by CMSMasters
 * 
 */


class simple_breadcrumb {
    var $opts;

    function simple_breadcrumb() {
        $this->opts = array(
            'before' => '&nbsp; ',
            'after' => ' &nbsp; ',
            'delimiter' => '/'
        );

        $markup = $this->opts['before'] . $this->opts['delimiter'] . $this->opts['after'];

        global $post, $options;

        echo '<div class="cont_nav"><a href="' . home_url() . '/" class="cms_home">' . __('Home', 'cmsmasters') . '</a>';
        
        if (!is_front_page()) {
            echo $markup;
        }

        $output = $this->simple_breadcrumb_case($post);

        if (is_page() || is_single()) {
            the_title('<span>', '</span>');
        } else {
            echo $output;
        }
        
        echo "</div>";
    }

    function simple_breadcrumb_case($der_post) {
        $markup = $this->opts['before'] . $this->opts['delimiter'] . $this->opts['after'];
        
        if (is_page()) {
            if ($der_post->post_parent) {
                $my_query = get_post($der_post->post_parent);
                $this->simple_breadcrumb_case($my_query);
                
                $link = '<a href="';
                $link .= get_permalink($my_query->ID);
                $link .= '">';
                $link .= '' . get_the_title($my_query->ID) . '</a>' . $markup;
                
                echo $link;
            }
            
            return;
        }

        if (is_single() && !is_attachment()) {
            $category = get_the_category();
            
            if (is_attachment()) {
                $my_query = get_post($der_post->post_parent);
                $category = get_the_category($my_query->ID);
                $ID = $category[0]->cat_ID;

                echo get_category_parents($ID, true, $markup, false);
                
                previous_post_link("%link $markup");
            } else {
                if (isset($category[0]->cat_ID)) {
                    $ID = $category[0]->cat_ID;

                    echo get_category_parents($ID, true, $markup, false);
                }
            }
            
            return;
        }

        if (is_category()) {
            $category = get_the_category();
            $i = $category[0]->cat_ID;
            $parent = $category[0]->category_parent;

            if ($parent > 0 && $category[0]->cat_name == single_cat_title('', false)) {
                echo get_category_parents($parent, true, $markup, false);
            }
            
            return single_cat_title('', false);
        }

        if (is_author()) {
            $curauth = get_userdatabylogin(get_query_var('author_name'));
            
            return __('Author', 'cmsmasters') . ': ' . $curauth->nickname;
        }

        if (is_tag()) {
            return __('Tag', 'cmsmasters') . ': ' . single_tag_title('', false);
        }

        if (is_search()) {
            return __('Search', 'cmsmasters');
        }

        if (is_year()) {
            return get_the_time('Y');
        }

        if (is_month()) {
            $k_year = get_the_time('Y');
            
            echo "<a href='" . get_year_link($k_year) . "'>" . $k_year . "</a>" . $markup;
            
            return get_the_time('F');
        }

        if (is_day() || is_time()) {
            $k_year = get_the_time('Y');
            $k_month = get_the_time('m');
            $k_month_display = get_the_time('F');
            
            echo "<a href='" . get_year_link($k_year) . "'>" . $k_year . "</a>" . $markup;
            echo "<a href='" . get_month_link($k_year, $k_month) . "'>" . $k_month_display . "</a>" . $markup;

            return get_the_time('jS (l)');
        }
		
		if (taxonomy_exists('pt-sort-categ') || taxonomy_exists('pt-tags')) {
            $categories = get_the_terms(get_the_ID(), 'pt-sort-categ');
			
			foreach ($categories as $category) {
				$i = $category->term_id;
				$name = $category->name;
				$parent = $category->parent;
			}
			
            if ($parent > 0 && $name == single_cat_title('', false)) {
				$parents = array();
				
				while ($category->parent != 0) {
					$category = get_term($category->parent, 'pt-sort-categ');
					
					if ($category != $i) { 
						$parents[] = $category;
					}
				}
				
				if (count($parents) > 1) {
					$parents = array_reverse($parents);
				}
				
				foreach ($parents as $par) {
					echo '<a href="' . get_term_link($par->slug, 'pt-sort-categ') . '">' . $par->name . '</a>' . $markup;
				}
            }
            
            return single_cat_title('', false);
		}
    }
}

?>
<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Slider Manager
 * Created by CMSMasters
 * 
 */


class cmsmsSliderManager {
    private $data;
    private $shortname;
	
    public function __construct() {
        global $wpdb, $shortname;
		
        $this->data = $wpdb;
        $this->shortname = $shortname;
        $this->data->show_errors();
    }
	
    public function insertSlider($id, $option_name, $option_value) {
        $res = $this->data->query($this->data->prepare("INSERT INTO " . $this->data->prefix . $this->shortname . "_sliders (slider_id, slide_id, option_name, option_value) VALUES (%d, %d, %s, %s)", array($id, '', $option_name, $option_value)));
		
        return $res;
    }
	
    public function insertSlide($id, $slide_id, $option_name, $option_value) {
        $res = $this->data->query($this->data->prepare("INSERT INTO " . $this->data->prefix . $this->shortname . "_sliders (slider_id, slide_id, option_name, option_value) VALUES (%d, %d, %s, %s)", array($id, $slide_id, $option_name, $option_value)));
		
        return $res;
    }
	
    public function updateSlide($id, $slide_id, $option_name, $option_value) {
        $res = $this->data->query($this->data->prepare("UPDATE " . $this->data->prefix . $this->shortname . "_sliders SET option_value = %s WHERE slider_id = %d AND slide_id = %d AND option_name = %s", array($id, $slide_id, $option_name, $option_value)));
		
        return $res;
    }
	
    public function getSliders() {
        $res = $this->data->get_results("SELECT DISTINCT slider_id, option_name, option_value FROM " . $this->data->prefix . $this->shortname . "_sliders WHERE option_name='slider_name'", ARRAY_A);
		
        return $res;
    }
	
    public function getSlider($id) {
        $arr = array();
		$res = $this->data->get_results($this->data->prepare("SELECT slide_id, option_name, option_value FROM " . $this->data->prefix . $this->shortname . "_sliders WHERE slider_id=%d ORDER BY slide_id ASC", $id), ARRAY_A);
		foreach ($res as $option) {
			if ($option['slide_id'] == 0) {
				$arr['slider'][$option['option_name']] = stripslashes($option['option_value']);
			} else {
				$arr['slider']['slides']['slide' . $option['slide_id']][$option['option_name']] = stripslashes($option['option_value']);
			}
		}
		
        return $arr;
    }
	
    public function deleteSlider($id) {
        $res = $this->data->query($this->data->prepare("DELETE from " . $this->data->prefix . $this->shortname . "_sliders WHERE slider_id=%d", $id));
		
        return $res;
    }
	
    public function getSlides() {
        $res = $this->data->get_results("SELECT DISTINCT slider_id, option_name, option_value FROM " . $this->data->prefix . $this->shortname . "_sliders WHERE option_name='slide_name'", ARRAY_A);
		
        return $res;
    }
	
    public function getUniqueSliderId() {
        $array = array();
		
        $res = $this->data->get_results("SELECT DISTINCT slider_id FROM " . $this->data->prefix . $this->shortname . "_sliders", ARRAY_A);
		
        if (!empty($res)) {
            foreach ($res as $key=>$value) {
                $array[$key] = $value['slider_id'];
            }
			
            return max($array) + 1;
        } else {
            return 0;
        }
    }
	
    public function getUniqueSlideId($sliderId) {
        $res = $this->data->get_results("SELECT COUNT(DISTINCT slide_id) FROM " . $this->data->prefix . $this->shortname . "_sliders WHERE slider_id=$sliderId", ARRAY_A);
		
        return $res['COUNT(DISTINCT slide_id)'];
    }
}

?>
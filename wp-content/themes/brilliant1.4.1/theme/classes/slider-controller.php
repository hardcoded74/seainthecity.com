<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Slider Manager Controller
 * Created by CMSMasters
 * 
 */


class cmsmsSliderController {
    private $control;
    private $status;
	
    public function __construct() {
        $res = '';
        $this->control = new cmsmsSliderManager();
		
        if (isset($_POST['action']) && $_POST['action'] == 'deleteSlider') {
            $id = (int) $_POST['id'];
            $res = $this->control->deleteSlider($id);
        }
		
        if (isset($_POST['action']) && $_POST['action'] == 'updateSlider') {
            $id = (int) $_POST['id'];
            $res = $this->control->deleteSlider($id);
            $this->insertSlider($id);
        }
		
        if (isset($_POST['action']) && $_POST['action'] == 'getSlider') {
            $id = (int) $_POST['id'];
            $res = $this->control->getSlider($id);
			
            echo json_encode($res);
        }
		
        if (isset($_POST['action']) && $_POST['action'] == 'insertSlider') {
            $this->insertSlider();
        }
		
        if (isset($_POST['action']) && $_POST['action'] == 'getSliders') {
            $res = $this->control->getSliders();
			
            echo json_encode($res);
        }
		
        echo $this->status;
    }
	
    public function insertSlider($id = null) {
        $res = array();
        $counter = 1;
		
        if ($id == null) {
            $sliderId = $this->control->getUniqueSliderId();
        } else {
            $sliderId = $id;
        }
		
        foreach ($_POST['slider'] as $option_name => $option_value) {
            if ($option_name == 'slides') {
                foreach ($option_value as $slides) {
                    foreach ($slides as $slide_option_name => $slide_option_value) {
                        $res[] = $this->control->insertSlide($sliderId, $counter, $slide_option_name, $slide_option_value);
                    }
					
                    $counter++;
                }
            } else {
                $res[] = $this->control->insertSlider($sliderId, $option_name, $option_value);
            }
        }
		
        if (in_array(1, $res)) {
            $this->status = "{ 'status' : 'success' }";
        } else {
            $this->status = "{ 'status' : 'dberror' }";
        }
    }
}

?>
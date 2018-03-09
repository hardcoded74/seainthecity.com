<?php

/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

function authnet_textbox($name, $value="", $size=15) {
   if (get_option($name)) { $value = get_option($name); }

   ?>
   <input type="text" id="<?php echo $name ?>" name="<?php echo $name ?>" size="<?php echo $size ?>" value="<?php echo $value ?>" />
   <?php
}

function authnet_radio($name, $values=array(), $selected=false, $include_break = false) {
   if (get_option($name)) { $selected = get_option($name); }
	foreach ($values as $option_name => $option_value) {
   ?>
   <?php echo $option_name; ?> <input id="<?php echo $name ?>" type="radio" name="<?php echo $name ?>" value="<?php echo $option_value ?>" <?php echo ($option_value==$selected) ? "checked":""; ?> />
   <?php echo ($include_break) ? "<br />":""; ?>
   <?php
	}
}

function authnet_colorpickertextbox($name, $value="", $size=15) {
   if (get_option($name)) { $value = get_option($name); }

   ?>
   <input id="<?php echo $name ?>" type="text" class="color" name="<?php echo $name ?>" size="<?php echo $size ?>" value="<?php echo $value ?>" />
   <?php
}

function authnet_textarea($name, $value="") {
   if (get_option($name)) { $value = get_option($name); }

   ?>
   <textarea id="<?php echo $name ?>" name="<?php echo $name ?>" cols="50" rows="5"><?php echo $value ?></textarea>
   <?php
}

/*
   Checkbox example: If the option is set, draw the checkbox as checked="checked" ...
   otherwise, just draw the regular checkbox.
*/
function authnet_checkbox($name) {
   ?>
   <?php if (get_option($name)): ?>
   <input id="<?php echo $name ?>" type="checkbox" name="<?php echo $name ?>" checked="checked" />
   <?php else: ?>
   <input id="<?php echo $name ?>" type="checkbox" name="<?php echo $name ?>" />
   <?php endif; ?>
   <?php
}

?>
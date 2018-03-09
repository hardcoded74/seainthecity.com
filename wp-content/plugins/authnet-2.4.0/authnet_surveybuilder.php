<?php

/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

if ('authnet_settings.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('<h2>'.__('Direct File Access Prohibited','authnet').'</h2>');

$surveys = array();
$surveys = json_decode(get_option("authnet_surveys"));

$plugindir = dirname(plugin_basename(__FILE__));
$authnet_basedir = get_bloginfo ('wpurl') . '/wp-content/plugins/'.$plugindir;

if($_GET['cmd'] == 'DeleteSurvey') {

	$surveyName = stripslashes(stripslashes(trim($_GET['surveyName'])));
	$surveyName = mysql_real_escape_string($surveyName);
	
	$newsurveys = array();
	if($surveyName != '') {
		foreach($surveys as $survey) {
			if($survey->surveyName != $surveyName) {
				$newsurveys[] = $survey;
			}
		}
		update_option("authnet_surveys", json_encode($newsurveys));
	}
}
if($_GET['cmd'] == 'DeleteItem') {
	
	$surveyName = stripslashes(stripslashes(trim($_GET['surveyName'])));
	$surveyName = mysql_real_escape_string($surveyName);
	
	$itemName = stripslashes(stripslashes(trim($_GET['itemName'])));
	$itemName = mysql_real_escape_string($itemName);
	
	
	$newitems = array();
	if($surveyName != '' && $itemName != '' ) {
		$survey = get_survey($surveyName, $surveys);
		$surveyItems = $survey->surveyItems;
		foreach($surveyItems as $surveyItem) {
			if($surveyItem->itemName != $itemName) {
				$newitems[] = $surveyItem;
			}
		}
		
		$survey->surveyItems = $newitems;
		$surveys = update_survey($survey, $surveys);
		update_option("authnet_surveys", json_encode($surveys));
	}
        
        // clearing variables after deleting
        $surveyName = $itemName = "";
        
} elseif($_POST['cmd'] == 'UpdateSurvey') {
	
	$surveyName = stripslashes(stripslashes(trim($_POST['surveyName'])));
	$surveyName = mysql_real_escape_string($surveyName);
	
	$oldsurveyName = stripslashes(stripslashes(trim($_POST['oldsurveyName'])));
	$oldsurveyName = mysql_real_escape_string($oldsurveyName);
	
	if($surveyName == ''){
		$error1 = "Survey Name cannot be left blank.";
	} else {
		if(check_surveyName($oldsurveyName, $surveys)){
			$survey = get_survey($oldsurveyName, $surveys);
			$survey->surveyName = $surveyName;
			update_option("authnet_surveys", json_encode($surveys));
                        
			// Add or update survey default option
			if($_POST['authnet_default_survey'] == true) {
				if(!(get_option('authnet_default_survey'))) {
					add_option( 'authnet_default_survey', $surveyName, '', 'yes' );
				} else {
					update_option('authnet_default_survey', $surveyName );
				}
			}
             }
	}
}
elseif($_POST['cmd'] == 'AddSurvey') {

	$surveyName = stripslashes(stripslashes(trim($_POST['surveyName'])));
	$surveyName = mysql_real_escape_string($surveyName);
	
	if($surveyName == '') {
		$error1 = "Survey Name cannot be left blank.";
	} elseif(check_surveyName($surveyName, $surveys)) {
		$error1 = "Survey Name already exists.";
	} else {
		$survey['surveyName'] = $surveyName;
		$survey['surveyItems'] = Array();
		$surveys[] = $survey;
		update_option("authnet_surveys", json_encode($surveys));
		// Add or update survey default option
		if($_POST['authnet_default_survey'] == true) {
			if(!(get_option('authnet_default_survey'))) {
			add_option( 'authnet_default_survey', $surveyName, '', 'yes' );
			} else {
			update_option('authnet_default_survey', $surveyName );
			}
		}
        
	}
} elseif($_POST['cmdItem'] == "posted") {

	$surveyName = stripslashes(stripslashes(trim($_POST['surveyName'])));
	$surveyName = mysql_real_escape_string($surveyName);
	
	$itemName = stripslashes(stripslashes(trim($_POST['itemName'])));
	$itemName = mysql_real_escape_string($itemName);
	
	$old_survey_item_name = stripslashes(stripslashes(trim($_POST['old-survey-item-name'])));
	$old_survey_item_name = mysql_real_escape_string($old_survey_item_name);
	
	$itemValueType = mysql_real_escape_string(trim($_POST['itemValueType']));	
	$itemRequired = mysql_real_escape_string(trim($_POST['itemRequired']));
	
	if($surveyName == '') {
			$error = 'Please select a Survey.';
	} elseif($itemName == '') {
			$error = 'Item name should not be left blank.';
	} else {		
		$itemValueType = $_POST['itemValueType'];	
		
		if($itemValueType == 'select') {
			$options1 = $_POST['txt'];
		}
		elseif($itemValueType == 'radio') {
			$options1 = $_POST['txt'];
		}
		
		for($i = 0; $i < count($options1)+1; $i++) {
			if($options1[$i] != '' ){
				$itemOptions[] = $options1[$i];
			}
		}

		$survey_item['itemName'] = $itemName;
		$survey_item['itemValueType'] = $itemValueType;
		$survey_item['itemRequired'] = $itemRequired;
		$survey_item['itemOptions'] = $itemOptions;
		
		$survey = get_survey($surveyName, $surveys);
		
		$surveyItems = $survey->surveyItems;
		
		$surveyItems = update_surveyItem($old_survey_item_name, $survey_item, $surveyItems);
		
		$survey->surveyItems = $surveyItems;
		
		$surveys = update_survey($survey, $surveys);
		
		update_option("authnet_surveys", json_encode($surveys));

		$success = true;
	}
		// after update, clearing all the values. 
		$surveyName = $itemName = $itemValueType = $itemRequired = $itemOptions = ""; 
}

$surveys = json_decode(get_option("authnet_surveys"));

if($_GET['cmd'] == 'EditSurvey') {
	$savemode = 'UpdateSurvey';
	
	$msurveyName = stripslashes(stripslashes(trim($_GET['surveyName'])));
	#$msurveyName = mysql_real_escape_string($msurveyName);
	if( isset($_GET['defalutSurvey']) && $_GET['defalutSurvey'] != '' && $_GET['defalutSurvey']== 'Yes') {
		$defaultChecked= 'checked';
	}   
} else {
	$savemode = 'AddSurvey';
}
?>
<link rel="stylesheet" type="text/css" href="<?php echo get_plugin_url_authnet(); ?>/style.css" media="all" />

	<div class="wrap" style="width: 700px;">
		<h2>Authorize.net for WordPress Survey Builder</h2>
<?php
		 // Display warning message if plugin is being used without SSL installed
		echo get_use_ssl_warning('admin_page');
?>
		<div class="Settings-wrap">
			<div class="info-box">
				<div class="info-content">
                    Checkout surveys are a flexible way to ask your customer/donor for additional information when they checkout. You can use the forms below build custom surveys that will be available during checkout. After you create a survey here, you can associate it with a Subscription or identify it as the donation survey on the other settings pages.
				</div>
				<div class="Owner">
                    This plugin was created by <a href="http://www.danielwatrous.com">Daniel Watrous</a>. Step by step videos are available on the <a href="http://www.danielwatrous.com/authorizenet-for-wordpress/plugin-training">training page</a>.
				</div>
			</div>
			<div class="settings-header">
				<ul>
					<li>
						<span>Survey Builder</span>
					</li>
				</ul>
			</div>
			<div class="settings-container">
				<form name="frmsurveys" method="post" action="?page=authnet_render_surveybuilder">
					<div id="add-edit-survey">
						
						<h3>Add/Edit Survey:</h3>
						
						<input type="hidden" name="cmd" value="<?php echo $savemode; ?>" />
						<input type="hidden" name="oldsurveyName" value="<?php echo $msurveyName; ?>" />
						<label for="authnet_surveyname">Survey Name*: </label>
						<input id="authnet_surveyname" type="text" name="surveyName" value="<?php echo $msurveyName; ?>" size="30"/><br />
						 <small id="survey-invalid"> <?php if($error1) echo $error1; ?> </small> 
						<label for="authnet_default_survey">Default Survey:</label>
						<input id="authnet_default_survey" type="checkbox" name="authnet_default_survey" <?php echo $defaultChecked; ?>>
						<br />
						<input id="saveSurvey" type="submit" value="Save"/>
					</div>
					<br />
					<div id="surveys">
						<h3>Surveys:</h3>
					
						<table class="widefat">
							<thead>
								<tr>
									<th scope="col">Surveys &amp; Survey Item</th> 
									<th scope="col">Actions</th>
								</tr>
<?php
							if ($surveys) {
								foreach($surveys as $survey) {
?>
									<tr>
										<td>
											<b><?php echo (get_option('authnet_default_survey') == $survey->surveyName)? stripslashes($survey->surveyName) .'  (Default)' : stripslashes($survey->surveyName);?></b>
										</td>
										<td>
											<a href="?page=authnet_render_surveybuilder&cmd=EditSurvey&surveyName=<?php echo $survey->surveyName; ?>&defalutSurvey=<?php echo (get_option('authnet_default_survey') == $survey->surveyName)? 'Yes' : 'No'; ?>">
											<img src="<?php echo $authnet_basedir; ?>/images/b_edit.png" width="16" height="16" title="Edit Survey" />
											</a>        
											<img src="<?php echo $authnet_basedir; ?>/images/b_drop.png" width="16" height="16" title="Delete Survey" style="cursor:pointer" onclick="javascript:delsurvey('<?php echo $survey->surveyName; ?>');" />
										</td>
									</tr>
<?php
									if(is_array($survey->surveyItems)) {
										foreach($survey->surveyItems as $survey_item) {
											$item_name = $survey_item->itemName;
?>
											<tr>
												<td>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo stripslashes($item_name); ?></td>
												<td>
													<a href="?page=authnet_render_surveybuilder&cmd=EditItem&surveyName=<?php echo stripslashes($survey->surveyName); ?>&itemName=<?php echo stripslashes($item_name); ?>"><img src="<?php echo $authnet_basedir; ?>/images/b_edit.png" width="16" height="16" title="Edit Survey Item" /></a>
														<img src="<?php echo $authnet_basedir; ?>/images/b_drop.png" width="16" height="16" title="Delete Survey Item" style="cursor:pointer"
																onclick="javascript:delsurveyitem('<?php echo $survey->surveyName; ?>','<?php echo $item_name;  ?>');" />
												</td>
											</tr>
<?php			
										}
									}
								}
							}
?>
						</table>
					</div>
				</form>
				<br />
				<script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
				<script language="javascript">
					$(document).ready(function(){
						if($('#itemValueType').val() == 'select') {
							$('#attr').show();
						}
						else{
							$('#attr').hide();
						}
						$('#dflt').show();
						$('#itemValueType').change(function() {
							$('#attr').hide();
							$('#dflt').show();
							if($(this).val() == 'select' ) {
								$('#attr').show();
							}
						});
					});

				var func = {
					validate:function (el) {
						if (el.itemName.value=='') {
							alert ('Item name required.');
							el.itemName.focus();
							return false;
						}
					}
				}
				function addRow(tableID) {

					var table = document.getElementById(tableID);

					var rowCount = table.rows.length;
					var row = table.insertRow(rowCount);

					var cell1 = row.insertCell(0);
					var element1 = document.createElement("input");
					element1.type = "checkbox";
					cell1.appendChild(element1);

					var cell1 = row.insertCell(1);
					var element2 = document.createElement("input");
					element2.type = "text";
					element2.id = "txt";
					element2.name = "txt[]";
					cell1.appendChild(element2);

				}

				function deleteRow(tableID) {
					try {
					var table = document.getElementById(tableID);
					var rowCount = table.rows.length;

					for(var i=0; i<rowCount; i++) {
						var row = table.rows[i];
						var chkbox = row.cells[0].childNodes[0];
						if(null != chkbox && true == chkbox.checked) {
							table.deleteRow(i);
							rowCount--;
							i--;
						}

					}
					}catch(e) {
						alert(e);
					}
				}


				function delsurvey(surveyname){
					cf = confirm("Are you sure you want to delete this survey and its items?");
					
					if(cf){
						window.location.href= "?page=authnet_render_surveybuilder&cmd=DeleteSurvey&surveyName="+encodeURIComponent(surveyname);
					}
					return false;
				}
				function delsurveyitem(surveyname, itemname){
					cf = confirm("Are you sure you want to delete this survey item?");
					
					if(cf){
						window.location.href= "?page=authnet_render_surveybuilder&cmd=DeleteItem&surveyName="+encodeURIComponent(surveyname)+"&itemName="+encodeURIComponent(itemname);
					}
					return false;
				}
				</script>
<?php
					if($_GET['cmd'] == 'EditItem') {
						$ItemToEdit = $_GET['itemName'];
						$surveyName = $_GET['surveyName'];
						if($surveyName && $ItemToEdit){
							$thesurvey = get_survey($surveyName, $surveys);
							$surveyItems = $thesurvey->surveyItems;
							$thesurveyItem = get_surveyItem($ItemToEdit, $surveyItems);
							
							$itemName = $thesurveyItem->itemName;
							$itemValueType = $thesurveyItem->itemValueType;
							$itemRequired = $thesurveyItem->itemRequired;
							$itemOptions = $thesurveyItem->itemOptions;
						}
					}
?>
					<form method="post" target="_self" action="?page=authnet_render_surveybuilder">

						<div it="add-edit-survey-items">
							<h3>Add / Edit Survey Items:</h3>

							<input type="hidden" name="cmdItem" value="posted" />
							<input type="hidden" name="old-survey-item-name" value="<?php echo $itemName; ?>" />

							<label for="authnet_surveyname">Survey: </label>
							<select id="authnet_surveyname" name="surveyName">
	<?php
								foreach($surveys as $survey) {
	?>
									<option value="<?php echo $survey->surveyName; ?>" <?php echo ($survey->surveyName == $surveyName)?"selected":""; ?> ><?php echo stripslashes($survey->surveyName); ?></option>
	<?php		
								}
	?>
							</select><br />
							<label for="authnet_fieldname">Survey Item: </label>
							<input id="authnet_fieldname" type="text" value="<?php echo stripslashes($itemName); ?>" name="itemName" /><br />

							<label for="authnet_required">Field Type: </label>
								<select name="itemValueType" id="itemValueType">
								  <option value="text" <?php echo ($itemValueType == 'text')?"selected":""; ?> >Text Field</option>
								  <option value="textarea" <?php echo ($itemValueType == 'textarea')?"selected":""; ?>>Text Area</option>
								  <option value="select" <?php echo ($itemValueType == 'select')?"selected":""; ?>>Select</option>
								</select><br />
									
							<div id="attr">
								<label for="authnet_required">Values: </label>
								<input type="button" value="Add" onClick="addRow('dataTable')" />
								<input type="button" value="Delete" onClick="deleteRow('dataTable')" /><br />
								
								<label for="authnet_required">&nbsp;</label>
								<table id="dataTable" border="0">
<?php
								if(count($itemOptions) > 0) {
									for($i = 0; $i < count($itemOptions)+1; $i++) {
?>            
									  <tr>
										<td><input type="checkbox" name="chk"/></td>
										<td><input type="text" name="txt[<?php echo $i; ?>]" id="txt" value="<?php echo $itemOptions[$i]; ?>" /></td>
									  </tr>
<?php
									}
								} else {
?>
									<tr>
										<td><input type="checkbox" name="chk"/></td>
										<td><input type="text" name="txt[]" id="txt" /></td>
									</tr>
<?php
								}
?>
								</table>
							</div>

							<label for="authnet_required">Required: </label>
<?php
							if($itemRequired == '') $itemRequired = 'No';
?>
								<input id="authnet_required" type="radio" name="itemRequired" value="Yes" <?php echo ($itemRequired == 'Yes')?'checked="checked"':""; ?> >Yes
								<input id="authnet_required" type="radio" name="itemRequired" value="No" <?php echo ($itemRequired == 'No')?'checked="checked"':""; ?> >No
								<br />

								<label>&nbsp;</label>
								<input type="hidden" value="add" name="action" />
								<input type="hidden" value="1" name="formid" />
								<input type="hidden" value="" name="id" />
								<input type="submit" value="Submit" name="submit" /><br />
						</div>
					</form>
			</div>
		</div>
	</div>
<?php
	function check_surveyName($surveyName, $surveys){
		$found = false;
		if ($surveys) {
			foreach($surveys as $survey){
				if($survey->surveyName == $surveyName){
					$found = true;
					break;
				}
			}
		}
		return $found;
	}

	function get_survey($surveyName, $surveys){
		$survey = '';
		foreach($surveys as $survey){
			if($survey->surveyName == $surveyName){
				$found = true;
				break;
			}
		}
		if($found){
			return $survey;
		}
		else{
			return '';
		}
	}

	function find_itemName($itemName, $surveyItems){
		$found = false;
		foreach($surveyItems as $surveyItem){
			if($surveyItem->itemName == $itemName){
				$found = true;
				break;
			}
		}
		return $found;
	}

	function update_survey($newsurvey, $surveys){
		$newsurveys = array();
		foreach($surveys as $survey){
			if($survey->surveyName == $newsurvey->surveyName){
				$newsurveys[] = $newsurvey;
				$updated = true;
			}
			else{
				$newsurveys[] = $survey;
			}
		}
		if(!$updated){
			$newsurveys[] = $newsurvey;
		}
		return $newsurveys;
	}


	function update_surveyItem($old_survey_item_name, $newitem, $surveyItems) {
		
		$newsurveyItems = array();
		
		foreach( $surveyItems as $survey_item ) {
			
			if( $survey_item->itemName == $old_survey_item_name ) {
				
				$newsurveyItems[] = $newitem;
				$updated = true;
			} else {
				$newsurveyItems[] = $survey_item;
			}
		}
		if( !$updated ) {
			
			$newsurveyItems[] = $newitem;
		}
		
		return $newsurveyItems;
	}

	function get_surveyItem($itemName, $surveyItems){
		$found = false;
		foreach($surveyItems as $surveyItem){
			if($surveyItem->itemName == $itemName){
				$found = true;
				break;
			}
		}
		if($found){
			return $surveyItem;
		}
		else{
			return '';
		}
	}
?>
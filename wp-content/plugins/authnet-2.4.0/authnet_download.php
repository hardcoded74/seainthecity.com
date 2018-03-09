<?php

/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

$wp_did_header = true;

require_once('AuthnetDownloadReport.php');

if (isset($_POST['submittxdl']) && isset($_POST['start_date']) && isset($_POST['end_date']) && isset($_POST['delimiter'])) {
	$downloadReport = new AuthnetDownloadReport();
	// Get csv report
	if ($_POST['delimiter'] == 'CSV') {
		$downloadReport->getCSVDownloadReportByDate($_POST['start_date'], $_POST['end_date']);
	} else if ($_POST['delimiter'] == 'TAB') { // Get tab report
		$downloadReport->getTABDownloadReportByDate($_POST['start_date'], $_POST['end_date']);
	}
	exit;
}

?>

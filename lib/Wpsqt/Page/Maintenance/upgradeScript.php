<?php

	/**
	 * Handles the upgrading of the plugin.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

if ($needUpdate == '1') {
	if (version_compare($oldVersion, '2.1') <= 0) {
		$objUpgrade = new Wpsqt_Upgrade;
		$objUpgrade->getUpdate(0);
		$objUpgrade->execute();
	}
	switch($oldVersion) {
		case '2.4.3':
		echo '<h4>Updating to 2.5</h4>';
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_RESULTS."` ADD `pass` BOOLEAN NOT NULL");
		echo '<p>Added the `pass` column</p>';
		case '2.5':
		echo '<h4>Updating to 2.5.1</h4>';
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_QUIZ_SURVEYS."` DEFAULT  CHARACTER SET utf8 COLLATE utf8_general_ci");
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_SECTIONS."` DEFAULT  CHARACTER SET utf8 COLLATE utf8_general_ci");
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_QUESTIONS."` DEFAULT  CHARACTER SET utf8 COLLATE utf8_general_ci");
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_FORMS."` DEFAULT  CHARACTER SET utf8 COLLATE utf8_general_ci");
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_RESULTS."` DEFAULT  CHARACTER SET utf8 COLLATE utf8_general_ci");
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_SURVEY_CACHE."` DEFAULT  CHARACTER SET utf8 COLLATE utf8_general_ci");
		$wpdb->query("ALTER TABLE  `".WPSQT_TABLE_QUIZ_SURVEYS."` CHANGE  `name`  `name` VARCHAR( 512 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
		echo '<p>Updated all columns to use UTF8</p>';
		case '2.5.1':
		echo '<h4>Updating to 2.5.2</h4>';
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_RESULTS."` ADD `datetaken` VARCHAR(255) NOT NULL AFTER `item_id`");
		case '2.5.2':
		echo '<h4>Updating to 2.5.3</h4>';
		case '2.5.3':
		echo '<h4>Updating to 2.5.4</h4>';
		case '2.6.2':
		echo '<h4>Updating to 2.6.3</h4>';
		$wpdb->query("ALTER TABLE  `".WPSQT_TABLE_QUIZ_SURVEYS."` CHANGE  `name`  `name` VARCHAR( 512 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_RESULTS."` ADD `datetaken` VARCHAR(255) NOT NULL AFTER `item_id`");
		case '2.6.6':
		echo '<h4>Updating to 2.6.7</h4>';
		update_option("wpsqt_required_role", '');
	}
	echo '<p><strong>Updated. Return to the <a href="'.WPSQT_URL_MAIN.'">main page</a> to ensure the notice disappears</strong></p>';
	update_option('wpsqt_version',WPSQT_VERSION);

} else {
	echo '<p>You are up to date.</p>';
}
update_option("wpsqt_update_required",false);
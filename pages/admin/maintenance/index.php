<div class="wrap">
	
	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Maintenance</h2>	
	
	<div id="nav">
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab nav-tab-active" href="<?php echo WPSQT_URL_MAINENTANCE; ?>">Status</a>
			<a class="nav-tab" href="<?php echo WPSQT_URL_MAINENTANCE; ?>&section=backup">Backup</a>
			<a class="nav-tab" href="<?php echo WPSQT_URL_MAINENTANCE; ?>&section=uninstall">Uninstall</a>
			<a class="nav-tab" href="<?php echo WPSQT_URL_MAINENTANCE; ?>&section=upgrade">Upgrade</a>
		</h2>
	</div>
	
	<div class="wpsqt-maintenance">
		<h3>Check For Updates</h3>
		
			<?php if (isset($version)) { ?>
				<dl class="wpsqt">
					<dt>Current Version:</dt>
					<dd><?php echo WPSQT_VERSION; ?></dd>
					
					<dt>Most Recent Version:</dt>
					<dd><?php echo $version; ?></dd>
					
					<dd><strong><?php if(version_compare(WPSQT_VERSION, $version) < 0) { echo '<font color="#FF0000">Update required, visit the plugin update page to do so.</font>'; } else { echo '<font color="green">You are up to date</font>'; } ?></strong></dd>
				</dl>
			<?php } ?>
			
		
		
		<form action="" method="post"><input class="button-primary" type="submit" name="check-version" value="Check Version" id="submitbutton" /></form>			
	</div>	
	
	
</div>	
<?php require_once WPSQT_DIR."/pages/admin/shared/image.php"; ?>
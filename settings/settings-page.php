<?php
// Add a Settings Page
function my_scripts_add_admin_menu() {
	add_menu_page(
		'My Scripts Settings',
		'My Scripts Settings',
		'manage_options',
		'my_scripts_settings',
		'my_scripts_settings_page'
	);
}

function my_scripts_settings_page() {
	?>
	<div class="wrap">
		<h1>My Scripts Settings</h1>
		<form action="options.php" method="post">
			<?php
			settings_fields('my_scripts_settings');
			do_settings_sections('my_scripts_settings');
			submit_button();
			?>
		</form>
	</div>
	<?php
}

// Register and Define the Settings
function my_scripts_settings_init() {
	register_setting('my_scripts_settings', 'my_scripts_display_status');

	add_settings_section(
		'my_scripts_settings_section',
		'Script Enqueue Status Display',
		'my_scripts_settings_section_callback',
		'my_scripts_settings'
	);

	add_settings_field(
		'my_scripts_display_status',
		'Display Script Status',
		'my_scripts_display_status_render',
		'my_scripts_settings',
		'my_scripts_settings_section'
	);
}

function my_scripts_settings_section_callback() {
	echo 'Enable or disable the script enqueue status display.';
}

function my_scripts_display_status_render() {
	$options = get_option('my_scripts_display_status');
	?>
	<input type='checkbox' name='my_scripts_display_status' <?php checked($options, 1); ?> value='1'>
	<?php
}

// Hooks
add_action('admin_menu', 'my_scripts_add_admin_menu');
add_action('admin_init', 'my_scripts_settings_init');

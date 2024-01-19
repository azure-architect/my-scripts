<?php

/*
Plugin Name: My Scripts
Plugin URI: http://locallyknown.pro
Description: A brief description of your plugin.
Version: 1.0
Author: Alpine Jimmy
Author URI: http://locallyknown.pro
License: GPL2
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
};

// create a global list of enqueued scripts so that other functions can access the list for their own use

$GLOBALS['my_enqueued_scripts'] = array();
include_once plugin_dir_path(__FILE__) . 'settings/settings-page.php';
function enqueue_my_favorite_frameworks(): void {
	// grab the global and prepare to update it.
	global $my_enqueued_scripts;
	// Enqueue Alpine.js
	wp_enqueue_script(
		'alpinejs',
		plugin_dir_url(__FILE__) . 'node_modules/alpinejs/src/alpine.js',
		array(), // Dependencies (none in this case)
		'3.0.0', // Version number of the script
		true // Load in footer
	);
	$my_enqueued_scripts['alpinejs'] = 'Alpine.js';
	wp_enqueue_script(
		'gsap',
		plugin_dir_url(__FILE__) . 'node_modules/dist/gsap.js/gsap.min.js',
		array(), // Dependencies (none in this case)
		'3.0.0', // Version number of the script
		true // Load in footer
	);
	$my_enqueued_scripts['gsap'] = 'GSAP';
	//repeat for every new script you add.
}

add_action('wp_enqueue_scripts', 'enqueue_my_favorite_frameworks');

//function check_and_display_enqueue_status() {
//	// Check if the script is enqueued
//	if (wp_script_is('alpinejs', 'enqueued')) {
//		echo "<div id='enqueue-status' style='position: fixed; bottom: 10px; left: 10px; background: white; padding: 10px; border: 1px solid #ddd;'>Alpine.js is enqueued!</div>";
//	} else {
//		echo "<div id='enqueue-status' style='position: fixed; bottom: 10px; left: 10px; background: white; padding: 10px; border: 1px solid #ddd;'>Alpine.js is NOT enqueued!</div>";
//	}
//}
//function check_and_display_enqueue_status(): void {
//	// Check if the script is enqueued
//	$ajsIsEnqueued = wp_script_is('alpinejs', 'enqueued') ? 'enqueued' : 'not enqueued';
//	$gsapIsEnqueued = wp_script_is('gsap', 'enqueued') ? 'enqueued' : 'not enqueued';
//
//	// Output the status with a unique ID for the div
//	echo "<div id='enqueue-status' style='position: fixed; top: 30px; left: 10px; background: white; padding: 10px; border: 1px solid #ddd;'>Alpine.js is " . $ajsIsEnqueued . "!</div>";
//	echo "<div id='enqueue-status' style='position: fixed; top: 60px; left: 10px; background: white; padding: 10px; border: 1px solid #ddd;'>GSAP.js is " . $gsapIsEnqueued . "!</div>";
//
//	// Add inline JavaScript to remove the div after 30 seconds (30000 milliseconds)
//	echo "
//        <script type='text/javascript'>
//            setTimeout(function() {
//                var statusDiv = document.getElementById('enqueue-status');
//                if (statusDiv) {
//                    statusDiv.style.display = 'none';
//                }
//            }, 10000);
//        </script>
//    ";
//}
function check_and_display_enqueue_status(): void {
	if (!get_option('my_scripts_display_status')) {
		return; // Exit if the status display is disabled
	}
	global $my_enqueued_scripts;
	if(!empty($my_enqueued_scripts)){
		$topPosition = 60;
		$offset = 30;
	}

	$topPosition = 60; // Starting position for the first script status
	$offset = 40; // Height offset for each subsequent script status

	foreach ($my_enqueued_scripts as $handle => $name) {
		$isEnqueued = wp_script_is($handle, 'enqueued') ? 'enqueued' : 'not enqueued';
		$id = 'enqueue-status-' . $handle; // unique ID for each script

		// Output the status with a unique ID and dynamically adjusted top position
		echo "<div id='{$id}' style='position: fixed; top: {$topPosition}px; left: 10px; background: white; padding: 10px; border: 1px solid #ddd;'>{$name} is {$isEnqueued}!</div>";

		// Inline JavaScript to remove this div after 30 seconds
		echo "
            <script type='text/javascript'>
                setTimeout(function() {
                    var statusDiv = document.getElementById('{$id}');
                    if (statusDiv) {
                        statusDiv.style.display = 'none';
                    }
                }, 15000);
            </script>
        ";

		$topPosition += $offset; // Increment the top position for the next script status
	}
}

add_action('wp_footer', 'check_and_display_enqueue_status');


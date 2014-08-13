<?php

/**
 * @author Jon Henderson
 * @author Jesse G. Donat <donatj@gmail.com>
 */

// You can define these your self to get a different pattern
if( !defined('DROP_CLI_LINK_FORMAT') ) {
	define('DROP_CLI_LINK_FORMAT', 'file://%s %s');
}

if( !defined('DROP_WEB_LINK_FORMAT') ) {
	define('DROP_WEB_LINK_FORMAT', '%s %s');
}


/**
 * A VERY handy function to empty output buffers and take any number of arguments and expose them.
 * This is particularly helpful for looking into arrays and objects to see what information lies
 * within. This function will also kill the script after echoing the information. This function
 * takes any number of any typed arguments and displays them all.
 */
function drop() {

	if( __is_cli() === true ) {
		echo "\033[2J\n";
	}

	call_user_func_array('see', func_get_args());
	die();
}

/**
 * A handy function to expose any number of any typed arguments while NOT killing the script
 * after output.
 */
function see() {
	echo call_user_func_array('output_format_args', func_get_args());
}

/**
 * A handy function to expose any number of any typed arguments while NOT killing the script
 * after output. Unlike drop(), this function must be "echoed".
 */
function output_format_args() {
	$backtrace = debug_backtrace();
	array_shift($backtrace);

	$file = __FILE__;
	$line = -1;
	$func = "";
	foreach( $backtrace as $trace ) {
		$file = empty($trace['file']) ? $file : $trace['file'];
		$line = empty($trace['line']) ? $line : $trace['line'];
		$func = empty($trace['function']) ? $func : $trace['function'];

		if( $file !== __FILE__ ) {
			break;
		}
	}

	if( __is_cli() ) {
		$location = sprintf(DROP_CLI_LINK_FORMAT, $file, $line);
	} else {
		$location = sprintf(DROP_WEB_LINK_FORMAT, $file, $line);
	}

	$center_about = function ( $string, $len ) {
		$string = "    {$string}    ";
		$len    = $len - strlen($string);
		$half   = $len / 2;

		return str_repeat("|", floor($half) - 15) . $string . str_repeat("|", ceil($half) + 15);
	};

	$len   = strlen($location) + 60;
	$final = $center_about($func, $len) . "\n\n";
	$final .= $center_about($location, $len) . "\n\n";

	$exporter  = new \SebastianBergmann\Exporter\Exporter;
	$arguments = func_get_args();
	if( !empty($arguments) ) {
		foreach( $arguments as $i => $argument ) {
			$final .= $center_about("Arg No. {$i}", $len) . "\n\n\n\n";
			$export = $exporter->export($argument);
			$final .= "{$export}\n\n\n\n";

		}
		$final .= $center_about('EOF', $len) . "\n";

		return __is_cli() === true ? $final : "<pre>{$final}</pre>";
	}

	return "";
}

function __is_cli() {
	return substr(strtolower(php_sapi_name()), 0, 3) == 'cli';
}
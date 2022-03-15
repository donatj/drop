<?php

/**
 * @author Jon Henderson
 * @author Jesse G. Donat <donatj@gmail.com>
 */

/**
 * A VERY handy function to empty output buffers and take any number of arguments and expose them.
 * This is particularly helpful for looking into arrays and objects to see what information lies
 * within. This function will also kill the script after echoing the information. This function
 * takes any number of any typed arguments and displays them all.
 */
function drop(...$args) : void {
	if( __is_cli() === true ) {
		echo "\033[2J\n";
	}

	see(...$args);
	die();
}

/**
 * A handy function to expose any number of any typed arguments while NOT killing the script
 * after output.
 */
function see(...$args) : void {
	echo output_format_args(...$args);
}

/**
 * A handy function to expose any number of any typed arguments while NOT killing the script
 * after output. Unlike drop(), this function must be "echoed".
 */
function output_format_args() : string {
	$final     = "";
	$arguments = func_get_args();
	if( !empty($arguments) ) {
		foreach( $arguments as $i => $argument ) {
			$final .= sprintf("\n\n%'|21s Arg No. %-2s %'|43s\n\n", "", $i, "");
			$argument = is_null($argument) ? "(null)null" : $argument;
			$argument = $argument === false ? "(bool)false" : $argument;
			$argument = $argument === true ? "(bool)true" : $argument;
			$final .= sprintf("\n\n%s\n\n", print_r($argument, true));
		}
		$final .= sprintf("\n\n%'|21s EOF %'|50s\n\n", "", "");

		return __is_cli() === true ? $final : "<pre>{$final}</pre>";
	}

	return "";
}

function __is_cli() : bool {
	if( defined('IS_CLI') ) {
		return IS_CLI;
	}

	return stripos(PHP_SAPI, 'cli') === 0;
}
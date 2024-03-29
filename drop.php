<?php

/**
 * @author Jon Henderson
 * @author Jesse G. Donat <donatj@gmail.com>
 * @license MIT
 */

namespace {

	use function donatj\drop\is_cli;

	/**
	 * A helpful function to empty output buffers and take any number of arguments and expose them.
	 * This is particularly helpful for looking into arrays and objects to see what information lies
	 * within. This function will also kill the script after echoing the information. This function
	 * takes any number of any typed arguments and displays them all.
	 *
	 * @param mixed ...$args The arguments to expose the values of
	 * @return never Exit's with status 1
	 */
	function drop( ...$args ) : void {
		if( is_cli() === true ) {
			echo "\033[2J\n";
		}

		see(...$args);
		exit(1);
	}

	/**
	 * A handy function to expose any number of any typed arguments while NOT killing the script
	 * after output.
	 *
	 * @param mixed ...$args
	 */
	function see( ...$args ) : void {
		$out = donatj\drop\output_format_args(...$args);
		echo is_cli() ? $out : "<pre>{$out}</pre>";
	}
}

namespace donatj\drop {

	/**
	 * This handles formatting the actual output of the arguments used in drop() and see()
	 *
	 * @internal This is not intended to be used directly
	 * @param mixed ...$args
	 * @return string
	 */
	function output_format_args( ...$args ) : string {
		$final = "";
		foreach( $args as $i => $argument ) {
			$final .= sprintf("\n\n%'|21s Arg No. %-2s %'|43s\n\n", "", $i, "");
			if( is_scalar($argument) ) {
				$val = var_export($argument, true);
			} else {
				$val = print_r($argument, true);
			}
			$final .= "\n\n{$val}\n\n";
		}
		$final .= sprintf("\n\n%'|21s EOF %'|50s\n\n", "", "");

		return $final;
	}

	/**
	 * Utility function for detecting CLI usage.
	 *
	 * @internal This is not intended to be used directly
	 * @return bool
	 */
	function is_cli() : bool {
		if( defined('IS_CLI') ) {
			return \IS_CLI;
		}

		return stripos(PHP_SAPI, 'cli') === 0;
	}
}

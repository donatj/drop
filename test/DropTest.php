<?php

namespace donatj\drop;

use PHPUnit\Framework\TestCase;

class DropTest extends TestCase {

	/**
	 * @runInSeparateProcess
	 * @testWith
	 *    [ true ]
	 *    [ false ]
	 * @param bool $bool
	 * @return void
	 */
	public function test_is_cli( bool $bool ) : void {
		define('IS_CLI', $bool);
		$this->assertSame($bool, is_cli());
	}

}

<?php

namespace donatj\drop;

use PHPUnit\Framework\TestCase;

class DropTest extends TestCase {

	/**
	 * @runInSeparateProcess
	 * @dataProvider boolProvider
	 * @param bool $bool
	 * @return void
	 */
	public function test_see( bool $bool ) : void {
		define('IS_CLI', $bool);

		ob_start();
		see([ 1, 2, 3 ]);
		$out = ob_get_clean();

		$content = <<<OUT


||||||||||||||||||||| Arg No. 0  |||||||||||||||||||||||||||||||||||||||||||



Array
(
    [0] => 1
    [1] => 2
    [2] => 3
)




||||||||||||||||||||| EOF ||||||||||||||||||||||||||||||||||||||||||||||||||


OUT;


		if( $bool ) {
			$this->assertSame($content, $out);
		} else {
			$this->assertSame("<pre>{$content}</pre>", $out);
		}
	}

	/**
	 * @runInSeparateProcess
	 * @dataProvider boolProvider
	 * @param bool $bool
	 * @return void
	 */
	public function test_is_cli( bool $bool ) : void {
		define('IS_CLI', $bool);
		$this->assertSame($bool, is_cli());
	}

	public function boolProvider() : \Generator {
		yield [ true ];
		yield [ false ];
	}

}

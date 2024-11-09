<?php declare(strict_types = 1);

namespace Bellangelo\CodesnifferNamingConventions\Sniffs;

use SlevomatCodingStandard\Sniffs\TestCase;

class AvoidNumberedVariableNamesSniffTest extends TestCase
{

	public function testHappyPath(): void
	{
		$report = self::checkFile(__DIR__ . '/data/numberedVariableNames.php');

		self::assertSame(2, $report->getErrorCount());
		self::assertSniffError($report, 6, AvoidNumberedVariableNamesSniff::CODE_NUMBERED_VARIABLE, 'Variable ends with a number');
		self::assertSniffError($report, 7, AvoidNumberedVariableNamesSniff::CODE_NUMBERED_VARIABLE, 'Variable ends with a number');
	}

}

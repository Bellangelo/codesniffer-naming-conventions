<?php declare(strict_types = 1);

namespace BellangeloCodingStandards\Sniffs;

use SlevomatCodingStandard\Sniffs\TestCase;

class DuplicateWordInNamingSniffTest extends TestCase
{

	public function testClassNameWithDuplicatedWord(): void
	{
		$report = self::checkFile(__DIR__ . '/data/ClassNameWithDuplicatedWordWord.php');

		self::assertSame(1, $report->getErrorCount());

		self::assertSniffError($report, 7, DuplicateWordInNamingSniff::CODE_DUPLICATED_WORD_CLASS_NAME, 'Duplicate word in class name');

		self::assertAllFixedInFile($report);
	}

	public function testClassNameWithoutDuplicatedWords(): void
	{
		$report = self::checkFile(__DIR__ . '/data/ClassNameWithoutDuplicatedWord.php');

		self::assertSame(0, $report->getErrorCount());
	}

}

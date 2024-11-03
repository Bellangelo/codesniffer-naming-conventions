<?php

declare(strict_types=1);

namespace Bellangelo\CodesnifferNamingConventions\Sniffs;

use SlevomatCodingStandard\Sniffs\TestCase;

class SingularClassNameSniffTest extends TestCase
{
    public function test_class_name_ends_in_plural(): void
    {
        $report = self::checkFile(__DIR__ . '/data/PluralInClassNames.php');

        self::assertSame(1, $report->getErrorCount());

        self::assertSniffError(
            $report,
            7,
            SingularClassNameSniff::CODE_PLURAL_IN_CLASS_NAME,
            'Class name should end in singular'
        );
    }

    public function test_class_name_ends_in_singular(): void
    {
        $report = self::checkFile(__DIR__ . '/data/NoPluralInClassName.php');

        self::assertSame(0, $report->getErrorCount());
    }

    public function test_class_name_ends_in_s_but_is_singular(): void
    {
        $report = self::checkFile(__DIR__ . '/data/SingularWordThatEndsInSCrisis.php');

        self::assertSame(0, $report->getErrorCount());
    }

    public function test_class_name_uses_plural_but_does_not_end_in_s(): void
    {
        $report = self::checkFile(__DIR__ . '/data/PluralWordWithoutSChildren.php');

        self::assertSame(0, $report->getErrorCount());
    }
}
<?php

declare(strict_types=1);

namespace Bellangelo\CodesnifferNamingConventions\Sniffs;

use Override;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class SingularClassNameSniff implements Sniff
{
    #[Override] public function register()
    {
        return [
            T_CLASS,
        ];
    }

    #[Override] public function process(File $phpcsFile, $stackPtr)
    {
        $classNamePointer = $phpcsFile->findNext([T_STRING], $stackPtr);

        if ($classNamePointer === false) {
            return;
        }

        $tokens = $phpcsFile->getTokens();
        $className = $tokens[$classNamePointer]['content'];

        if (substr($className, -1) === 's') {
            $phpcsFile->addError('Class name should be singular', $stackPtr);
        }
    }
}
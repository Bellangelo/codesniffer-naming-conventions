<?php declare(strict_types = 1);

namespace BellangeloCodingStandards\Sniffs;

use Override;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use function preg_match;
use const T_VARIABLE;

class AvoidNumberedVariableNamesSniff implements Sniff
{

	public const string CODE_NUMBERED_VARIABLE = 'NumberedVariable';

	/**
	 * @return array<int>
	 */
	#[Override]
	public function register(): array
	{
		return [
			T_VARIABLE,
		];
	}

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
	 * @param int $stackPtr
	 */
	public function process(File $phpcsFile, $stackPtr): void
	{
		$tokens = $phpcsFile->getTokens();
		$variableName = $tokens[$stackPtr]['content'];

		if (!$this->endsWithNumber($variableName)) {
			return;
		}

		$phpcsFile->addError('Variable ends with a number', $stackPtr, self::CODE_NUMBERED_VARIABLE);
	}

	private function endsWithNumber(string $string): bool
	{
		return preg_match('/\d+$/', $string) === 1;
	}

}

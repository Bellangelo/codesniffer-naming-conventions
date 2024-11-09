<?php declare(strict_types = 1);

namespace BellangeloCodingStandards\Sniffs;

use ErrorException;
use Override;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use function count;
use function explode;
use function is_array;
use function mb_strtolower;
use function preg_split;
use function str_ireplace;
use function str_replace;
use const T_CLASS;
use const T_STRING;

class DuplicateWordInNamingSniff implements Sniff
{

	public const string CODE_DUPLICATED_WORD_CLASS_NAME = 'DuplicateWordInClassName';

	/**
	 * @return array<int>
	 */
	#[Override]
	public function register(): array
	{
		return [
			T_CLASS,
		];
	}

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
	 * @param int $stackPtr
	 */
	public function process(File $phpcsFile, $stackPtr): void
	{
		$classNamePointer = $phpcsFile->findNext([T_STRING], $stackPtr);

		if ($classNamePointer === false) {
			return;
		}

		$tokens = $phpcsFile->getTokens();
		$className = $tokens[$classNamePointer]['content'];

		$camelCaseWords = $this->getDuplicatedCamelCaseWords($className);
		$snakeCaseWords = $this->getDuplicatedSnakeCaseWords($className);

		if (!count($camelCaseWords) && !count($snakeCaseWords)) {
			return;
		}

		$fix = $phpcsFile->addFixableError('Duplicate word in class name', $stackPtr, self::CODE_DUPLICATED_WORD_CLASS_NAME);

		if (!$fix) {
			return;
		}

		$phpcsFile->fixer->beginChangeset();

		$fixedClassName = count($camelCaseWords)
			? $this->removeDuplicatedCamelCaseWords($className, $camelCaseWords)
			: $this->removeDuplicatedSnakeCaseWords($className, $snakeCaseWords);

		$phpcsFile->fixer->replaceToken($classNamePointer, $fixedClassName);

		$phpcsFile->fixer->endChangeset();
	}

	/**
	 * @param array<string> $duplicatedWords
	 */
	private function removeDuplicatedCamelCaseWords(string $className, array $duplicatedWords): string
	{
		$fixedClassName = $className;

		foreach ($duplicatedWords as $duplicatedWord) {
			$fixedClassName = str_ireplace($duplicatedWord . $duplicatedWord, $duplicatedWord, $fixedClassName);
		}

		return $fixedClassName;
	}

	/**
	 * @param array<string> $duplicatedWords
	 */
	private function removeDuplicatedSnakeCaseWords(string $className, array $duplicatedWords): string
	{
		$fixedClassName = $className;

		foreach ($duplicatedWords as $duplicatedWord) {
			$fixedClassName = str_replace($duplicatedWord . '_' . $duplicatedWord, $duplicatedWord, $fixedClassName);
		}

		return $fixedClassName;
	}

	/**
	 * @return array<string>
	 */
	private function getDuplicatedCamelCaseWords(string $className): array
	{
		$camelCasesWords = preg_split('/(?=[A-Z])/', $className);

		if (!is_array($camelCasesWords)) {
			throw new ErrorException('Error while splitting camel case words');
		}

		return $this->getDuplicateWords($camelCasesWords);
	}

	/**
	 * @return array<string>
	 */
	private function getDuplicatedSnakeCaseWords(string $className): array
	{
		$snakeCaseWords = explode('_', $className);

		return $this->getDuplicateWords($snakeCaseWords);
	}

	/**
	 * @param array<string> $words
	 * @return array<string>
	 */
	private function getDuplicateWords(array $words): array
	{
		$duplicates = [];
		$totalWords = count($words);

		for ($i = 1; $i < $totalWords; $i++) {
			if (mb_strtolower($words[$i]) === mb_strtolower($words[$i - 1])) {
				$duplicates[] = $words[$i];
			}
		}

		return $duplicates;
	}

}

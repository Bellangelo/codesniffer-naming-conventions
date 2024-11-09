<?php declare(strict_types = 1);

namespace BellangeloCodingStandards\Sniffs\Naming;

use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;
use Doctrine\Inflector\Language;
use Override;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use const T_CLASS;
use const T_STRING;

final class SingularClassNameSniff implements Sniff
{

	/**
  * @var string
  */
 public const CODE_PLURAL_IN_CLASS_NAME = 'PluralInClassName';

	private Inflector $inflector;

	public function __construct()
	{
		$this->inflector = InflectorFactory::createForLanguage(Language::ENGLISH)->build();
	}

	/**
	 * @return array<int>
	 */
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

		if ($this->isSingular($className)) {
			return;
		}

		$fix = $phpcsFile->addFixableError('Class name should end in singular', $stackPtr, self::CODE_PLURAL_IN_CLASS_NAME);

		if (!$fix) {
			return;
		}

		$phpcsFile->fixer->beginChangeset();

		$phpcsFile->fixer->replaceToken($classNamePointer, $this->inflector->singularize($className));

		$phpcsFile->fixer->endChangeset();
	}

	private function isSingular(string $className): bool
	{
		return $this->inflector->singularize($className) === $className;
	}

}

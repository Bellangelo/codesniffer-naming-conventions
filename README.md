# Bellangelo Coding Standards
Bellangelo Coding Standard for [PHP_CodeSniffer](https://github.com/PHPCSStandards/PHP_CodeSniffer) provides sniffs that fall into one category ( for now ):

* Formatting - rules for consistent code looks

## How to install
```bash
composer require bellangelo/coding-standard --dev
```

## Alphabetical list of sniffs

🔧 = [Automatic errors fixing](#fixing-errors-automatically)

- [Bellangelo.Naming.AvoidNumberedVariableNames](#bellangelonamingavoidnumberedvariablenames) 🔧
- [Bellangelo.Naming.DuplicateWordInNaming](#bellangelonamingduplicatewordinnaming) 🔧
- [Bellangelo.Naming.SingularClassName](#bellangelonamingsingularclassname) 🔧

#### Bellangelo.Naming.AvoidNumberedVariableNames
Variables must not end in a number. This forces developers to use more descriptive names.

#### Bellangelo.Naming.DuplicateWordInNaming 🔧
Class names should not contain duplicate words.
This sniff will check for class names that contain the same word twice and remove any duplicates.

#### Bellangelo.Naming.SingularClassName 🔧
Class names should be singular. This sniff will check for class names that are plural and change them to singular.

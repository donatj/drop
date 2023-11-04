# Drop

[![Latest Stable Version](https://poser.pugx.org/donatj/drop/version)](https://packagist.org/packages/donatj/drop)
[![License](https://poser.pugx.org/donatj/drop/license)](https://packagist.org/packages/donatj/drop)
[![ci.yml](https://github.com/donatj/drop/actions/workflows/ci.yml/badge.svg?)](https://github.com/donatj/drop/actions/workflows/ci.yml)


> "The most effective debugging tool is still careful thought, coupled with judiciously placed print statements."
>
> — Brian Kernighan, "Unix for Beginners" (1979)
			

While debugging small issues, you sometimes just want to see the contents of a variable or two. Firing up a full debugger can be overkill for quick problems, and `var_dump(…); exit(1);` is a little unwieldy and only accepts a single argument.

`drop()` is a simple debugging tool that allows you to drop one of more variable's contents in simple format that is friendly and readable on both web and CLI output.

`see()` is similar to `drop()` but it does not halt execution.
			

## Acknowledgements

This was based on the work of my friend [Jon Henderson](https://github.com/henderjon/drop) before it was given its own repo.

## Example

```php
<?php

require __DIR__ . '/../vendor/autoload.php';

drop(1, 2.0, "3", false, [ 1, 2.0, "3", false ]);

```

```
||||||||||||||||||||| Arg No. 0  |||||||||||||||||||||||||||||||||||||||||||



1



||||||||||||||||||||| Arg No. 1  |||||||||||||||||||||||||||||||||||||||||||



2.0



||||||||||||||||||||| Arg No. 2  |||||||||||||||||||||||||||||||||||||||||||



'3'



||||||||||||||||||||| Arg No. 3  |||||||||||||||||||||||||||||||||||||||||||



false



||||||||||||||||||||| Arg No. 4  |||||||||||||||||||||||||||||||||||||||||||



Array
(
    [0] => 1
    [1] => 2
    [2] => 3
    [3] =>
)




||||||||||||||||||||| EOF ||||||||||||||||||||||||||||||||||||||||||||||||||

```

## Requirements

- **php**: >=7.1

## Installing

Install the latest version with:

```bash
composer require 'donatj/drop'
```

## Documentation

### Function: \drop

```php
function drop(...$args) : void
```

##### Parameters:

- ***mixed*** `$args` - The arguments to expose the values of

##### Returns:

- ***never*** - Exit's with status 1

A helpful function to empty output buffers and take any number of arguments and expose them.  
  
This is particularly helpful for looking into arrays and objects to see what information lies  
within. This function will also kill the script after echoing the information. This function  
takes any number of any typed arguments and displays them all.

### Function: \see

```php
function see(...$args) : void
```

##### Parameters:

- ***mixed*** `$args`

A handy function to expose any number of any typed arguments while NOT killing the script  
after output.
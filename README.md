# PHP Sort

This code was a way for me to familiarize myself with more modern versions of PHP by implementing common sorting algorithms using [what I created with Typescript](https://github.com/richardwalenga/typescriptsort) and [with Python](https://github.com/richardwalenga/pythonsort) as a guide. This uses PHP 8.1 as a minimum, since it takes advantage of readonly properties and enumeration support.

## Running

A VSCode task called "Run tests" will invoke [test.php](test.php) to prove the sort algorithms will correctly sort a pre-defined array and then time the performance over a large array of random integers. NOTE: XDebug has
a noticeable impact on performance. I mitigated some of the hit via the XDEBUG_MODE environment variable as
described [here](https://xdebug.org/docs/all_settings#mode).
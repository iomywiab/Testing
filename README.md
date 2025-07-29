# Testing

This library contains some helpers for testing

![coverage](docs/coverage-badge.svg)
![coverage](docs/coverage-date-badge.svg)

## Quickstart

The main purpose of this library is to provide test values.

* /src/DataTypes contains example Objects/enums
* /src/Formatting contains helpers for formatting values
* /src/Logging contains helpers for quick logging on screen
* /src/Values contains filterable test values

Test values contain edge case values, such as prime numbers, large or tiny floats, strings containing URLs, MAC addresses, IPv6 addresses, and so on.

All these values might be used as input parameters in your tests.

### Example

There is an example with 2 files in

1. /tests/Example/[ExampleClass.php](./tests/Example/ExampleClass.php)
2. /tests/Example/[ExampleTest.php](./tests/Example/ExampleTest.php) 

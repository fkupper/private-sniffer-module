# Private Sniffer

Simple Codeception module to check private elements of objects.

# Installation

Can be installed using composer:

```
composer require --dev fkupper/private-sniffer-module
```
 # Usage

 Simple include the module on your unit suite config YML file:

 ``` yml
modules:
    enabled: [PrivateSniffer]
 ```

 On your unit tests you can now inspect and test private attributes and methods:

``` php
class Foo
{
    private $someInt = 1;

    private sum(int $a, int $b): int
    {
        return $a + $b;
    }
}

class TestFoo extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testSum()
    {
        $foo = new Foo();

        // get the value of the private attribute $someInt
        $someInt = $this->tester->getPrivatePropertyValue($foo, 'someInt');
        $this->assertEquals(1, $someInt);

        // get a closure of the private method sum
        $sum = $this->tester->getPrivateMethod($foo, 'sum');
        $this->assertEquals(2 + 3, $sum(2, 3));
    }
}
```
# Is this a solution to test bad/not testable code?

Of course not. This is meant to be used when critical and sentive part of your code must be tested and is not possible for any reason.

Best practice still is to develop with unit testing in mind and refactor over time whatever you have that cannot be tested properly.
<?php
namespace Codeception\Module;

use Codeception\Module as CodeceptionModule;

class PrivateSniffer extends CodeceptionModule
{
    /**
     * Returns the value of the private property of an instance
     *
     * @param object $object
     * @param string $propertyName
     *
     * @return mixed
     */
    public function getPrivatePropertyValue(object $object, string $propertyName)
    {
        $reflector = new \ReflectionObject($object);

        try {
            $property = $reflector->getProperty($propertyName);
            $property->setAccessible(true);

            $value = $property->getValue($object);
        } catch (\ReflectionException $e) {
            $property = $reflector->getParentClass()->getProperty($propertyName);
            $property->setAccessible(true);

            $value = $property->getValue($object);
        }

        return $value;
    }

    /**
     * Returns the private method as a closure
     *
     * @param object $object
     * @param string $methodName
     *
     * @return \Closure
     */
    public function getPrivateMethod($object, $methodName): \Closure
    {
        $reflector = new \ReflectionObject($object);

        try {
            $method = $reflector->getMethod($methodName);
            $method->setAccessible(true);
        } catch (\ReflectionException $e) {
            $method = $reflector->getParentClass()->getMethod($methodName);
            $method->setAccessible(true);
        }

        return $method->getClosure($object);
    }
}

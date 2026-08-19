# encapsulation-accessor

This package provides accessors to use [encapsulations and containers](https://github.com/x-chert/encapsulation) in
combination with a [property accessor](https://github.com/x-chert/property-access).

## Usage

```php
use Xchert\PropertyAccess\PropertyAccessor;
use Xchert\PropertyAccess\EncapsulationAccessor;
use Xchert\PropertyAccess\ContainerAccessor;

$propertyAccessor = new PropertyAccessor();

// Register EncapsulationAccessor for encapsulation support
$propertyAccessor->registerAccessor(new EncapsulationAccessor(), EncapsulationAccessor::ID, 500);

// Register ContainerAccessor for container support
$propertyAccessor->registerAccessor(new ContainerAccessor(), ContainerAccessor::ID, 500);
```

Probably you will also register the default ```ObjectAccessor```. Make sure to give ```EncapsulationAccessor``` and
```ContainerAccessor``` a higher priority to be considered from the ```PropertyAccessor```.
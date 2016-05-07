jitsu/util
----------

This package includes a number of general-purpose utilities for PHP.

This package is part of [Jitsu](https://github.com/bdusell/jitsu).

## Installation

Install this package with [Composer](https://getcomposer.org/):

```sh
composer require jitsu/util
```

## Namespace

The class is defined under the namespace `Jitsu`.

## API

### class Jitsu\\Util

A collection of general-purpose static methods.

#### Util::str($var)

Get the string representation of a value.

Returns the result of the built-in `print_r` function.

|   | Type |
|---|------|
| **`$var`** | `mixed` |
| returns | `string` |

#### Util::repr($var)

Get a PHP-code representation of a value as a string.

Returns the result of the built-in `var_export` function.

|   | Type |
|---|------|
| **`$var`** | `mixed` |
| returns | `string` |

#### Util::p($args...)

Print values to *stdout*. Intended for debugging.

Prints all of its arguments to **stdout** as PHP code using
`var_export`, separated by spaces and terminated with a newline.
Returns the last argument, which makes it easy to insert a call
into the middle of an expression to print an intermediate value.

|   | Type | Description |
|---|------|-------------|
| **`$args,...`** | `mixed` |  |
| returns | `mixed` | The last argument. |

#### Util::template($filename, $variables)

Transclude a PHP file in a private variable scope.

This `include`s a file within its own variable scope, which may
optionally be populated with an array of values.

|   | Type |
|---|------|
| **`$filename`** | `string` |
| **`$variables`** | `array|null` |

#### Util::has($arr\_or\_obj, $key\_or\_name)

Tell whether an array or object has a certain key or property.

Unlike `isset`, this works even when the value in question is
`null`.

|   | Type |
|---|------|
| **`$arr_or_obj`** | `array|object` |
| **`$key_or_name`** | `int|string` |
| returns | `bool` |

#### Util::get($arr\_or\_obj, $key\_or\_name)

Get the value under a key in an array or a property in an object.

Optionally provide a default value to use if the key or property
does not exist.

|   | Type |
|---|------|
| **`$arr_or_obj`** | `array|object` |
| **`$key_or_name`** | `int|string` |
| returns | `mixed` |

#### Util::set($arr\_or\_obj, $key\_or\_name, $value)

Set a key in an array or a property in an object to some value.

|   | Type |
|---|------|
| **`$arr_or_obj`** | `array|object` |
| **`$key_or_name`** | `int|string` |
| **`$value`** | `mixed` |

#### Util::hasKey($array, $key)

Determine whether an array contains a certain key.

Works even if the value is `null`.

|   | Type |
|---|------|
| **`$array`** | `array` |
| **`$key`** | `int|string` |
| returns | `bool` |

#### Util::getKey($array, $key, $default = null)

Get a value from an array, or a default value if the key is not
present.

|   | Type |
|---|------|
| **`$array`** | `array` |
| **`$key`** | `int|string` |
| **`$default`** | `mixed` |
| returns | `mixed` |

#### Util::hasProp($obj, $name)

Determine whether an object has a property with a certain name.

|   | Type |
|---|------|
| **`$obj`** | `object` |
| **`$name`** | `string` |
| returns | `bool` |

#### Util::getProp($obj, $name, $default = null)

Get the value of a property in an object or a default value if the
object does not have a property by that name.

|   | Type |
|---|------|
| **`$obj`** | `object` |
| **`$name`** | `string` |
| **`$default`** | `mixed` |
| returns | `mixed` |

### class Jitsu\\MetaUtil

Utilities for introspection and reflection.

#### MetaUtil::constantExists($name)

Determine whether a constant by a certain name has been defined.

|   | Type |
|---|------|
| **`$name`** | `string` |
| returns | `bool` |

#### MetaUtil::functionExists($name)

Determine whether a function by a certain name has been defined.

|   | Type |
|---|------|
| **`$name`** | `string` |
| returns | `bool` |

#### MetaUtil::classExists($name)

Determine whether a class by a certain name has been defined.

|   | Type |
|---|------|
| **`$name`** | `string` |
| returns | `bool` |

#### MetaUtil::hasMethod($obj, $name)

Determine whether an object has a method by a certain name.

|   | Type |
|---|------|
| **`$obj`** | `object` |
| **`$name`** | `string` |
| returns | `bool` |

#### MetaUtil::hasStaticMethod($class\_name, $name)

Determine whether a class has a static method by a certain name.

|   | Type |
|---|------|
| **`$class_name`** | `string` |
| **`$name`** | `string` |
| returns | `bool` |

#### MetaUtil::callFunction($name, $args...)

Call a function by a certain name.

|   | Type | Description |
|---|------|-------------|
| **`$name`** | `string` |  |
| **`$args,...`** | `mixed` | Arguments to the function. |
| returns | `mixed` | Whatever is returned by the called function. |

#### MetaUtil::callMethod($obj, $name, $args...)

Call a method by a certain name on an object.

|   | Type | Description |
|---|------|-------------|
| **`$obj`** | `object` |  |
| **`$name`** | `string` |  |
| **`$args,...`** | `mixed` | Arguments to the method. |
| returns | `mixed` | Whatever is returned by the called method. |

#### MetaUtil::callStaticMethod($class\_name, $name, $args...)

Call a static method by a certain name from a certain class.

|   | Type | Description |
|---|------|-------------|
| **`$class_name`** | `string` |  |
| **`$name`** | `string` |  |
| **`$args,...`** | `mixed` | Arguments to the method. |
| returns | `mixed` | Whatever is returned by the called method. |

#### MetaUtil::callConstructor($class\_name, $args...)

Call the constructor of a class by a certain name.

|   | Type | Description |
|---|------|-------------|
| **`$class_name`** | `string` |  |
| **`$args,...`** | `mixed` | Arguments to the constructor. |
| returns | `object` | The newly constructed object, as if `new` had been used. |

#### MetaUtil::applyFunction($name, $args)

Call a function with an array of arguments.

|   | Type |
|---|------|
| **`$name`** | `string` |
| **`$args`** | `array` |
| returns | `mixed` |

#### MetaUtil::applyMethod($obj, $name, $args)

Call a method on an object with an array of arguments.

|   | Type |
|---|------|
| **`$obj`** | `object` |
| **`$name`** | `string` |
| **`$args`** | `array` |
| returns | `mixed` |

#### MetaUtil::applyStaticMethod($class\_name, $name, $args)

Call a static method with an array of arguments.

|   | Type |
|---|------|
| **`$class_name`** | `string` |
| **`$name`** | `string` |
| **`$args`** | `array` |
| returns | `mixed` |

#### MetaUtil::applyConstructor($class\_name, $args)

Call a class constructor with an array of arguments.

|   | Type | Description |
|---|------|-------------|
| **`$class_name`** | `string` |  |
| **`$args`** | `array` |  |
| returns | `object` | The newly constructed object, as if `new` had been used. |

#### MetaUtil::typeName($value)

Get the class or type of a value as a string.

|   | Type |
|---|------|
| **`$value`** | `mixed` |
| returns | `string` |

#### MetaUtil::publicMethods($obj)

Enumerate all of the public methods of an object.

|   | Type |
|---|------|
| **`$obj`** | `object` |
| returns | `\ReflectionMethod[]` |

#### MetaUtil::registerAutoloader($callback)

Add a callback to the chain of autoloader callbacks.

Not necessary if Composer is used.

|   | Type |
|---|------|
| **`$callback`** | `callable` |

#### MetaUtil::autoloadNamespace($namespace, $dirs)

Register an autoloader which maps a namespace to one or more
filesystem directories.

Not necessary if Composer is used.

|   | Type |
|---|------|
| **`$namespace`** | `string` |
| **`$dirs`** | `string|string[]` |

### class Jitsu\\Util\\Lazy

A base class for defining lazily-instantiated classes.

Lazy objects behave just like those of another class, except they are not
instantiated until the first time one of their members is accessed.

Subclass this class and define `const T` in the subclass as the name of the
proxied class. The subclass is the lazy class.

#### new Lazy()

#### $lazy->\_\_call($name, $args)

#### $lazy->\_\_get($name)

#### $lazy->\_\_set($name, $value)

#### $lazy->\_\_isset($name)

#### $lazy->\_\_unset($name)

#### $lazy->\_\_toString()

#### $lazy->\_\_clone()

#### $lazy->\_\_invoke()

#### $lazy->\_\_debugInfo()

#### $lazy->\_\_sleep()

#### $lazy->\_\_wakeup()

#### $lazy->instantiate()

Instantiate the underlying object without needing to reference one
of its members.

#### $lazy->isInstantiated()

Tell whether the underlying object has been instantiated.

|   | Type |
|---|------|
| returns | `bool` |

### trait Jitsu\\Util\\Singleton

A mixin for creating singleton classes.

Override `instantiate` to return some object. All methods of that object
become available as static methods of the derived class, and the object is
only instantiated when one of these methods is called.

#### $singleton->instantiate() [protected]

Override this method to return the singleton instance.

|   | Type |
|---|------|
| returns | `object` |

#### Singleton::instance()

Get the singleton instance.

|   | Type |
|---|------|
| returns | `object` |

#### Singleton::\_\_callStatic($name, $args)


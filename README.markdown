SilverStripe iCal Module
========================

This module provides the iCal DataObject, which can load in an iCal (ICS) file,
with the data stored in DBFields on the object, with a has_many of iCalEvent
DataObjects.

Example Usage
-------------

```php
<?php
$calendar = iCal::create("path/to/file.ics");
foreach($calendar->Events as $event) {
	...
}
$calendar->write();
```

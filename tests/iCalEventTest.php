<?php
class iCalEventTest extends SapphireTest {
	public static $fixture_file = 'ical/tests/data/fixture.yml';
	public static $ics_file = "data/testdata.ics";
	
	public function provider() {
		return array(
			array(iCal::create(__DIR__."/".self::$ics_file))
		);
	}
	
	public function testConstruct() {
		$cal = iCal::create(__DIR__."/".self::$ics_file);
		
		$this->assertTrue($cal->hasField('Events'));
		$this->assertTrue($cal->Events->exists()); // not empty
		
		foreach($cal->Events as $event) {
			$this->assertInstanceOf('iCalEvent', $event);
			$fields = $event->getAllFields();
			
			foreach($fields as $name => $field) {
				if($name == "ID") continue; // ID will always be 0
				$dbField = $event->dbObject($name);
				$type = gettype($field);
				if($dbField && $dbField->hasValue()) $this->assertTrue((bool) $dbField->exists(), "{$name} ({$dbField}) has bad value of {$field} with type $type");
			}
		}
	}
	
	/**
	* @dataProvider provider
	*/
	public function testWrite($calendar) {
		$event = $calendar->Events->pop();
		$event->write();
		$this->assertGreaterThan(0, $event->ID);
		
		$fromDatabase = DataObject::get_by_id('iCalEvent', $event->ID);
		$this->assertInstanceOf('iCalEvent', $fromDatabase);
		$this->assertTrue((bool) $fromDatabase->exists());
	}
}

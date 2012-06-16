<?php
class iCalTest extends SapphireTest {
	public static $fixture_file = 'ical/tests/data/fixture.yml';
	public static $ics_file = "data/testdata.ics";
	
	public function provider() {
		return array(
			array(iCal::create(__DIR__."/".self::$ics_file)),
		);
	}
	
	public function testConstruct() {
		$calFields = array(
			"ClassName" => "iCal",
			"ProdID" => "-//Google Inc//Google Calendar 70.9054//EN",
			"Version" => "2.0",
			"CalScale" => "GREGORIAN",
			"Method" => "PUBLISH",
			"Title" => "Testkalender",
			"TimeZone" => "Europe/Berlin",
			"Content" => "Nur zum testen vom Google Kalender"
		);
	
		$cal = iCal::create(__DIR__."/".self::$ics_file);
		
		foreach($calFields as $name => $value)
			$this->assertEquals($cal->$name, $value);
	}
	
	/**
	* @dataProvider provider
	*/
	public function testWrite($calendar) {
		$calendar->write();
		$this->assertGreaterThan(0, $calendar->ID);
		
		$fromDatabase = DataObject::get_by_id('iCal', $calendar->ID);
		$this->assertInstanceOf('iCal', $fromDatabase);
		$this->assertTrue((bool) $fromDatabase->exists());
		
		$events = $fromDatabase->Events();
		$this->assertEquals($events->Count(), $calendar->Events->Count());
	}
}

<?php
class iCalReaderTest extends SapphireTest {
	public static $fixture_file = 'ical/tests/data/fixture.yml';
	public static $ics_file = "data/testdata.ics";
	
	public function provider() {
		return array(
			array(new iCalReader(__DIR__."/".self::$ics_file)),
			array(new iCalReader(file_get_contents(__DIR__."/".self::$ics_file), true))
		);
	}
	
	/**
	* @dataProvider provider
	*/
	public function testConstruct($reader) {
		$this->assertInstanceOf('iCalReader', $reader);
		$this->assertEquals($reader->todo_count, 0);
		$this->assertEquals($reader->event_count, 14);
		$this->assertTrue(is_array($reader->cal));
		$this->assertTrue(count($reader->cal) === 2);
	}
	
	/**
	* @dataProvider provider
	*/
	public function testCalendar($reader) {
		$calendarKeys = array(
			"CALSCALE" => "GREGORIAN",
			"METHOD" => "PUBLISH",
			"PRODID" => "-//Google Inc//Google Calendar 70.9054//EN",
			"VERSION" => "2.0",
			"X-WR-CALDESC" => "Nur zum testen vom Google Kalender",
			"X-WR-CALNAME" => "Testkalender",
			"X-WR-TIMEZONE" => "Europe/Berlin"
		);
	
		$this->assertArrayHasKey("VCALENDAR", $reader->cal);
		$calendar = $reader->cal["VCALENDAR"];
	
		$this->assertTrue(is_array($calendar));
		
		foreach($calendarKeys as $key => $value) {
			$this->assertArrayHasKey($key, $calendar);
			$this->assertEquals($calendar[$key], $value);
		}
	}
	
	/**
	* @dataProvider provider
	*/
	public function testEvents($reader) {
		$mockEvents = array (
		      0 => 
		      array (
			'DTSTART' => '20110105T090000Z',
			'DTEND' => '20110107T173000Z',
			'DTSTAMP' => '20110121T195741Z',
			'UID' => '15lc1nvupht8dtfiptenljoiv4@google.com',
			'CREATED' => '20110121T195616Z',
			'DESCRIPTION' => 'This is a short description\\nwith a new line. Some "special" \'signs\' may be <interesting>\\, too.',
			'LAST-MODIFIED' => '20110121T195729Z',
			'LOCATION' => 'Kansas',
			'SEQUENCE' => '2',
			'STATUS' => 'CONFIRMED',
			'SUMMARY' => 'My Holidays',
			'TRANSP' => 'TRANSPARENT',
		      ),
		      1 => 
		      array (
			'DTSTART' => '20110112',
			'DTEND' => '20110116',
			'DTSTAMP' => '20110121T195741Z',
			'UID' => '1koigufm110c5hnq6ln57murd4@google.com',
			'CREATED' => '20110119T142901Z',
			'DESCRIPTION' => 'Project xyz Review Meeting Minutes\\nAgenda\\n1. Review of project version 1.0 requirements.\\n2.Definitionof project processes.\\n3. Review of project schedule.\\n',
			'Participants' => ' John Smith, Jane Doe, Jim Dandy\\n-It wasdecided that the requirements need to be signed off byproduct marketing.\\n-Project processes were accepted.\\n-Project schedule needs to account for scheduled holidaysand employee vacation time. Check with HR for specificdates.\\n-New schedule will be distributed by Friday.\\n-Next weeks meeting is cancelled. No meeting until 3/23.',
			'LAST-MODIFIED' => '20110119T152216Z',
			'LOCATION' => '',
			'SEQUENCE' => '2',
			'STATUS' => 'CONFIRMED',
			'SUMMARY' => 'test 11',
			'TRANSP' => 'TRANSPARENT',
		      ),
		      2 => 
		      array (
			'DTSTART' => '20110118',
			'DTEND' => '20110120',
			'DTSTAMP' => '20110121T195741Z',
			'UID' => '4dnsuc3nknin15kv25cn7ridss@google.com',
			'CREATED' => '20110119T142059Z',
			'DESCRIPTION' => '',
			'LAST-MODIFIED' => '20110119T142106Z',
			'LOCATION' => '',
			'SEQUENCE' => '0',
			'STATUS' => 'CONFIRMED',
			'SUMMARY' => 'test 9',
			'TRANSP' => 'TRANSPARENT',
		      ),
		      3 => 
		      array (
			'DTSTART' => '20110117',
			'DTEND' => '20110122',
			'DTSTAMP' => '20110121T195741Z',
			'UID' => 'h6f7sdjbpt47v3dkral8lnsgcc@google.com',
			'CREATED' => '20110119T142040Z',
			'DESCRIPTION' => '',
			'LAST-MODIFIED' => '20110119T142040Z',
			'LOCATION' => '',
			'SEQUENCE' => '0',
			'STATUS' => 'CONFIRMED',
			'SUMMARY' => '',
			'TRANSP' => 'TRANSPARENT',
		      ),
		      4 => 
		      array (
			'DTSTART' => '20110117',
			'DTEND' => '20110118',
			'DTSTAMP' => '20110121T195741Z',
			'UID' => 'up56hlrtkpqdum73rk6tl10ook@google.com',
			'CREATED' => '20110119T142034Z',
			'DESCRIPTION' => '',
			'LAST-MODIFIED' => '20110119T142034Z',
			'LOCATION' => '',
			'SEQUENCE' => '0',
			'STATUS' => 'CONFIRMED',
			'SUMMARY' => 'test 8',
			'TRANSP' => 'TRANSPARENT',
		      ),
		      5 => 
		      array (
			'DTSTART' => '20110118',
			'DTEND' => '20110120',
			'DTSTAMP' => '20110121T195741Z',
			'UID' => '8ltm205uhshsbc1huv0ooeg4nc@google.com',
			'CREATED' => '20110119T142014Z',
			'DESCRIPTION' => '',
			'LAST-MODIFIED' => '20110119T142023Z',
			'LOCATION' => '',
			'SEQUENCE' => '0',
			'STATUS' => 'CONFIRMED',
			'SUMMARY' => 'test 7',
			'TRANSP' => 'TRANSPARENT',
		      ),
		      6 => 
		      array (
			'DTSTART' => '20110119',
			'DTEND' => '20110121',
			'DTSTAMP' => '20110121T195741Z',
			'UID' => 'opklai3nm8enffdf5vpna4o5fo@google.com',
			'CREATED' => '20110119T141918Z',
			'DESCRIPTION' => '',
			'LAST-MODIFIED' => '20110119T142005Z',
			'LOCATION' => '',
			'SEQUENCE' => '0',
			'STATUS' => 'CONFIRMED',
			'SUMMARY' => 'test 5',
			'TRANSP' => 'TRANSPARENT',
		      ),
		      7 => 
		      array (
			'DTSTART' => '20110119',
			'DTEND' => '20110120',
			'DTSTAMP' => '20110121T195741Z',
			'UID' => 'kmbj764g57tcvua11hir61c4b8@google.com',
			'CREATED' => '20110119T141923Z',
			'DESCRIPTION' => '',
			'LAST-MODIFIED' => '20110119T141923Z',
			'LOCATION' => '',
			'SEQUENCE' => '0',
			'STATUS' => 'CONFIRMED',
			'SUMMARY' => 'test 6',
			'TRANSP' => 'TRANSPARENT',
		      ),
		      8 => 
		      array (
			'DTSTART' => '20110119',
			'DTEND' => '20110120',
			'DTSTAMP' => '20110121T195741Z',
			'UID' => 'shvr7hvqdag08vjqlmj5lj0i2s@google.com',
			'CREATED' => '20110119T141913Z',
			'DESCRIPTION' => '',
			'LAST-MODIFIED' => '20110119T141913Z',
			'LOCATION' => '',
			'SEQUENCE' => '0',
			'STATUS' => 'CONFIRMED',
			'SUMMARY' => 'test 4',
			'TRANSP' => 'TRANSPARENT',
		      ),
		      9 => 
		      array (
			'DTSTART' => '20110119',
			'DTEND' => '20110120',
			'DTSTAMP' => '20110121T195741Z',
			'UID' => '77gpemlb9es0r0gtjolv3mtap0@google.com',
			'CREATED' => '20110119T141909Z',
			'DESCRIPTION' => '',
			'LAST-MODIFIED' => '20110119T141909Z',
			'LOCATION' => '',
			'SEQUENCE' => '0',
			'STATUS' => 'CONFIRMED',
			'SUMMARY' => 'test 3',
			'TRANSP' => 'TRANSPARENT',
		      ),
		      10 => 
		      array (
			'DTSTART' => '20110119',
			'DTEND' => '20110120',
			'DTSTAMP' => '20110121T195741Z',
			'UID' => 'rq8jng4jgq0m1lvpj8486fttu0@google.com',
			'CREATED' => '20110119T141904Z',
			'DESCRIPTION' => '',
			'LAST-MODIFIED' => '20110119T141904Z',
			'LOCATION' => '',
			'SEQUENCE' => '0',
			'STATUS' => 'CONFIRMED',
			'SUMMARY' => 'test 2',
			'TRANSP' => 'TRANSPARENT',
		      ),
		      11 => 
		      array (
			'DTSTART' => '20110119',
			'DTEND' => '20110120',
			'DTSTAMP' => '20110121T195741Z',
			'UID' => 'dh3fki5du0opa7cs5n5s87ca00@google.com',
			'CREATED' => '20110119T141901Z',
			'DESCRIPTION' => '',
			'LAST-MODIFIED' => '20110119T141901Z',
			'LOCATION' => '',
			'SEQUENCE' => '0',
			'STATUS' => 'CONFIRMED',
			'SUMMARY' => 'test 1',
			'TRANSP' => 'TRANSPARENT',
		      ),
		      12 => 
		      array (
			'DTSTART' => '20400201',
			'DTEND' => '20400202',
			'DTSTAMP' => '20400101T195741Z',
			'UID' => 'dh3fki5du0opa7cs5n5s87ca01@google.com',
			'CREATED' => '20400101T141901Z',
			'DESCRIPTION' => '',
			'LAST-MODIFIED' => '20400101T141901Z',
			'LOCATION' => '',
			'SEQUENCE' => '0',
			'STATUS' => 'CONFIRMED',
			'SUMMARY' => 'Year 2038 problem test',
			'TRANSP' => 'TRANSPARENT',
		      ),
		      13 => 
		      array (
			'DTSTART' => '19410512',
			'DTEND' => '19410512',
			'DTSTAMP' => '19410512T195741Z',
			'UID' => 'dh3fki5du0opa7cs5n5s87ca02@google.com',
			'CREATED' => '20400101T141901Z',
			'DESCRIPTION' => '',
			'LAST-MODIFIED' => '20400101T141901Z',
			'LOCATION' => '',
			'SEQUENCE' => '0',
			'STATUS' => 'CONFIRMED',
			'SUMMARY' => 'Before 1970-Test: Konrad Zuse invents the Z3, the first digital Computer',
			'TRANSP' => 'TRANSPARENT',
		      ),
		);
	
		$this->assertArrayHasKey("VEVENT", $reader->cal);
		$events = $reader->cal["VEVENT"];
		
		$this->assertTrue(is_array($events));
		$this->assertEquals(count($events), 14);
		
		foreach($mockEvents as $eventKey => $event) foreach($event as $key => $value) {
			$this->assertArrayHasKey($key, $events[$eventKey]);
			$this->assertEquals($events[$eventKey][$key], $value);
		}
	}
}

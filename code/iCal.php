<?php
class iCal extends DataObject {
	public static $db = array(
		"ProdID" => "Text",
		"Version" => "Varchar(5)",
		"CalScale" => "Varchar(9)",
		"Method" => "Varchar(10)",
		"Title" => "Text",
		"TimeZone" => "Text",
		"Content" => "Text"
	);
	
	public static $has_many = array(
		"Events" => "iCalEvent"
	);
	
	public $fieldmap = array(
		"PRODID" => "ProdID",
		"VERSION" => "Version",
		"CALSCALE" => "CalScale",
		"METHOD" => "Method",
		"X-WR-CALNAME" => "Title",
		"X-WR-TIMEZONE" => "TimeZone",
		"X-WR-CALDESC" => "Content"
	);
	
	public $eventType = "iCalEvent";

	public static function create($filename) {
		$reader = new iCalReader($filename);
		return self::createFromReader($reader);
	}

	public static function createFromData($data) {
		$reader = new iCalReader($data, true);
		return self::createFromReader($reader);
	}
	
	public static function createFromReader(iCalReader $reader) {
		$calendar = $reader->cal["VCALENDAR"];
	
		$new = new static();
		foreach($new->fieldmap as $left => $right)
			if(array_key_exists($left, $calendar)) $new->$right = $calendar[$left];
			
		if(array_key_exists("VEVENT", $reader->cal)) {
			$events = $reader->cal["VEVENT"];
			$newEvents = new DataObjectSet();
			
			if(strlen($new->TimeZone) > 0) {
				$timezone = new DateTimeZone($new->TimeZone)?:null;
			} else $timezone = null;
			
			$eventType = $new->eventType;
			foreach($events as $event) {
				$newEvent = $eventType::create($event, $timezone);
				if(is_a($newEvent, $new->eventType)) $newEvents->addWithoutWrite($newEvent);
			}
			$new->Events = $newEvents;
		}
		
		return $new;
	}
	
	public function onAfterWrite() {
		parent::onAfterWrite();
		foreach($this->Events as $event)
			if($event && !$event->isInDB()) {
				$event->CalendarID = $this->ID;
				$event->write();
			}
	}
}

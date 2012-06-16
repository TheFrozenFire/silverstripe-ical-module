<?php
class iCalEvent extends DataObject {
	public static $db = array(
		"UID" => "Text",
		"Content" => "Text",
		"Location" => "Text",
		"Sequence" => "Int",
		"Status" => "Text",
		"Title" => "Text",
		"Transparency" => "Text",
		"Start" => "SS_DateTime",
		"End" => "SS_DateTime",
		"Created" => "SS_DateTime",
		"Modified" => "SS_DateTime"
	);
	
	public static $has_one = array(
		"Calendar" => "iCal"
	);

	public $fieldmap = array (
		'UID' => 'UID',
		'DESCRIPTION' => 'Content',
		'LOCATION' => 'Location',
		'SEQUENCE' => 'Sequence',
		'STATUS' => 'Status',
		'SUMMARY' => 'Title',
		'TRANSP' => 'Transparency'
	);
	
	public $dateTimeMap = array(
		'DTSTART' => 'Start',
		'DTEND' => 'End',
		'DTSTAMP' => 'Transmitted',
		'CREATED' => 'Created',
		'LAST-MODIFIED' => 'Modified'
	);

	public static function create(Array $event, DateTimeZone $timezone = null) {
		$new = new static();
		
		foreach($new->fieldmap as $left => $right)
			if(array_key_exists($left, $event)) {
				$new->setField($right, $event[$left]);
			}
		
		foreach($new->dateTimeMap as $left => $right)
			if(array_key_exists($left, $event)) {
				$dateTime = new DateTime($event[$left], $timezone);
				$rightField = new SS_DateTime();
				$rightField->setValue($dateTime->getTimestamp());
				$new->setField($right, $rightField->getValue());
			}
		
		return $new;
	}
}

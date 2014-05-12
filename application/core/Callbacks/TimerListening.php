<?php

namespace ManiaControl\Callbacks;

/**
 * Model Class for a Timer Listening
 *
 * @author    ManiaControl Team <mail@maniacontrol.com>
 * @copyright 2014 ManiaControl Team
 * @license   http://www.gnu.org/licenses/ GNU General Public License, Version 3
 */
class TimerListening extends Listening {
	/*
	 * Public Properties
	 */
	public $deltaTime = null;
	public $oneTime = null;
	public $lastTrigger = null;
	public $instantCall = null;

	/**
	 * Construct a new Timer Listening
	 *
	 * @param TimerListener $listener
	 * @param mixed         $method
	 * @param float         $milliSeconds
	 * @param bool          $oneTime
	 * @param bool          $instantCall
	 */
	public function __construct(TimerListener $listener, $method, $milliSeconds, $oneTime = false, $instantCall = true) {
		parent::__construct($listener, $method);

		$this->deltaTime   = $milliSeconds / 1000.;
		$this->oneTime     = (bool)$oneTime;
		$this->instantCall = (bool)$instantCall;
		if (!$this->instantCall) {
			$this->lastTrigger = microtime(true);
		}
	}

	/**
	 * Increase last Trigger Time
	 */
	public function tick() {
		if ($this->lastTrigger === null) {
			$this->lastTrigger = microtime(true);
		} else {
			$this->lastTrigger += $this->deltaTime;
		}
	}

	/**
	 * Check if the desired Time is reached
	 *
	 * @param float $time
	 * @return bool
	 */
	public function isTimeReached($time = null) {
		if ($this->lastTrigger === null) {
			return true;
		}
		if (!$time) {
			$time = microtime(true);
		}
		return ($this->lastTrigger + $this->deltaTime <= $time);
	}
}

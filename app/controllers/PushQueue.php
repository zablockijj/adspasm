<?php

class PushQueue {

	/**
	 *	date = array('message', '')
	 */
	public function fire($job, $data) {
			$job->delete();
	}

}

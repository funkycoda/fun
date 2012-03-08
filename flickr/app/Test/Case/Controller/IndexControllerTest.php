<?php
/**
 * IndexControllerTest
 * 
 * The test case. Should really be doing something better?
 */

class IndexControllerTest extends ControllerTestCase {
	public function testIndex() {
        $result = $this->testAction('/index');
        debug($result);
    }

	public function testSearch() {
        $result = $this->testAction('/go');
        debug($result);
    }

	public function testSearchQuery() {
        $result = $this->testAction('/go/sydney+central+station');
        debug($result);
    }

	public function testSearchQueryPage() {
        $result = $this->testAction('/go/sydney+central+station/1');
        debug($result);
    }

}

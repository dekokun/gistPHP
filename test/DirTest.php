<?php

require_once dirname(__FILE__) . '/../../lib/Autoload.php';

class DirTest extends PHPUnit_Framework_TestCase {

  protected $object;

  protected function setUp() {
    $this->object = new Dir;
  }

  protected function tearDown() {
    
  }

}

?>

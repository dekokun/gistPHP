<?php

require_once dirname(__FILE__) . '/../lib/Autoload.php';

class GitTest extends PHPUnit_Framework_TestCase {

  protected $subject;
  protected function setUp() {
    $test_dir = dirname(__FILE__) . '/../Gittestdir';
    $this->subject = new Git($test_dir);
  }

  protected function tearDown() {

  }

  public function test() {

  }

}

?>


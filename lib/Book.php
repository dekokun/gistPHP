<?php

class Book {
  protected $place;
  protected $version;
  protected $git_wrapper;

  public function __construct($book_place, $version, $git_wrapper)
  {
    if (!static::isExist($book_place)) {
      throw new InvalidArgumentException('The book is not exists.');
    }
    $this->place = $book_place;
    $this->version = $version;
    $this->git_wrapper = $git_wrapper;
  }

  public function getPages() {
    $page_names = $this->git_wrapper->listDirectory($this->place, $this->version);
    $pages = array();
    foreach($page_names as $page_name) {
      $pages[$page_name] = $this->git_wrapper->showFile($page_name, $this->version);
    }
    return $pages;
  }

  public function getHistory() {
    return $this->git_wrapper->getLog();
  }

  static protected function isExist($place) {
    return file_exists($place);
  }
}


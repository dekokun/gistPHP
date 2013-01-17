<?php

class Book {
  protected $place;
  protected $git_wrapper;
  protected $name;

  public function __construct($book_place, $git_wrapper)
  {
    $this->place = substr($book_place, -1) === DIRECTORY_SEPARATOR ? $book_place : $book_place . DIRECTORY_SEPARATOR;
    if (!static::isExist($this->place)) {
      throw new InvalidArgumentException('The book is not exists.');
    }
    $files = glob($this->place . '*');
    if (count($files) === 0) {
      throw new InvalidArgumentException('The page is not exists.');
    }
    $this->name = basename($files[0]);
    $this->git_wrapper = $git_wrapper;
  }

  public function getPage($version) {
    return $this->git_wrapper->showFile($this->name, $version);
  }

  public function getHistory() {
    return History::parse($this->git_wrapper->getLog());
  }

  static protected function isExist($place) {
    return file_exists($place . '.git');
  }
}


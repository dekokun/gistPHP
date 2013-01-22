<?php

class Book {
  protected $place;
  protected $git_wrapper;
  const filename = 'index';

  public function __construct($book_place, $git_wrapper) {
    $this->place = substr($book_place, -1) === DIRECTORY_SEPARATOR ? $book_place : $book_place . DIRECTORY_SEPARATOR;
    if (!static::isExist($this->place)) {
      throw new InvalidArgumentException('The book is not exists.');
    }
    $this->git_wrapper = $git_wrapper;
  }

  public function getPage($version) {
    $full_name = $this->fullName();
    if (! file_exists($full_name)) {
      return '';
    }
    return $this->git_wrapper->showFile(self::filename, $version);
  }

  public function getHistory() {
    return History::parse($this->git_wrapper->getLog());
  }

  static protected function isExist($place) {
    return file_exists($place . '.git');
  }

  public function addPage($contents, $comment) {
    $full_name = $this->fullName();
    file_put_contents($full_name, $contents);
    $this->git_wrapper->add(array($full_name));
    if ($this->git_wrapper->isDirty()) {
      $this->git_wrapper->commit(date('Y/m/d H:i:s') . ' ' . $comment);
    }
  }

  protected function fullName() {
    return $this->place . self::filename;
  }
}


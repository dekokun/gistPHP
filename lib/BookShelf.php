<?php


class BookShelf
{
  protected $root_git;
  protected $books;
  protected $place;
  protected $binary;
  protected $git_wrapper;

  public function __construct($root_dir, $git_wrapper, $binary)
  {
    if (!file_exists($root_dir . '/.git')) {
      $binary->init($root_dir);
    }
    $this->git_wrapper = $git_wrapper::open($root_dir, $binary, 0755);
    $this->books = array_flip(array_map('basename', glob($root_dir . '/*')));
    $this->place = substr($root_dir, -1) === DIRECTORY_SEPARATOR ? $root_dir : $root_dir . DIRECTORY_SEPARATOR;
    $this->binary = $binary;
  }

  public function makeBook()
  {
    $now_max_book_id = max(array_keys($this->books)) + 1;
    while (!@mkdir($book_place = $this->place . $now_max_book_id)) {
      $now_max_book_id += 1;
    }
    $this->binary->init($book_place);
    return $now_max_book_id;
  }
}

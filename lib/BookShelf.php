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
    $this->root_git = $git_wrapper::open($root_dir, $binary, 0755);
    $this->books = array_flip(array_map('basename', glob($root_dir . '/*')));
    $this->place = substr($root_dir, -1) === DIRECTORY_SEPARATOR ? $root_dir : $root_dir . DIRECTORY_SEPARATOR;
    $this->binary = $binary;
    $this->git_wrapper = $git_wrapper;
  }

  public function makeBook()
  {
    $now_book_count = count($this->books);
    $now_max_book_id = $now_book_count > 0 ? max(array_keys($this->books)) + 1 : 1;
    while (!@mkdir($book_place = $this->place . $now_max_book_id)) {
      $now_max_book_id += 1;
    }
    $this->binary->init($book_place);
    return $now_max_book_id;
  }

  public function findBook($book_id){
    $book_place = $this->place . $book_id;
    // パースエラーになるため一時的にローカル変数に格納
    $git_wrapper = $this->git_wrapper;
    $git = $git_wrapper::open($book_place, $this->binary);
    return new Book($book_place, $git);
  }
}

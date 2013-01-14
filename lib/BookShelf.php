<?php


class BookShelf {
  protected $root_git;
  protected $books;
  protected $place;
  protected $binary;

  public function __construct($root_dir, $repo_class_name, $binary) {
    if(! file_exists($root_dir . '/.git')) {
      $binary->init($root_dir);
    }
    $this->root_git = $repo_class_name::open($root_dir, $binary, 0755);
    $this->books = glob($root_dir . '/*');
    $this->place = $root_dir;
    $this->binary = $binary;
  }

  public function makeNextBook() {
    $now_max_book_id = max(array_map('basename', $this->books));
    while (!@mkdir($book_place = $this->place . '/' . $now_max_book_id)) {
      $now_max_book_id += 1;
    }
    $this->binary->init($book_place);
    return $now_max_book_id;
  }
}

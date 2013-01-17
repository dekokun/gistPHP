<?php
class Commit
{

  private $commit;

  private function __construct($commit) {
    $this->commit = $commit;
  }

  public static function parse($log) {
    foreach (explode(PHP_EOL, $log) as $line) {
      if (strpos($line, 'commit') === 0) {
        $commit['hash'] = trim(substr($line, strlen('commit')));
      } else if (strpos($line, 'Author:') === 0) {
        $commit['author'] = trim(substr($line, strlen('Author:')));
      } else if (strpos($line, 'AuthorDate:') === 0) {
        $commit['authordate'] = trim(substr($line, strlen('AuthorDate:')));
      } else if (strpos($line, 'CommitDate:') === 0) {
        $commit['commitdate'] = trim(substr($line, strlen('CommitDate:')));
      } else if (strpos($line, 'Commit:') === 0) {
        $commit['committer'] = trim(substr($line, strlen('Commit:')));
      } else {
        if(isset($commit['message'])) {
          $commit['message'] .= $line;
        } else {
          $commit['message'] = $line;
        }
      }
    }
    return new self($commit);
  }

  public function hash() {
    return $this->commit['hash'];
  }

  public function shortHash() {
    return substr($this->commit['hash'], 0, 8);
  }

  public function commiter() {
    return substr($this->commit['commiter'], 0, 8);
  }

  public function commitDate() {
    return substr($this->commit['commitedate'], 0, 8);
  }

  public function message() {
    return $this->commit['message'];
  }
}

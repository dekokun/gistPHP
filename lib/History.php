<?php

class History implements Iterator
{

  protected $history;
  protected $position;

  public function __construct($logs)
  {
    $history = array();
    $message = '';
    foreach ($logs as $log) {
      foreach (explode(PHP_EOL, $log) as $line) {
        if (strpos($line, 'commit') === 0) {
          if (!empty($commit)) {
            $commit['message'] = $message;
            array_push($history, $commit);
            unset($commit);
            $message = '';
          }
          $commit['hash'] = substr($line, strlen('commit'));
        } else if (strpos($line, 'Author:') === 0) {
          $commit['author'] = substr($line, strlen('Author:'));
        } else if (strpos($line, 'AuthorDate:') === 0) {
          $commit['authordate'] = substr($line, strlen('AuthorDate:'));
        } else if (strpos($line, 'CommitDate:') === 0) {
          $commit['commitdate'] = substr($line, strlen('CommitDate:'));
        } else if (strpos($line, 'Commit:') === 0) {
          $commit['committer'] = substr($line, strlen('Commit:'));
        } else {
          $message .= $line;
        }
      }
    }
    $this->history = $history;
    $this->position = 0;
  }

  /**
   * (PHP 5 &gt;= 5.0.0)<br/>
   * Return the current element
   * @link http://php.net/manual/en/iterator.current.php
   * @return mixed Can return any type.
   */
  public function current()
  {
    return $this->history[$this->position];
  }

  /**
   * (PHP 5 &gt;= 5.0.0)<br/>
   * Move forward to next element
   * @link http://php.net/manual/en/iterator.next.php
   * @return void Any returned value is ignored.
   */
  public function next()
  {
    $this->position += 1;
  }

  /**
   * (PHP 5 &gt;= 5.0.0)<br/>
   * Return the key of the current element
   * @link http://php.net/manual/en/iterator.key.php
   * @return mixed scalar on success, or null on failure.
   */
  public function key()
  {
    return $this->position;
  }

  /**
   * (PHP 5 &gt;= 5.0.0)<br/>
   * Checks if current position is valid
   * @link http://php.net/manual/en/iterator.valid.php
   * @return boolean The return value will be casted to boolean and then evaluated.
   * Returns true on success or false on failure.
   */
  public function valid()
  {
    return isset($this->history[$this->position]);
  }

  /**
   * (PHP 5 &gt;= 5.0.0)<br/>
   * Rewind the Iterator to the first element
   * @link http://php.net/manual/en/iterator.rewind.php
   * @return void Any returned value is ignored.
   */
  public function rewind()
  {
    $this->position = 0;
  }
}

<?php
/**
 * Created by IntelliJ IDEA.
 * User: dekokun
 * Date: 2013/01/02
 * Time: 18:49
 *
 */

class View extends Slim\View {
  static protected $_layout = null;

  public static function set_layout($layout = null) {
    self::$_layout = $layout;
  }

  public function render($template) {
    extract($this->data);
    $templatePath = $this->getTemplatesDirectory() . '/' . ltrim($template, '/');
    if (!file_exists($templatePath)) {
      throw new RuntimeException('View cannot render template `' . $templatePath . '`. Template does not exist.');
    }
    ob_start();
    require $templatePath;
    $html = ob_get_clean();
    return $this->_render_layout($html);
  }

  public function _render_layout($_html) {
    extract($this->data);
    if (self::$_layout !== null) {
      $layout_path = $this->getTemplatesDirectory() . '/' . ltrim(self::$_layout, '/');
      if (!file_exists($layout_path)) {
        throw new RuntimeException('View cannot render layout `' . $layout_path . '`. Layout does not exist.');
      }
      ob_start();
      require $layout_path;
      $_html = ob_get_clean();
    }
    return $_html;
  }

}

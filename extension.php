<?php

class KarakeepButtonExtension extends Minz_Extension
{
  #[\Override]
  public function init(): void
  {
    $this->registerTranslates();

    Minz_View::appendScript($this->getFileUrl('script.js', 'js'), false, false, false);
    Minz_View::appendStyle($this->getFileUrl('style.css', 'css'));
    Minz_View::appendScript(strval(_url('karakeepButton', 'jsVars')), false, true, false);

    $this->registerController('karakeepButton');
    $this->registerViews();
  }

  #[\Override]
  public function handleConfigureAction(): void
  {
    $this->registerTranslates();

    if (Minz_Request::isPost()) {
      $instance_url = Minz_Request::paramString('instance_url');
      $api_key = Minz_Request::paramString('api_key');
      $keyboard_shortcut = Minz_Request::paramString('keyboard_shortcut');

      // Handle trailing slash
      if (!empty($instance_url) && substr($instance_url, -1) == '/') {
        $instance_url = substr($instance_url, 0, -1);
      }

      FreshRSS_Context::$user_conf->karakeep_instance_url = $instance_url;
      FreshRSS_Context::$user_conf->karakeep_api_key = $api_key;
      FreshRSS_Context::$user_conf->karakeep_keyboard_shortcut = $keyboard_shortcut;
      FreshRSS_Context::$user_conf->save();
    }
  }
}

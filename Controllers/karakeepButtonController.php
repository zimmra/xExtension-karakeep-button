<?php

class FreshExtension_karakeepButton_Controller extends Minz_ActionController
{
  /** @var KarakeepButton\View */
  protected $view;

  public function jsVarsAction(): void
  {
    $extension = Minz_ExtensionManager::findExtension('Karakeep Button');
    $this->view->karakeep_button_vars = json_encode(array(
      'instance_url' => FreshRSS_Context::$user_conf->karakeep_instance_url ?: '',
      'keyboard_shortcut' => FreshRSS_Context::$user_conf->karakeep_keyboard_shortcut ?: '',
      'icons' => array(
        'added_to_karakeep' => $extension->getFileUrl('added_to_karakeep.svg', 'svg'),
      ),
      'i18n' => array(
        'added_article_to_karakeep' => _t('ext.karakeepButton.notifications.added_article_to_karakeep', '%s'),
        'failed_to_add_article_to_karakeep' => _t('ext.karakeepButton.notifications.failed_to_add_article_to_karakeep', '%s'),
        'ajax_request_failed' => _t('ext.karakeepButton.notifications.ajax_request_failed'),
        'article_not_found' => _t('ext.karakeepButton.notifications.article_not_found'),
      )
    ));

    $this->view->_layout(null);
    $this->view->_path('karakeepButton/vars.js');

    header('Content-Type: application/javascript; charset=utf-8');
  }

  public function addAction(): void
  {
    $this->view->_layout(null);

    $entry_id = Minz_Request::paramString('id');
    $entry_dao = FreshRSS_Factory::createEntryDao();
    $entry = $entry_dao->searchById($entry_id);

    if ($entry === null) {
      echo json_encode(array('status' => 404));
      return;
    }

    $post_data = array(
      'type' => 'link',
      'url' => $entry->link(),
    );

    $result = $this->curlPostRequest("/api/v1/bookmarks", $post_data, true);
    
    // Add the entry title to our response for the notification, without sending it to Karakeep
    if (isset($result['response']) && $result['response'] !== null) {
      $result['response']->title = $entry->title();
    } else {
      // If there's no response from Karakeep, create a minimal response with the title
      $result['response'] = (object) array('title' => $entry->title());
    }
    
    echo json_encode($result);
  }

  private function getRequestHeaders(bool $with_token = false): array
  {
    $headers = array(
      'Content-Type: application/json',
      'Accept: application/json',
    );
    if ($with_token) {
      $api_key = FreshRSS_Context::$user_conf->karakeep_api_key ?: '';
      $headers[] = "Authorization: Bearer " . $api_key;
    }
    return $headers;
  }

  private function getCurlBase(string $url, bool $with_token = false): \CurlHandle
  {
    $headers = $this->getRequestHeaders($with_token);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    return $curl;
  }

  private function curlPostRequest(string $endpoint, array $post_data, bool $with_token = false): array
  {
    $instance_url = FreshRSS_Context::$user_conf->karakeep_instance_url ?: '';
    
    // Handle trailing slash
    if (!empty($instance_url) && substr($instance_url, -1) == '/') {
      $instance_url = substr($instance_url, 0, -1);
    }
    
    $curl = $this->getCurlBase($instance_url . $endpoint, $with_token);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));

    $response = curl_exec($curl);
    $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    $response_header = substr($response, 0, $header_size);
    $response_body = substr($response, $header_size);
    $response_headers = $this->httpHeaderToArray($response_header);

    return array(
      'response' => !empty($response_body) ? json_decode($response_body) : null,
      'status' => curl_getinfo($curl, CURLINFO_HTTP_CODE),
      'errorCode' => isset($response_headers['x-error-code']) ? intval($response_headers['x-error-code']) : curl_getinfo($curl, CURLINFO_HTTP_CODE)
    );
  }

  /**
   * @return array<string,string>
   */
  private function httpHeaderToArray(string $header): array
  {
    $headers = array();
    $headers_parts = explode("\r\n", $header);

    foreach ($headers_parts as $header_part) {
      if (strlen($header_part) <= 0) {
        continue;
      }
      if (strpos($header_part, ':') !== false) {
        $header_name = substr($header_part, 0, intval(strpos($header_part, ':')));
        $header_value = substr($header_part, intval(strpos($header_part, ':')) + 1);
        $headers[$header_name] = trim($header_value);
      }
    }
    return $headers;
  }
}

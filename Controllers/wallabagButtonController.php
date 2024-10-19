<?php

class FreshExtension_wallabagButton_Controller extends Minz_ActionController
{
  public function jsVarsAction()
  {
    $extension = Minz_ExtensionManager::findExtension('Wallabag Button');
    $this->view->wallabag_button_vars = json_encode(array(
      'instance_url' => FreshRSS_Context::$user_conf->wallabag_instance_url,
      'keyboard_shortcut' => FreshRSS_Context::$user_conf->wallabag_keyboard_shortcut,
      'icons' => array(
        'added_to_wallabag' => $extension->getFileUrl('added_to_wallabag.svg', 'svg'),
      ),
      'i18n' => array(
        'added_article_to_wallabag' => _t('ext.wallabagButton.notifications.added_article_to_wallabag', '%s'),
        'failed_to_add_article_to_wallabag' => _t('ext.wallabagButton.notifications.failed_to_add_article_to_wallabag', '%s'),
        'ajax_request_failed' => _t('ext.wallabagButton.notifications.ajax_request_failed'),
        'article_not_found' => _t('ext.wallabagButton.notifications.article_not_found'),
      )
    ));

    $this->view->_layout(false);
    $this->view->_path('wallabagButton/vars.js');

    header('Content-Type: application/javascript; charset=utf-8');
  }

  public function requestAccessAction()
  {
    $instance_url = Minz_Request::param('instance_url', '');
    $client_id = Minz_Request::param('client_id', '');
    $client_secret = Minz_Request::param('client_secret', '');
    $username = Minz_Request::param('username', '');
    $password = Minz_Request::param('password', '');

    FreshRSS_Context::$user_conf->wallabag_instance_url = $instance_url;
    FreshRSS_Context::$user_conf->wallabag_username = $username;
    FreshRSS_Context::$user_conf->wallabag_client_id = $client_id;
    FreshRSS_Context::$user_conf->save();

    $query_params = '?grant_type=password&client_id=' . $client_id . '&client_secret=' . $client_secret . '&username=' . $username . '&password=' . $password;
    $result = $this->curlGetRequest('/oauth/v2/token' . $query_params);

    if ($result['status'] == 200) {
      $access_token = $result['response']->access_token;
      $refresh_token = $result['response']->refresh_token;
      $expires_in = $result['response']->expires_in;

      $this->storeTokens($access_token, $refresh_token, $expires_in);
      FreshRSS_Context::$user_conf->wallabag_client_secret = $client_secret;
      FreshRSS_Context::$user_conf->save();

      $url_redirect = array('c' => 'extension', 'a' => 'configure', 'params' => array('e' => 'Wallabag Button'));
      Minz_Request::good(_t('ext.wallabagButton.notifications.authorized_success'), $url_redirect);
      exit();
    }

    $url_redirect = array('c' => 'extension', 'a' => 'configure', 'params' => array('e' => 'Wallabag Button'));
    Minz_Request::bad(_t('ext.wallabagButton.notifications.request_access_failed', $result['status']), $url_redirect);
  }

  private function isAccessTokenValid()
  {
    return new DateTime() < FreshRSS_Context::$user_conf->wallabag_access_token_expires_at;
  }

  private function refreshAccessToken()
  {
    $client_id = FreshRSS_Context::$user_conf->wallabag_client_id;
    $client_secret = FreshRSS_Context::$user_conf->wallabag_client_secret;
    $refresh_token = FreshRSS_Context::$user_conf->wallabag_refresh_token;

    $query_params = '?grant_type=refresh_token&client_id=' . $client_id . '&client_secret=' . $client_secret . "&refresh_token=" . $refresh_token;
    $result = $this->curlGetRequest('/oauth/v2/token' . $query_params);

    if ($result['status'] == 200) {
      $access_token = $result['response']->access_token;
      $refresh_token = $result['response']->refresh_token;
      $expires_in = $result['response']->expires_in;

      $this->storeTokens($access_token, $refresh_token, $expires_in);
    }

    $url_redirect = array('c' => 'extension', 'a' => 'configure', 'params' => array('e' => 'Wallabag Button'));
    Minz_Request::bad(_t('ext.wallabagButton.notifications.access_token_not_refreshed', $result['status']), $url_redirect);
  }

  public function revokeAccessAction()
  {
    FreshRSS_Context::$user_conf->wallabag_instance_url = '';
    FreshRSS_Context::$user_conf->wallabag_username = '';
    FreshRSS_Context::$user_conf->wallabag_client_id = '';
    FreshRSS_Context::$user_conf->wallabag_client_secret = '';
    FreshRSS_Context::$user_conf->wallabag_access_token = '';
    FreshRSS_Context::$user_conf->wallabag_refresh_token = '';
    FreshRSS_Context::$user_conf->wallabag_access_token_expires_at = '';
    FreshRSS_Context::$user_conf->save();

    $url_redirect = array('c' => 'extension', 'a' => 'configure', 'params' => array('e' => 'Wallabag Button'));
    Minz_Request::forward($url_redirect);
  }

  public function addAction()
  {
    $this->view->_layout(false);

    $entry_id = Minz_Request::param('id');
    $entry_dao = FreshRSS_Factory::createEntryDao();
    $entry = $entry_dao->searchById($entry_id);

    if ($entry === null) {
      echo json_encode(array('status' => 404));
      return;
    }

    $post_data = array(
      'url' => $entry->link(),
    );

    $result = $this->curlPostRequest("/api/entries.html", $post_data, true);
    $result['response'] = array('title' => $entry->title());

    echo json_encode($result);
  }

  private function getRequestHeaders($with_token = false)
  {
    if ($with_token) {
      if (!$this->isAccessTokenValid()) {
        $this->refreshAccessToken();
      }

      $access_token = FreshRSS_Context::$user_conf->wallabag_access_token;
      return array(
        'Content-Type: application/json; charset=UTF-8',
        'X-Accept: application/json',
        "Authorization: Bearer " . $access_token,
      );
    }

    return array(
      'Content-Type: application/json; charset=UTF-8',
      'X-Accept: application/json',
    );
  }

  private function getCurlBase($url, $with_token = false)
  {
    $headers = $this->getRequestHeaders($with_token);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    return $curl;
  }

  private function curlGetRequest($endpoint, $with_token = false)
  {
    $instance_url = FreshRSS_Context::$user_conf->wallabag_instance_url;
    $curl = $this->getCurlBase($instance_url . $endpoint, $with_token);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');

    $response = curl_exec($curl);
    $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    $response_header = substr($response, 0, $header_size);
    $response_body = substr($response, $header_size);
    $response_headers = $this->httpHeaderToArray($response_header);

    return array(
      'response' => json_decode($response_body),
      'status' => curl_getinfo($curl, CURLINFO_HTTP_CODE),
      'errorCode' => isset($response_headers['x-error-code']) ? intval($response_headers['x-error-code']) : curl_getinfo($curl, CURLINFO_HTTP_CODE)
    );
  }

  private function curlPostRequest($endpoint, $post_data, $with_token = false)
  {
    $instance_url = FreshRSS_Context::$user_conf->wallabag_instance_url;
    $curl = $this->getCurlBase($instance_url . $endpoint, $with_token);
    curl_setopt($curl, CURLOPT_POST, true);

    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));

    $response = curl_exec($curl);

    $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    $response_header = substr($response, 0, $header_size);
    $response_body = substr($response, $header_size);
    $response_headers = $this->httpHeaderToArray($response_header);

    return array(
      'response' => json_decode($response_body),
      'status' => curl_getinfo($curl, CURLINFO_HTTP_CODE),
      'errorCode' => isset($response_headers['x-error-code']) ? intval($response_headers['x-error-code']) : curl_getinfo($curl, CURLINFO_HTTP_CODE)
    );
  }

  private function httpHeaderToArray($header)
  {
    $headers = array();
    $headers_parts = explode("\r\n", $header);

    foreach ($headers_parts as $header_part) {
      // skip empty header parts
      if (strlen($header_part) <= 0) {
        continue;
      }

      // Filter the beginning of the header which is the basic HTTP status code
      if (strpos($header_part, ':')) {
        $header_name = substr($header_part, 0, strpos($header_part, ':'));
        $header_value = substr($header_part, strpos($header_part, ':') + 1);
        $headers[$header_name] = trim($header_value);
      }
    }

    return $headers;
  }

  private function storeTokens($access_token, $refresh_token, $expires_in)
  {
    $expires_at = new DateTime();
    $expires_at->modify("+{$expires_in} seconds");

    FreshRSS_Context::$user_conf->wallabag_access_token = $access_token;
    FreshRSS_Context::$user_conf->wallabag_refresh_token = $refresh_token;
    FreshRSS_Context::$user_conf->wallabag_access_token_expires_at = $expires_at;
    FreshRSS_Context::$user_conf->save();
  }
}

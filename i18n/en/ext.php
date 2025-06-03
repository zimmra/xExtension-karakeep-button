<?php

return array(
  'karakeepButton' => array(
    'configure' => array(
      'connect_description' => '
        <ul class="listedNumbers">
          <li>Go to \'<c><karakeep_intance_url>/developer</c>\' by clicking the \'API clients management\' menu</li>
          <li>Create a new API Client with the name of your choice</li>
          <li>Enter your Karakeep instance url</li>
          <li>Enter your \'username\', \'password\', \'client_id\' and \'client_secret\'</li>
          <li>Press \'Connect to Karakeep\'</li>
        </ul>
        <span>Details can be found on <a href="https://github.com/zimmra/xExtension-karakeep-button" target="_blank">GitHub</a>!',
      'connect_to_karakeep' => 'Connect to Karakeep',
      'instance_url' => 'Karakeep instance url',
      'username' => 'Your Karakeep username',
      'password' => 'Your Karakeep password',
      'client_id' => 'Karakeep \'client_id\'',
      'client_secret' => 'Karakeep \'client_secret\'',
      'keyboard_shortcut' => 'Keyboard shortcut',
      'extension_disabled' => 'You need to enable the extension before you can connect to Karakeep!',
      'connected_to_karakeep' => 'You are connected to Karakeep with the account <b>%s</b> at <b>%s</b>.',
      'revoke_access' => 'Disconnect from Karakeep!'
    ),
    'notifications' => array(
      'added_article_to_karakeep' => 'Successfully added <i>\'%s\'</i> to Karakeep!',
      'failed_to_add_article_to_karakeep' => 'Adding article to Karakeep failed! Karakeep API error code: %s',
      'ajax_request_failed' => 'Ajax request failed!',
      'authorized_success' => 'Authorization successful!',
      'authorized_aborted' => 'Authorization aborted!',
      'authorized_failed' => 'Authorization failed! Karakeep API error code: %s',
      'request_access_failed' => 'Access request failed! Karakeep API error code: %s',
      'article_not_found' => 'Can\'t find article!',
    )
  ),
);

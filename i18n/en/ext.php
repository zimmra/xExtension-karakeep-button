<?php

return array(
  'wallabagButton' => array(
    'configure' => array(
      'connect_description' => '
        <ul class="listedNumbers">
          <li>Go to \'<c><wallabag_intance_url>/developer</c>\' by clicking the \'API clients management\' menu</li>
          <li>Create a new API Client with the name of your choice</li>
          <li>Enter your Wallabag instance url</li>
          <li>Enter your \'username\', \'password\', \'client_id\' and \'client_secret\'</li>
          <li>Press \'Connect to Wallabag\'</li>
        </ul>
        <span>Details can be found on <a href="https://github.com/Joedmin/xExtension-wallabag-button" target="_blank">GitHub</a>!',
      'connect_to_wallabag' => 'Connect to Wallabag',
      'instance_url' => 'Wallabag instance url',
      'username' => 'Your Wallabag username',
      'password' => 'Your Wallabag password',
      'client_id' => 'Wallabag \'client_id\'',
      'client_secret' => 'Wallabag \'client_secret\'',
      'keyboard_shortcut' => 'Keyboard shortcut',
      'extension_disabled' => 'You need to enable the extension before you can connect to Wallabag!',
      'connected_to_wallabag' => 'You are connected to Wallabag with the account <b>%s</b> at <b>%s</b>.',
      'revoke_access' => 'Disconnect from Wallabag!'
    ),
    'notifications' => array(
      'added_article_to_wallabag' => 'Successfully added <i>\'%s\'</i> to Wallabag!',
      'failed_to_add_article_to_wallabag' => 'Adding article to Wallabag failed! Wallabag API error code: %s',
      'ajax_request_failed' => 'Ajax request failed!',
      'authorized_success' => 'Authorization successful!',
      'authorized_aborted' => 'Authorization aborted!',
      'authorized_failed' => 'Authorization failed! Wallabag API error code: %s',
      'request_access_failed' => 'Access request failed! Wallabag API error code: %s',
      'article_not_found' => 'Can\'t find article!',
    )
  ),
);

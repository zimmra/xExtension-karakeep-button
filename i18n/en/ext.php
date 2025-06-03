<?php

return array(
  'karakeepButton' => array(
    'configure' => array(
      'instance_url' => 'Karakeep instance URL',
      'api_key' => 'API Key',
      'keyboard_shortcut' => 'Keyboard shortcut',
      'keyboard_shortcut_help' => 'Optional: Single character to use as keyboard shortcut (e.g., "k")',
      'connected_to_karakeep' => 'Extension configured for Karakeep instance: <b>%s</b>',
      'instructions_title' => 'Setup Instructions',
      'instructions' => '
        <p>To use this extension, you need:</p>
        <ol>
          <li>Your Karakeep instance URL (e.g., https://your-karakeep-instance.com)</li>
          <li>Your API key from Karakeep</li>
        </ol>
        <p>Once configured, you can click the Karakeep button next to any article to save it to your Karakeep instance.</p>
        <p>For more details, visit the <a href="https://github.com/zimmra/xExtension-karakeep-button" target="_blank">GitHub repository</a>.</p>
      '
    ),
    'notifications' => array(
      'added_article_to_karakeep' => 'Successfully added <i>\'%s\'</i> to Karakeep!',
      'failed_to_add_article_to_karakeep' => 'Adding article to Karakeep failed! Error code: %s',
      'ajax_request_failed' => 'Request failed!',
      'article_not_found' => 'Article not found!',
    )
  ),
);

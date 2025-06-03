<?php

return array(
  'karakeepButton' => array(
    'configure' => array(
      'connect_description' => '
        <ul class="listedNumbers">
            <li>Navigujte do své Karakeep instance na \'<c><vaše_instance>/developer</c>\'</li>
            <li>Vytvořte nového Klienta API se jménem Vašeho výberu</li>
            <li>Zadejte URL své Karakeep instance.</li>
            <li>Zadejte své \'uživatelské jméno\', \'heslo\', \'client_id\' a \'client_secret\'</li>
            <li>\'Připojit se k Karakeepu\'</li>
        </ul>
      <span>Podrobnosti naleznete na <a href="https://github.com/zimmra/xExtension-karakeep-button" target="_blank">GitHubu</a>!',
      'connect_to_karakeep' => 'Připojit se k Karakeepu',
      'instance_url' => 'URL adresa instance Karakeep',
      'username' => 'Uživatelské jméno',
      'password' => 'Vaše heslo k Karakeep',
      'client_id' => 'Karakeep \'client_id\'',
      'client_secret' => 'Karakeep \'client_secret\'',
      'keyboard_shortcut' => ' Klávesová zkratka',
      'extension_disabled' => 'Před připojením ke službě Karakeep je nutné rozšíření povolit!',
      'connected_to_karakeep' => 'Jste připojeni k Karakeepu skrze účet <b>%s</b> na adrese <b>%s</b>.',
      'revoke_access' => 'Odpojit se od Karakeepu!'
    ),
    'notifications' => array(
      'added_article_to_karakeep' => 'Úspěšně přidán <i>\'%s\'</i> do Karakeepu!',
      'failed_to_add_article_to_karakeep' => 'Přidání článku na Karakeep se nezdařilo! Kód chyby Karakeep API: %s',
      'ajax_request_failed' => 'Požadavek Ajax selhal!',
      'authorized_success' => 'Autorizace proběhla úspěšně!',
      'authorized_aborted' => 'Autorizace přerušena!',
      'authorized_failed' => 'Autorizace selhala! Chyba Karakeep API: %s',
      'request_access_failed' => 'Žádost o přístup se nezdařila! Kód chyby Karakeep API: %s',
      'article_not_found' => 'Nelze najít článek!',
    )
  ),
);

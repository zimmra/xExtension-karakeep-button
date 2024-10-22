<?php

return array(
  'wallabagButton' => array(
    'configure' => array(
      'connect_description' => '
        <ul class="listedNumbers">
            <li>Navigujte do své Wallabag instance na \'<c><vaše_instance>/developer</c>\'</li>
            <li>Vytvořte nového Klienta API se jménem Vašeho výberu</li>
            <li>Zadejte URL své Wallabag instance.</li>
            <li>Zadejte své \'uživatelské jméno\', \'heslo\', \'client_id\' a \'client_secret\'</li>
            <li>\'Připojit se k Wallabagu\'</li>
        </ul>
      <span>Podrobnosti naleznete na <a href="https://github.com/Joedmin/xExtension-wallabag-button" target="_blank">GitHubu</a>!',
      'connect_to_wallabag' => 'Připojit se k Wallabagu',
      'instance_url' => 'URL adresa instance Wallabag',
      'username' => 'Uživatelské jméno',
      'password' => 'Vaše heslo k Wallabag',
      'client_id' => 'Wallabag \'client_id\'',
      'client_secret' => 'Wallabag \'client_secret\'',
      'keyboard_shortcut' => ' Klávesová zkratka',
      'extension_disabled' => 'Před připojením ke službě Wallabag je nutné rozšíření povolit!',
      'connected_to_wallabag' => 'Jste připojeni k Wallabagu skrze účet <b>%s</b> na adrese <b>%s</b>.',
      'revoke_access' => 'Odpojit se od Wallabagu!'
    ),
    'notifications' => array(
      'added_article_to_wallabag' => 'Úspěšně přidán <i>\'%s\'</i> do Wallabagu!',
      'failed_to_add_article_to_wallabag' => 'Přidání článku na Wallabag se nezdařilo! Kód chyby Wallabag API: %s',
      'ajax_request_failed' => 'Požadavek Ajax selhal!',
      'authorized_success' => 'Autorizace proběhla úspěšně!',
      'authorized_aborted' => 'Autorizace přerušena!',
      'authorized_failed' => 'Autorizace selhala! Chyba Wallabag API: %s',
      'request_access_failed' => 'Žádost o přístup se nezdařila! Kód chyby Wallabag API: %s',
      'article_not_found' => 'Nelze najít článek!',
    )
  ),
);

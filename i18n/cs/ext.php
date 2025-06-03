<?php

return array(
  'karakeepButton' => array(
    'configure' => array(
      'instance_url' => 'URL instance Karakeep',
      'api_key' => 'API klíč',
      'keyboard_shortcut' => 'Klávesová zkratka',
      'keyboard_shortcut_help' => 'Volitelné: Jeden znak pro klávesovou zkratku (např. "k")',
      'connected_to_karakeep' => 'Rozšíření nakonfigurováno pro instanci Karakeep: <b>%s</b>',
      'instructions_title' => 'Pokyny k nastavení',
      'instructions' => '
        <p>Pro použití tohoto rozšíření potřebujete:</p>
        <ol>
          <li>URL vaší instance Karakeep (např. https://vase-karakeep-instance.com)</li>
          <li>Váš API klíč z Karakeep</li>
        </ol>
        <p>Po konfiguraci můžete kliknutím na tlačítko Karakeep vedle libovolného článku uložit jej do vaší instance Karakeep.</p>
        <p>Další podrobnosti najdete v <a href="https://github.com/zimmra/xExtension-karakeep-button" target="_blank">repozitáři GitHub</a>.</p>
      '
    ),
    'notifications' => array(
      'added_article_to_karakeep' => 'Úspěšně přidán <i>\'%s\'</i> do Karakeep!',
      'failed_to_add_article_to_karakeep' => 'Přidání článku do Karakeep se nezdařilo! Kód chyby: %s',
      'ajax_request_failed' => 'Požadavek selhal!',
      'article_not_found' => 'Článek nenalezen!',
    )
  ),
);

<?php

return [
    'title' => 'Kulcsszavak',
    'create' => 'Új kulcsszó',
    'edit' => 'Kulcsszó szerkesztése',
    'breadcrumb' => [
        'list' => 'Lista',
        'create' => 'Létrehozás',
        'edit' => 'Szerkesztés',
    ],
    'actions' => [
        'new_keyword' => 'Új kulcsszó',
    ],
    'form' => [
        'name' => 'Név',
        'alias_keyword' => 'Alias kulcsszó',
        'alias_keyword_helper' => 'Ha ez be van állítva, akkor ez a kulcsszó helyettesítve lesz a kiválasztott kulcsszóval.',
        'is_stop_word' => 'Stop szó',
        'is_stop_word_helper' => 'A stop szavak nem kerülnek be a cikkekbe.',
    ],
    'table' => [
        'name' => 'Név',
        'alias_keyword' => 'Alias kulcsszó',
        'is_stop_word' => 'Stop szó',
        'replaced_keywords_count' => 'Helyettesített kulcsszavak',
    ],
    'filters' => [
        'is_stop_word' => 'Stop szó',
        'has_alias' => 'Van alias',
    ],
];


<?php
$GLOBALS['TL_DCA']['tl_news']['fields']['infinite_news_wide'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['infinite_news_wide'],
    'exclude'                 => false,
    'inputType'               => 'checkbox',
    'sql'                     => "char(1) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_news']['fields']['infinite_news_sticky'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['infinite_news_sticky'],
    'exclude'                 => false,
    'inputType'               => 'checkbox',
    'sql'                     => "char(1) NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] = str_replace("featured", "featured,infinite_news_wide,infinite_news_sticky", $GLOBALS['TL_DCA']['tl_news']['palettes']['default']);

?>
<?php

$GLOBALS['TL_DCA'][$strName]['fields']['inf_news_module_id'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['inf_news_module_id'],
    'sql' => 'SMALLINT',
    'inputType' => 'select',
    'foreignKey' => "tl_module.name",
    'eval' => array("multiple" => false)
);

$GLOBALS['TL_DCA'][$strName]['fields']['inf_news_fallback_module'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['inf_news_fallback_module'],
    'sql' => 'SMALLINT',
    'inputType' => 'select',
    'foreignKey' => "tl_module.name",
    'eval' => array("multiple" => false)
);

$GLOBALS['TL_DCA'][$strName]['palettes']['infiniteNews'] = "{type_legend},type;headline;inf_news_module_id,inf_news_fallback_module";

?>
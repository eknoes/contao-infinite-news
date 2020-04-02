<?php
namespace Eknoes\ContaoInfiniteNewsBundle\Module;

use BackendTemplate;
use Contao\ContentElement;

/**
 * Class InfiniteNewsModul
 *
 * @copyright  cfaed 2017
 * @author     Sönke Huster
 * @package    Devtools
 */
class InfiniteNewsModule extends ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'fe_infinite_news';


    /**
     * Compile the content element
     */
    protected function compile()
    {

        if (TL_MODE == 'BE') {
            $this->genBeOutput();
        } else {
            $this->genFeOutput();
        }
    }

    /**
     * Generates the Backend Output
     */
    private function genBeOutput()
    {
        $this->strTemplate = 'be_wildcard';
        $this->Template = new BackendTemplate($this->strTemplate);
        $this->Template->title = $this->title;
        $wildcard = "<i>Infinite News Element</i><br />";

        $this->Template->wildcard = $wildcard;

    }

    /**
     * Generates the frontend output
     */
    private function genFeOutput()
    {
            $this->Template = new BackendTemplate($this->strTemplate);

            $this->Template->moduleId = $this->inf_news_module_id;
            $this->Template->fallbackModule = $this->inf_news_fallback_module;
    }
}

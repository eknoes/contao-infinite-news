<?php
namespace Eknoes\ContaoInfiniteNewsBundle\Module;

use Contao\ModuleNews;
use Contao\NewsModel;

/*
 * Module Class for compiling StickyArticles
 */
class StickyArticle extends ModuleNews
{

    public $news_template = "news_latest_infinite";
    /*
     * Normally fetched from Database, so we have to add this
     */
    var $news_metaFields = "a:1:{i:0;s:4:\"date\";}";

    public function compileSticky()
    {
        $cols = ["tl_news.pid IN (" . implode(",", $this->news_archives) . ")", "tl_news.infinite_news_sticky='1'"];

        $sticky = NewsModel::findBy($cols, "1");
        if($sticky == null) {
            return null;
        }

        return $this->parseArticles($sticky);
    }

    protected function parseArticles($objArticles, $blnAddArchive = true)
    {
        $limit = $objArticles->count();

        if ($limit < 1) {
            return array();
        }

        $count = 0;
        $arrArticles = array();

        while ($objArticles->next()) {
            /** @var \NewsModel $objArticle */
            $objArticle = $objArticles->current();

            $arrArticles[] = json_decode($this->parseArticle($objArticle, $blnAddArchive, ((++$count == 1) ? ' first' : '') . (($count == $limit) ? ' last' : '') . ((($count % 2) == 0) ? ' odd' : ' even'), $count));
        }

        return $arrArticles;
    }

    /**
     * Compile the current element
     */
    protected function compile()
    {

    }

    public function generate()
    {
        $stickyIds = [];
        $articles = [];

        if (\Input::get("sticky") == 1) {
            $stickyArt = $this->compileSticky();

            foreach ($stickyArt as $sticky) {
                $stickyIds[] = $sticky->id;
            }

            $articles = $stickyArt;
        }

        foreach ($this->articles as $article) {
            if (in_array(json_decode($article)->id, $stickyIds)) {
                continue;
            }
            $articles[] = json_decode($article);
        }

        return json_encode(array("articles" => $articles, "sticky_ids" => $stickyIds));
    }
}
?>
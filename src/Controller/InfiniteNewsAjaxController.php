<?php
namespace Eknoes\ContaoInfiniteNews\Controller;

use Contao\Input;
use Contao\ModuleModel;
use Contao\NewsModel;
use Contao\System;
use Eknoes\ContaoInfiniteNews\Module\StickyArticle;
use Symfony\Component\HttpFoundation\JsonResponse;

class InfiniteNewsAjaxController extends \Contao\Controller {

    /**
     * Compile the current element
     */
    public function __invoke()
    {
        $stickyIds = [];

        $stickyArticles = new StickyArticle(new ModuleModel());
        $stickyArticles->news_archives = $this->news_archives;
        $this->news_template = "news_latest_infinite";

        $stickyArt = $stickyArticles->compileSticky();

        foreach ($stickyArt as $sticky) {
            $stickyIds[] = $sticky->id;
        }

        if (Input::get("sticky") == 1) {
            $arr = $stickyArt;
        }

        foreach ($this->articles as $article) {
            if (in_array(json_decode($article)->id, $stickyIds)) {
                continue;
            }
            $arr[] = json_decode($article);
        }


        return new JSONResponse(array("articles" => $arr, "sticky_ids" => $stickyIds));
    }

    /**
     * Compile the current element
     */
    protected function compile()
    {
        // TODO: Implement compile() method.
    }
}
?>
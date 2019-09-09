<?php
namespace Eknoes\ContaoInfiniteNews\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class InfiniteNewsAjaxController {

    public function __invoke()
    {
        return new JsonResponse(["Hello World"]);
    }
}
?>
<?php
declare(strict_types = 1);

namespace Ppro\Hw27\App\Commands;

use Ppro\Hw27\App\Application\Request;

class DefaultCommand extends Command
{
    public function execute(Request $request)
    {
        if($request->isPost())
            $this->handlePost($request);
        else
            $this->handleGet($request);
    }

    private function handlePost(Request $request)
    {

    }
    private function handleGet(Request $request)
    {
        $request->setContent('title', 'Main');
    }
}

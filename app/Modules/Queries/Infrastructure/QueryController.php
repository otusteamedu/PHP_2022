<?php

declare(strict_types=1);

namespace App\Modules\Queries\Infrastructure;

use App\Http\Controllers\Controller;
use App\Modules\Queries\Application\CreateQueryAction;
use App\Modules\Queries\Application\GetQueryModel;
use App\Modules\Queries\Domain\Query;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    public function create(Request $request): array
    {
        $validated = $this->validate($request, [
            'name' => 'required|string',
        ]);
        $res = CreateQueryAction::run($validated['name']);

        return ['id' => $res];
    }

    public function show(int $id): Query
    {
        return GetQueryModel::getById($id);
    }
}

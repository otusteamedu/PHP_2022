<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Contracts\FetchBankStatementForClientInterface;
use App\Http\Gateway\ClientBankStatementGateway;
use App\Application\Contracts\GetBankStatementInterface;
use App\Application\Actions\BankStatement\GetBankStatementAction;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(FetchBankStatementForClientInterface::class, ClientBankStatementGateway::class);
        $this->app->bind(GetBankStatementInterface::class, GetBankStatementAction::class);
    }
}

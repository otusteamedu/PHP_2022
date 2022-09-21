<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Contracts\FetchBankStatementForClientInterface;
use App\Http\Gateway\ClientBankStatementGateway;
use App\Application\Contracts\GetBankStatementInterface;
use App\Application\Actions\BankStatement\GetBankStatementAction;
use App\Application\Contracts\SendTextTelegramMessageInterface;
use App\Application\Actions\TelegramMessage\SendTextTelegramMessageAction;
use App\Application\Contracts\SendTextEmailMessageInterface;
use App\Application\Actions\EmailMessage\SendTextEmailMessageAction;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(FetchBankStatementForClientInterface::class, ClientBankStatementGateway::class);
        $this->app->bind(GetBankStatementInterface::class, GetBankStatementAction::class);
        $this->app->bind(SendTextTelegramMessageInterface::class, SendTextTelegramMessageAction::class);
        $this->app->bind(SendTextEmailMessageInterface::class, SendTextEmailMessageAction::class);
    }
}

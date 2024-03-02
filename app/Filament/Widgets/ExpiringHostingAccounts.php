<?php

namespace App\Filament\Widgets;

use App\Models\HostingAccount;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ExpiringHostingAccounts extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn() => HostingAccount::expiringIn30Days()->with(['mainDomain', 'plan', 'client'])
            )
            ->columns([
                Tables\Columns\TextColumn::make('mainDomain.name')
					->label('Account')
					->description(fn(HostingAccount $account) => $account->plan->name)
					->weight(FontWeight::Bold),
				Tables\Columns\TextColumn::make('client.name')
					->label('Client'),
				Tables\Columns\TextColumn::make('expiring_at')
					->description(fn(HostingAccount $account) => $account->expiring_at->diffForHumans())
					->date(),
            ]);
    }
}

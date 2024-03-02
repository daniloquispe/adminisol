<?php

namespace App\Filament\Widgets;

use App\Models\Domain;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ExpiringDomains extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn() => Domain::expiringIn30Days()
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
					->label('Domain')
					->weight(FontWeight::Bold),
				Tables\Columns\TextColumn::make('client.name')
					->label('Client'),
				Tables\Columns\TextColumn::make('expiring_at')
					->description(fn(Domain $domain) => $domain->expiring_at->diffForHumans())
					->date(),
            ]);
    }
}

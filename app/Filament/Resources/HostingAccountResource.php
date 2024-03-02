<?php

namespace App\Filament\Resources;

use App\Enums\HostingAccountStatus;
use App\Filament\Resources\HostingAccountResource\Pages;
use App\Filament\Resources\HostingAccountResource\RelationManagers;
use App\Models\Domain;
use App\Models\HostingAccount;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HostingAccountResource extends Resource
{
    protected static ?string $model = HostingAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-server';

	private static function domains(): array
	{
		return Domain::query()
			->select(['id', 'name'])
			->orderBy('name')
			->pluck('name', 'id')
			->toArray();
	}

	private static function statuses(): array
	{
		return collect(HostingAccountStatus::cases())->pluck('name', 'value')->toArray();
	}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
				// Basic info
				Forms\Components\Section::make('Basic info')
					->columns()
					->schema([
						// Main domain
						Forms\Components\Select::make('main_domain_id')
							->label('Main domain')
							->helperText('If account has multiple domains, this domain will be used for cPanel and Webmail URLs')
							->options(fn() => self::domains())
							->required()
							->searchable()
							->preload(),
						// Client
						Forms\Components\Select::make('client_id')
							->relationship('client', 'name')
							->required()
							->searchable()
							->preload(),
						// Hosting plan
						Forms\Components\Select::make('plan_id')
							->relationship('plan', 'name')
							->required(),
						// Status
						Forms\Components\Select::make('status')
							->options(self::statuses())
							->required(),
						// Notes
						Forms\Components\Textarea::make('notes')
							->autosize(),
					]),
				// Custom URLs
				Forms\Components\Section::make('Custom URLs')
					->description('In case you want to use custom (unique) URLs for cPanel and/or Webmail')
					->columns()
					->schema([
						// cPanel
						Forms\Components\TextInput::make('cpanel_custom_url')
							->url()
							->label('cPanel')
							->helperText('Default: https://www.your-domain.com:2083'),
						// Webmail
						Forms\Components\TextInput::make('webmail_custom_url')
							->url()
							->label('Webmail')
							->helperText('Default: https://www.your-domain.com:2096'),
					]),
				// Key dates
				Forms\Components\Section::make('Key dates')
					->columns(3)
					->schema([
						// Registration
						Forms\Components\DatePicker::make('registered_at')
							->maxDate(now()),
						// Expiration
						Forms\Components\DatePicker::make('expiring_at'),
						// Termination
						Forms\Components\DatePicker::make('terminated_at')
							->maxDate(now()),
					]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
				// Main domain
				Tables\Columns\TextColumn::make('mainDomain.name')
					->weight(FontWeight::Bold)
					->searchable()
					->sortable(),
				// Client
				Tables\Columns\TextColumn::make('client.name')
					->searchable()
					->sortable(),
				// Hosting plan
				Tables\Columns\TextColumn::make('plan.name')
					->searchable()
					->sortable(),
				// Status
				Tables\Columns\TextColumn::make('status')
					->badge()
					->color(fn($state): string => match ($state)
					{
						HostingAccountStatus::Active => 'success',
						HostingAccountStatus::Suspended => 'warning',
						HostingAccountStatus::Terminated => 'danger',
						default => 'gray'
					})
					->formatStateUsing(fn($state) => $state->name)
					->sortable(),
            ])
            ->filters([
				// Filter by date
				Tables\Filters\SelectFilter::make('client_id')
					->label('Client')
					->relationship('client', 'name')
					->searchable()
					->preload(),
				// Filter by hosting plan
				Tables\Filters\SelectFilter::make('plan_id')
					->label('Plan')
					->relationship('plan', 'name'),
				// Filter by status
				Tables\Filters\SelectFilter::make('status')
					->options(self::statuses())
            ])
            ->actions([
				// Go to cPanel
				Action::make('link_cpanel')
					->icon('heroicon-m-link')
					->link()
					->label('cPanel')
					->url(fn(HostingAccount $account) => $account->cpanelUrl, true)
					->disabled(fn(HostingAccount $account) => $account->status !== HostingAccountStatus::Active),
				// Go to Webmail
				Action::make('link_webmail')
					->icon('heroicon-m-link')
					->link()
					->label('Webmail')
					->url(fn(HostingAccount $account) => $account->webmailUrl, true)
					->disabled(fn(HostingAccount $account) => $account->status !== HostingAccountStatus::Active),
				// Edit
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHostingAccounts::route('/'),
            'create' => Pages\CreateHostingAccount::route('/create'),
            'edit' => Pages\EditHostingAccount::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Actions\SendRenewalNotification;
use App\Filament\Resources\RenewalResource\Pages;
use App\Filament\Resources\RenewalResource\RelationManagers;
use App\Mail\RenewalNotification;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Contact;
use App\Models\Renewal;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class RenewalResource extends Resource
{
    protected static ?string $model = Renewal::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

	/**
	 * Get a list of enabled bank accounts.
	 *
	 * You can specify a bank ID via the $bankId parameter or use NULL for a complete accounts list.
	 *
	 * @param int|null $bankId
	 * @return Collection<BankAccount>
	 */
	private static function getBankAccounts(int|null $bankId = null): Collection
	{
		return BankAccount::query()
			->select(['id', 'bank_id', 'number'])
			->where('is_active', true)
			->when($bankId, fn(Builder $query) => $query->whereRelation('bank', 'id', $bankId))
			->with('bank:id,name')
			->get();
	}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
				// Section: Basic info
				Forms\Components\Section::make('Basic info')
					->columns()
					->schema([
						// Customer
						Forms\Components\Select::make('customer_id')
							->label('Customer')
							->relationship('customer', 'name')
							->searchable()
							->required(),
						// Due date
						Forms\Components\DatePicker::make('due_at')
							->required(),
					]),
				// Section: Key dates
				Forms\Components\Section::make('Key dates')
					->columns(3)
					->visibleOn('edit')
					->schema([
						Forms\Components\DatePicker::make('notification_sent_at')
							->maxDate(Carbon::today()),
						Forms\Components\DatePicker::make('payment_verified_at')
							->maxDate(Carbon::today())
							->live(),
						Forms\Components\DatePicker::make('renewed_at')
							->maxDate(Carbon::today()),
					]),
				// Section: Payment info
				Forms\Components\Section::make('Payment info')
					->columns()
					->visibleOn('edit')
					->visible(fn(Forms\Get $get): bool => $get('payment_verified_at') !== null)
					->schema([
						// Bank
						Forms\Components\Select::make('bank_id')
							->label('Bank')
							->options(Bank::all()->pluck('name', 'id'))
							->placeholder('No bank')
							->live()
							->dehydrated(false),
						// Bank account
						Forms\Components\Select::make('bank_account_id')
							->label('Bank account')
							->helperText('Account must be active in bank accounts manager')
							->options(function (Forms\Get $get)
							{
								$bankId = $get('bank_id');

								return $bankId
									? static::getBankAccounts($bankId)->pluck('number', 'id')
									: [];
							})
							->disabled(fn(Forms\Get $get): bool => $get('bank_id') == null)
							->required(fn(Forms\Get $get): bool => $get('bank_id') != null),
					]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
//			->recordClasses(fn(Renewal $record) => $record->is_overdue ? 'bg-red-100' : null)
            ->columns([
				// Due date
				Tables\Columns\TextColumn::make('due_at')
					->description(fn(Renewal $record): string => $record->due_at->diffForHumans())
					->date(),
				// Customer
				Tables\Columns\TextColumn::make('customer.name'),
				// Total amount
				Tables\Columns\TextColumn::make('amount')
					->money('PEN'),
				// Status
				Tables\Columns\TextColumn::make('status')
					->badge(),
				// Contacts (as list of avatars)
				Tables\Columns\ImageColumn::make('customer.activeBillingContacts.avatar_filename')
					->label('Notify to')
					->circular()
					->stacked()
					->defaultImageUrl(fn(Contact $contact) => $contact->default_avatar_filename)
					->extraImgAttributes(fn(Renewal $renewal) => $renewal->customer->activeBillingContacts()->count() ? [] : ['style' => 'display: none']),
            ])
            ->filters([
				// Filter by customer
				Tables\Filters\SelectFilter::make('customer_id')
					->label('Customer')
					->relationship('customer', 'name')
					->searchable(),
            ])
            ->actions([
				// Notify by e-mail
				Action::make('notify')
					->icon('heroicon-o-envelope')
					->modalContent(function (Renewal $record)
					{
						$bankAccounts = static::getBankAccounts();

						return new HtmlString((new RenewalNotification('[contact name]', $record, $bankAccounts))->render());
					})
//					->action(fn (Renewal $record) => (new SendRenewalNotification())->execute($record))
					->action(function (SendRenewalNotification $notifyAction, Renewal $record)
					{
						$notifyAction->execute($record, static::getBankAccounts());

						// Notification
						Notification::make()
							->title('Sent')
							->body('Notification sent to customer contacts')
							->success()
							->send();
					})
					->disabled(fn(Renewal $record): bool => $record->customer->activeBillingContacts()->doesntExist())
					->requiresConfirmation()
					->modalDescription('Here is an e-mail notification preview:')
					->modalWidth(MaxWidth::FiveExtraLarge)
					->modalSubmitActionLabel('Send notification'),
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
			RelationManagers\DomainsRelationManager::class,
			RelationManagers\HostingAccountsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRenewals::route('/'),
            'create' => Pages\CreateRenewal::route('/create'),
            'edit' => Pages\EditRenewal::route('/{record}/edit'),
        ];
    }
}

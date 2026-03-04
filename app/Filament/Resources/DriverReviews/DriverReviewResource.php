<?php

namespace App\Filament\Resources\DriverReviews;

use App\Filament\Resources\DriverReviews\Pages\CreateDriverReview;
use App\Filament\Resources\DriverReviews\Pages\EditDriverReview;
use App\Filament\Resources\DriverReviews\Pages\ListDriverReviews;
use App\Filament\Resources\DriverReviews\Pages\ViewDriverReview;
use App\Filament\Resources\DriverReviews\Schemas\DriverReviewForm;
use App\Filament\Resources\DriverReviews\Schemas\DriverReviewInfolist;
use App\Filament\Resources\DriverReviews\Tables\DriverReviewsTable;
use App\Models\DriverReview;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DriverReviewResource extends Resource
{
    protected static ?string $model = DriverReview::class;

    public static function getNavigationGroup(): ?string
    {
        return __('Reviews');
    }

    public static function getLabel(): ?string
    {
        return __('Driver Review');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Driver Reviews');
    }

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    public static function form(Schema $schema): Schema
    {
        return DriverReviewForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DriverReviewInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DriverReviewsTable::configure($table);
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
            'index' => ListDriverReviews::route('/'),
            'create' => CreateDriverReview::route('/create'),
            'view' => ViewDriverReview::route('/{record}'),
            'edit' => EditDriverReview::route('/{record}/edit'),
        ];
    }
}

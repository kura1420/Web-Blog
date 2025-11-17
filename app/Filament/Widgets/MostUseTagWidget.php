<?php

namespace App\Filament\Widgets;

use App\Models\Tag;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class MostUseTagWidget extends TableWidget
{
    protected function getTableQuery(): Builder
    {
        return Tag::query()
            ->select('tags.id', 'tags.name', DB::raw('COUNT(post_tags.id) as total'))
            ->join('post_tags', 'tags.id', '=', 'post_tags.tag_id')
            ->groupBy('tags.id', 'tags.name')
            ->orderByDesc('total')
            ->limit(10);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => $this->getTableQuery())
            ->columns([
                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('total')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}

<?php

namespace Briefley\SearchResultsPage\Traits;

use Filament\GlobalSearch\GlobalSearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait PaginatesSearchResults
{
    public static function getGlobalSearchResults(string $search): Collection
    {
        $query = static::getGlobalSearchEloquentQuery();

        static::applyGlobalSearchAttributeConstraints($query, $search);

        static::modifyGlobalSearchQuery($query, $search);

        $totalRecords = (clone $query)->count();

        $pageStr = request('categoryPage', '');
        $category = \Str::slug(static::getPluralLabel(), '_');
        $page = 1;

        if ($pageStr) {
            $parsed = [];
            parse_str($pageStr, $parsed);
            $page = isset($parsed[$category]) ? (int) $parsed[$category] : 1;
        }

        $page = max(1, $page);
        $perPage = 10;

        $offset = ($page - 1) * $perPage;

        return $query
            ->offset($offset)
            ->limit($perPage)
            ->get()
            ->map(function (Model $record) use ($totalRecords): ?GlobalSearchResult {
                $url = static::getGlobalSearchResultUrl($record);

                if (blank($url)) {
                    return null;
                }

                $details = static::getGlobalSearchResultDetails($record);
                $details['totalRecords'] = $totalRecords;

                return new GlobalSearchResult(
                    title: static::getGlobalSearchResultTitle($record),
                    url: $url,
                    details: $details,
                    actions: static::getGlobalSearchResultActions($record),
                );
            })
            ->filter();
    }
}

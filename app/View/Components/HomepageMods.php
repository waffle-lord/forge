<?php

namespace App\View\Components;

use App\Models\Mod;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class HomepageMods extends Component
{
    public function render(): View
    {
        return view('components.homepage-mods', [
            'featured' => [
                'title' => __('Featured Mods'),
                'mods' => $this->fetchFeaturedMods(),
                'link' => '/mods?featured=only',
            ],
            'latest' => [
                'title' => __('Newest Mods'),
                'mods' => $this->fetchLatestMods(),
                'link' => '/mods',
            ],
            'updated' => [
                'title' => __('Recently Updated Mods'),
                'mods' => $this->fetchUpdatedMods(),
                'link' => '/mods?order=updated',
            ],
        ]);
    }

    /**
     * Fetches the featured mods homepage listing.
     */
    private function fetchFeaturedMods(): Collection
    {
        return Cache::flexible('homepage-featured-mods', [5, 10], function () {
            return Mod::whereFeatured(true)
                ->with([
                    'latestVersion',
                    'latestVersion.latestSptVersion',
                    'users:id,name',
                    'license:id,name,link',
                ])
                ->inRandomOrder()
                ->limit(6)
                ->get();
        });
    }

    /**
     * Fetches the latest mods homepage listing.
     */
    private function fetchLatestMods(): Collection
    {
        return Cache::flexible('homepage-latest-mods', [5, 10], function () {
            return Mod::orderByDesc('created_at')
                ->with([
                    'latestVersion',
                    'latestVersion.latestSptVersion',
                    'users:id,name',
                    'license:id,name,link',
                ])
                ->limit(6)
                ->get();
        });
    }

    /**
     * Fetches the recently updated mods homepage listing.
     */
    private function fetchUpdatedMods(): Collection
    {
        return Cache::flexible('homepage-updated-mods', [5, 10], function () {
            return Mod::orderByDesc('updated_at')
                ->with([
                    'latestUpdatedVersion',
                    'latestUpdatedVersion.latestSptVersion',
                    'users:id,name',
                    'license:id,name,link',
                ])
                ->limit(6)
                ->get();
        });
    }
}

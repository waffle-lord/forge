<?php

use App\Models\Mod;
use App\Models\ModVersion;
use App\Models\SptVersion;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('displays homepage mod cards with the latest supported spt version number', function () {
    $sptVersion1 = SptVersion::factory()->create(['version' => '1.0.0']);
    $sptVersion2 = SptVersion::factory()->create(['version' => '2.0.0']);
    $sptVersion3 = SptVersion::factory()->create(['version' => '3.0.0']);

    $mod1 = Mod::factory()->create();
    ModVersion::factory()->recycle($mod1)->create(['spt_version_constraint' => $sptVersion1->version]);
    ModVersion::factory()->recycle($mod1)->create(['spt_version_constraint' => $sptVersion1->version]);
    ModVersion::factory()->recycle($mod1)->create(['spt_version_constraint' => $sptVersion2->version]);
    ModVersion::factory()->recycle($mod1)->create(['spt_version_constraint' => $sptVersion2->version]);
    ModVersion::factory()->recycle($mod1)->create(['spt_version_constraint' => $sptVersion3->version]);
    ModVersion::factory()->recycle($mod1)->create(['spt_version_constraint' => $sptVersion3->version]);

    $response = $this->get(route('home'));

    $response->assertSeeInOrder(explode(' ', "$mod1->name $sptVersion3->version_formatted"));
});

it('displays the latest version on the mod detail page', function () {
    $versions = [
        '1.0.0',
        '1.1.0',
        '1.2.0',
        '2.0.0',
        '2.1.0',
    ];
    $latestVersion = max($versions);

    $mod = Mod::factory()->create();
    foreach ($versions as $version) {
        ModVersion::factory()->recycle($mod)->create(['version' => $version]);
    }

    $response = $this->get($mod->detailUrl());

    expect($latestVersion)->toBe('2.1.0');

    // Assert the latest version is next to the mod's name
    $response->assertSeeInOrder(explode(' ', "$mod->name $latestVersion"));

    // Assert the latest version is in the latest download button
    $response->assertSeeText(__('Download Latest Version')." ($latestVersion)");
});
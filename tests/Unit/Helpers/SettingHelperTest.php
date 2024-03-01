<?php

namespace Unit\Helpers;

use App\Helpers\Setting;
use App\Models\Setting as SettingModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class SettingHelperTest extends TestCase
{
    protected SettingModel $settingModel;

    protected function setUp(): void
    {
        parent::setUp();
        $settingModel = Setting::create(
            'test',
            "Test title",
            10
        );
        $this->settingModel = $settingModel;
    }

    public function testGetSettingSuccess(): void
    {
        $this->assertInstanceOf(SettingModel::class, Setting::getSetting('test'));
    }

    public function testGetSettingModelNotFoundException(): void
    {
        $this->expectException(ModelNotFoundException::class);
        Setting::getSetting('abc');
    }

    public function testGetValueSuccess(): void
    {
        $this->assertTrue(10 === Setting::getValue('test'));
    }

    public function testExistTrue(): void
    {
        $this->assertTrue(Setting::exists('test'));
    }

    public function testExistFalse(): void
    {
        $this->assertFalse(Setting::exists('test1'));
    }

    public function testHasActive(): void
    {
        $this->assertTrue(Setting::hasActive('test'));

        Setting::disable('test');
        $this->assertFalse(Setting::hasActive('test'));

        Setting::enable('test');
        $this->assertTrue(Setting::hasActive('test'));
    }
}

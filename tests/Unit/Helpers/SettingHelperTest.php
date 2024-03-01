<?php

namespace Unit\Helpers;

use App\Exceptions\Setting\SettingDisabledException;
use App\Exceptions\Setting\SettingInvalidTypeException;
use App\Exceptions\Setting\SettingNotFoundException;
use App\Helpers\Setting\Setting;
use App\Helpers\Setting\SettingsTypesEnum;
use App\Models\Setting as SettingModel;
use Tests\TestCase;

class SettingHelperTest extends TestCase
{
    protected SettingModel $settingModel;

    /**
     * @throws SettingInvalidTypeException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $settingModel = Setting::create(
            'test',
            "Test title",
            "int",
            "10"
        );
        $this->settingModel = $settingModel;
    }

    public function testCreateInvalidTypeException(): void
    {
        $this->expectException(SettingInvalidTypeException::class);
        Setting::create(
            'tst',
            'title',
            'aaaaaa',
            'aasasas'
        );
    }

    /**
     * @throws SettingNotFoundException
     */
    public function testGetSettingSuccess(): void
    {
        $this->assertInstanceOf(SettingModel::class, Setting::getSetting('test'));
    }

    public function testGetSettingError(): void
    {
        $this->expectException(SettingNotFoundException::class);
        Setting::getSetting('abc');
    }

    /**
     * @throws SettingDisabledException
     * @throws SettingNotFoundException
     */
    public function testGetValueSuccess(): void
    {
        $this->assertTrue(10 === Setting::getValue('test'));
    }

    /**
     * @throws SettingNotFoundException
     * @throws SettingDisabledException
     */
    public function testGetValueDisabledException(): void
    {
        Setting::disable('test');
        $this->expectException(SettingDisabledException::class);
        Setting::getValue('test');
    }

    /**
     * @throws SettingDisabledException
     * @throws SettingNotFoundException
     */
    public function testGetValueError(): void
    {
        $this->assertFalse("10" === Setting::getValue('test'));
    }

    public function testExistTrue(): void
    {
        $this->assertTrue(Setting::exists('test'));
    }

    public function testExistFalse(): void
    {
        $this->assertFalse(Setting::exists('test1'));
    }

    /**
     * @throws SettingInvalidTypeException
     * @throws SettingNotFoundException
     * @throws SettingDisabledException
     */
    public function testSetIntSuccess(): void
    {
        Setting::set('test', 20, SettingsTypesEnum::INT->value);
        $this->assertTrue(20 === Setting::getValue('test'));
    }

    /**
     * @throws SettingInvalidTypeException
     * @throws SettingNotFoundException
     * @throws SettingDisabledException
     */
    public function testSetFloatSuccess(): void
    {
        Setting::set('test', 1.5, SettingsTypesEnum::FLOAT->value);
        $this->assertTrue(1.5 === Setting::getValue('test'));
    }

    /**
     * @throws SettingInvalidTypeException
     * @throws SettingNotFoundException
     * @throws SettingDisabledException
     */
    public function testSetBoolSuccess(): void
    {
        Setting::set('test', true, SettingsTypesEnum::BOOL->value);
        $this->assertTrue(Setting::getValue('test'));

        Setting::set('test', false, SettingsTypesEnum::BOOL->value);
        $this->assertFalse(Setting::getValue('test'));
    }

    /**
     * @throws SettingInvalidTypeException
     * @throws SettingNotFoundException
     * @throws SettingDisabledException
     */
    public function testSetDateSuccess(): void
    {
        $now = SettingsTypesEnum::parse(SettingsTypesEnum::DATE->value, now());
        Setting::set('test', $now, SettingsTypesEnum::DATE->value);
        $this->assertTrue($now === Setting::getValue('test'));
    }

    /**
     * @throws SettingDisabledException
     * @throws SettingInvalidTypeException
     * @throws SettingNotFoundException
     */
    public function testSetTimeSuccess(): void
    {
        $now = SettingsTypesEnum::parse(SettingsTypesEnum::TIME->value, now());
        Setting::set('test', $now, SettingsTypesEnum::TIME->value);
        $this->assertTrue($now === Setting::getValue('test'));
    }

    /**
     * @throws SettingNotFoundException
     * @throws SettingDisabledException
     * @throws SettingInvalidTypeException
     */
    public function testSetDateTimeSuccess(): void
    {
        $now = SettingsTypesEnum::parse(SettingsTypesEnum::DATETIME->value, now());
        Setting::set('test', $now, SettingsTypesEnum::DATETIME->value);
        $this->assertTrue($now === Setting::getValue('test'));
    }

    /**
     * @throws SettingNotFoundException
     */
    public function testSetValueWithInvalidType(): void
    {
        $this->expectException(SettingInvalidTypeException::class);
        Setting::set('test', 1, 'abbb');
    }

    /**
     * @throws SettingNotFoundException
     */
    public function testHasActive(): void
    {
        $this->assertTrue(Setting::hasActive('test'));

        Setting::disable('test');
        $this->assertFalse(Setting::hasActive('test'));

        Setting::enable('test');
        $this->assertTrue(Setting::hasActive('test'));
    }
}

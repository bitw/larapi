<?php

use App\Models\Passport\Client;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Client::query()->create([
            'id' => '9b812051-8e41-4702-8be6-437bfbf8f920',
            'name' => 'dasboard',
            'secret' => 'Bmnez3Mml9xDqNSaCOzc5z8KNyu5irUheM40uo6m',
            'provider' => 'user',
            'redirect' => 'http://localhost',
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Client::query()
            ->where('id', '9b812051-8e41-4702-8be6-437bfbf8f920')
            ->where('name', 'dasboard')
            ->where('secret', 'Bmnez3Mml9xDqNSaCOzc5z8KNyu5irUheM40uo6m')
            ->delete();
    }
};

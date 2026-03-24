<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Passport v13 expects client secrets to be Bcrypt-hashed.
     * Previously they were stored as plain text; re-hash them here.
     */
    public function up(): void
    {
        DB::table('oauth_clients')
            ->whereNotNull('secret')
            ->lazyById()
            ->each(function (object $client) {
                // Skip secrets that are already a bcrypt hash.
                if (str_starts_with($client->secret, '$2y$') || str_starts_with($client->secret, '$2b$')) {
                    return;
                }

                DB::table('oauth_clients')
                    ->where('id', $client->id)
                    ->update(['secret' => Hash::make($client->secret)]);
            });
    }

    /**
     * Reverse the migrations.
     *
     * Bcrypt is a one-way hash; plain-text secrets cannot be recovered.
     * Clients that relied on the old plain-text secrets will need new secrets issued.
     */
    public function down(): void
    {
        // Intentionally left empty — bcrypt hashes cannot be reversed.
    }
};

<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Passport;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->after('user_id', function (Blueprint $table) {
                $table->string('owner_type')->nullable();
                $table->string('owner_id')->nullable();
                $table->index(['owner_type', 'owner_id']);
            });

            $table->after('provider', function (Blueprint $table) {
                $table->text('redirect_uris')->nullable();
                $table->text('grant_types')->nullable();
            });
        });

        foreach (Passport::client()->cursor() as $client) {
            Model::withoutTimestamps(fn() => $client->forceFill([
                'owner_id' => $client->user_id,
                'owner_type' => $client->user_id
                    ? config('auth.providers.' . ($client->provider ?: config('auth.guards.api.provider')) . '.model')
                    : null,
                'redirect_uris' => $client->redirect_uris,
                'grant_types' => $client->grant_types,
            ])->save());
        }

        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'redirect', 'personal_access_client', 'password_client']);

            $table->text('redirect_uris')->nullable(false)->change();
            $table->text('grant_types')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->dropIndex(['owner_type', 'owner_id']);
            $table->dropColumn(['owner_type', 'owner_id']);

            $table->after('provider', function (Blueprint $table) {
                $table->string('redirect')->nullable();
                $table->boolean('personal_access_client');
                $table->boolean('password_client');
            });
        });

        foreach (Passport::client()->cursor() as $client) {
            Model::withoutTimestamps(fn() => $client->forceFill([
                'user_id' => $client->owner_id,
                'redirect' => $client->redirect_uris,
                'personal_access_client' => str_contains($client->grant_types, 'personal_access'),
                'password_client' => str_contains($client->grant_types, 'password'),
            ])->save());
        }

        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->string('redirect')->nullable(false)->change();
            $table->boolean('personal_access_client')->change();
            $table->boolean('password_client')->change();
        });
    }
};

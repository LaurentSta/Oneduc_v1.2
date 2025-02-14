<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Crée une colonne 'id' de type BIGINT (AUTO_INCREMENT).
            $table->string('name'); // Crée une colonne 'name' de type VARCHAR.
            $table->string('username')->nullable(); // Crée une colonne 'username' de type VARCHAR qui peut être NULL.
            $table->string('email')->unique(); // Crée une colonne 'email' de type VARCHAR avec une contrainte UNIQUE.
            $table->timestamp('email_verified_at')->nullable(); // Crée une colonne 'email_verified_at' de type TIMESTAMP qui peut être NULL.
            $table->string('password'); // Crée une colonne 'password' de type VARCHAR.
            $table->string('photo')->nullable(); // Crée une colonne 'photo' de type VARCHAR qui peut être NULL.
            $table->string('phone')->nullable(); // Crée une colonne 'phone' de type VARCHAR qui peut être NULL.
            $table->string('address')->nullable(); // Crée une colonne 'address' de type VARCHAR qui peut être NULL.
            $table->enum('role',['admin','instructor','user'])->default('user'); // Crée une colonne 'role' de type ENUM avec des valeurs possibles 'admin', 'instructor', 'user' et une valeur par défaut 'user'.
            $table->enum('status',['1','0'])->default('1'); // Crée une colonne 'status' de type ENUM avec des valeurs possibles '1', '0' et une valeur par défaut '1'.
            $table->rememberToken(); // Crée une colonne 'remember_token' de type VARCHAR pour la fonctionnalité "remember me".
            $table->timestamps(); // Crée deux colonnes 'created_at' et 'updated_at' de type TIMESTAMP pour les horodatages.
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

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
        Schema::create('users', function (Blueprint $t) {
            $t->id();

            // cadastro (passo 1)
            $t->string('nome');
            $t->date('data_nasc')->nullable();
            $t->decimal('peso', 5, 2)->nullable();    // ex.: 99.50
            $t->decimal('altura', 4, 2)->nullable();  // ex.: 1.75
            $t->string('tipo_sangue', 5)->nullable(); // ex.: O+, A-
            $t->string('caminho_foto')->nullable();   // caminho da foto no storage

            // cadastro2 (passo 2)
            $t->string('cep', 9)->nullable();
            $t->string('logradouro')->nullable();
            $t->string('numero')->nullable();
            $t->string('bairro')->nullable();
            $t->string('cidade')->nullable();

            // cadastro3 (passo 3)
            $t->string('email')->unique();
            $t->string('senha'); // será armazenada com hash

            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

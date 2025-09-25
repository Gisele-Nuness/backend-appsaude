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

            $t->string('nome');
            $t->date('data_nasc')->nullable();
            $t->decimal('peso', 5, 2)->nullable();
            $t->decimal('altura', 4, 2)->nullable();
            $t->string('tipo_sangue', 5)->nullable();
            $t->string('caminho_foto')->nullable();

            $t->string('cep', 9)->nullable();
            $t->string('logradouro')->nullable();
            $t->string('numero')->nullable();
            $t->string('bairro')->nullable();
            $t->string('cidade')->nullable();

            
            $t->string('email')->unique();
            $t->string('senha');

            $t->softDeletes();
            
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

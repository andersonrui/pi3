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
        Schema::create('produtos_vendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venda_id');
            $table->foreign('venda_id')->references('id')->on('vendas');
            $table->foreignId('produto_id');
            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->integer('quantidade');
            $table->float('valor_unitario', 6, 2);
            $table->float('desconto', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos_vendas');
    }
};

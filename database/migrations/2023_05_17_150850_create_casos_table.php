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
        Schema::create('casos', function (Blueprint $table) {
            $table->id();
            $table->string('num_caso');
            $table->text('investigado');
            $table->text('agraviado');
            $table->enum('status',['activo','pagado','cancelado','cambio abogado','paso juzgado','concilio']);
            $table->unsignedBigInteger('fiscal_id');
            $table->foreign('fiscal_id')->references('id')->on('fiscals')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casos');
    }
};

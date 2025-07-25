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
        Schema::create('redemptions', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('member_id');
    $table->integer('points_used');
    $table->decimal('discount_amount', 8, 2);
    $table->timestamps();

    $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redemptions');
    }
};

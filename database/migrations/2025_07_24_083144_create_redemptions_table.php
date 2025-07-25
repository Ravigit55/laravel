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
    $table->foreignId('member_id')->constrained('members');
    $table->integer('points_used');
    $table->decimal('discount_amount', 10, 2);
    $table->timestamps();
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

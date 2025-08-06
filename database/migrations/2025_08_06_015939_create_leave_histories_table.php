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
        Schema::create('leave_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('leave_request_id');
            $table->foreign('leave_request_id')->references('id')->on('leave_requests')->onDelete('cascade');
            $table->uuid('changed_by');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('cascade');
            $table->enum('from_status', ['pending', 'approved', 'rejected']);
            $table->enum('to_status', ['pending', 'approved', 'rejected']);
            $table->text('note')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_histories');
    }
};

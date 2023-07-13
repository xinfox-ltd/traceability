<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dosage_form_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128)->default('')->comment('名称');
            $table->string('remark')->default('')->comment('备注');
            $table->timestamps();
            $table->comment('剂型类别');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosage_form_categories');
    }
};

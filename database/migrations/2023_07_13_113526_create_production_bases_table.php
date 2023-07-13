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
        Schema::create('production_bases', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('type')->default(0)
                ->comment('基地类型：1生产基地 2加工基地');
            $table->string('name', 128)->default('')->comment('基地名称');
            $table->string('base_no')->default('')->comment('基地编号');
            $table->string('director', 32)->default('')->comment('负责人');
            $table->string('phone', 64)->default('')->comment('联系电话');
            $table->string('township')->default('')->comment('乡镇');
            $table->smallInteger('village_num')->default(0)->comment('自然村数量');
            $table->unsignedInteger('farmer_num')->default(0)->comment('农户数量');
            $table->timestamps();
            $table->comment('生产基地');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_bases');
    }
};

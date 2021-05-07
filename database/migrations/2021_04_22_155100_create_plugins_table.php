<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('repository_url');
            $table->string('developer')->nullable();
            $table->string('install_path');
            $table->string('wiki_url')->nullable();
            $table->string('info_url')->nullable();
            $table->string('requested_by')->nullable();
            $table->string('requester')->nullable();
            $table->string('year_added')->nullable();
            $table->foreignId('category_id')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugins');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('branch_id');
            $table->longText('description')->nullable();
            $table->timestamps();
        });

        // Pivot table:
        Schema::create('collection_plugins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('collection_id');
            $table->unsignedBigInteger('plugin_id');
            $table->timestamps();

            // Make sure that they are unique.
            $table->unique(['collection_id', 'plugin_id']);

            // Foreign key restraints
//            $table->foreign('collection_id')->references('id')->on('collections')->onDelete('cascade');
//            $table->foreign('commit_id')->references('id')->on('commits')->onDelete('cascade');

            $table->foreign('collection_id')
                ->references('id')
                ->on('collections')
                ->onDelete('cascade');
            $table->foreign('plugin_id')
                ->references('id')
                ->on('plugins')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections');
    }
}

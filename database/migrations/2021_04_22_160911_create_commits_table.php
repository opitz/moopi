<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plugin_id');
            $table->string('commit_id');
            $table->string('tag')->nullable();
            $table->string('version')->nullable();

            $table->timestamps();

            // foreign key constraints: delete any Commit when the referring Plugin is deleted
            $table->foreign('plugin_id')
                ->references('id')
                ->on('plugins')
                ->onDelete('cascade');
        });

        // Pivot table:
        Schema::create('collection_commits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('collection_id');
            $table->unsignedBigInteger('commit_id');
            $table->timestamps();

            // Make sure that they are unique.
            $table->unique(['collection_id', 'commit_id']);

            // Foreign key restraints
//            $table->foreign('collection_id')->references('id')->on('collections')->onDelete('cascade');
//            $table->foreign('commit_id')->references('id')->on('commits')->onDelete('cascade');

            $table->foreign('collection_id')
                ->references('id')
                ->on('collections')
                ->onDelete('cascade');
            $table->foreign('commit_id')
                ->references('id')
                ->on('commits')
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
        Schema::dropIfExists('commits');
        Schema::dropIfExists('collection_commits');
        Schema::dropIfExists('collection_commit');
    }
}

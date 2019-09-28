<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateAlbumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("albums", function (Blueprint $table) {
            $table->uuid('id');
            $table->string('title');
            $table->uuid('artist_id');
            $table->integer('release_date')->nullable();
            $table->date('listened_at');
            $table->integer('rating');
            $table->boolean('was_imported_from_google_sheets')->default(false);
            $table->timestamps();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("albums");
    }
}

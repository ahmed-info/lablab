<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_cards', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ss_num')->nullable();
            $table->string('full_name');
            $table->enum("gender", ["ذكر", "انثى"]);
            $table->date('birth_date');
            $table->date('release_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->bigInteger('national_number');
            $table->string('mother_name');
            $table->string('company_name');
            $table->longtext('location');
            $table->string('card_img');
            $table->longtext('qr_code')->nullable();
            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
           //$table->foreign('company_id')->references('lot_id')->on('companies')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_cards');
    }
}

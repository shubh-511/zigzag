<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('dl_image');
            $table->string('dl_doc_no');
            $table->string('dl_exp_date');
            $table->integer('dl_status');
            $table->string('ssc_image');
            $table->string('ssc_doc_no');
            $table->string('ssc_exp_date');
            $table->integer('ssc_status');
            $table->string('insurance_image');
            $table->string('insurance_doc_no');
            $table->string('insurance_exp_date');
            $table->integer('insurance_status');
            $table->string('certification_image');
            $table->string('certification_doc_no');
            $table->string('certification_exp_date');
            $table->integer('certification_status');
            $table->string('cvd_image');
            $table->string('cvd_doc_no');
            $table->string('cvd_exp_date');
            $table->integer('cvd_status');
            $table->integer('status');
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
        Schema::dropIfExists('user_documents');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tokens', function (Blueprint $table) {
            $table->dropForeign(['pick_detail_id']);
            $table->dropColumn('pick_detail_id');
            $table->string('phone')->after('id');
            $table->string('code');
            $table->integer('uses')->unsigned()->after('code')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tokens' , function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('code', 4);
            $table->dropColumn('uses');
            $table->dropColumn('phone');
        });
    }
};

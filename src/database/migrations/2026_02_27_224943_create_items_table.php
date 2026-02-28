<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // 出品者ID
            $table->string('name'); // 商品名
            $table->integer('price'); // 価格
            $table->string('brand')->nullable(); // ブランド名（任意）
            $table->text('description'); // 商品説明
            $table->string('condition'); // コンディション
            $table->string('image_url')->nullable(); // 画像のパス
            // 他にも「状態」や「カテゴリ」が必要になりますが、まずはシンプルに
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
        Schema::dropIfExists('items');
    }
}

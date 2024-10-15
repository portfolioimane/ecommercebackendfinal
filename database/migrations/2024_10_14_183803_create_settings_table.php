<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
 public function up()
{
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->string('type'); // e.g., 'stripe', 'paypal', etc.
        $table->string('key'); // e.g., 'api_key', 'api_secret', etc.
        $table->text('value')->nullable(); // Making value nullable
        $table->boolean('is_enabled')->default(false); // Add this line
        $table->timestamps();

        // Adding unique composite key for type and key
        $table->unique(['type', 'key']);
    });
}


    public function down()
    {
        Schema::dropIfExists('settings');
    }
}

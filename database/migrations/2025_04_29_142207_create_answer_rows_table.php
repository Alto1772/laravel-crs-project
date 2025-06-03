<?php

use App\Models\AnswerRow;
use App\Models\Questionnaire;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answer_rows', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Questionnaire::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::table('answers', function (Blueprint $table) {
            $table->after('choice_id', function (Blueprint $table) {
                $table->foreignIdFor(AnswerRow::class)->constrained()->cascadeOnDelete();
            });
            $table->foreignId('question_id')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_rows');
        Schema::table('answers', function (Blueprint $table) {
            $table->dropForeignIdFor(AnswerRow::class);
            $table->foreignId('question_id')->nullable(false)->change();
        });
    }
};

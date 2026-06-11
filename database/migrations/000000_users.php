<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return new class {
    public function up(Builder $schema)
    {
        if (!$schema->hasTable('users')) {
            $schema->create('users', function (Blueprint $table) {
                $table->id();
                $table->string('user_id', 64)->nullable()->comment('Идентификатор авторизованного пользователя в приложении Яндекса');
                $table->string('application_id', 64)->comment('Идентификатор приложения откуда общается пользователь');
                $table->timestamps();

                $table->index('user_id');
                $table->index('application_id');

                $table->unique(['user_id', 'application_id']);
            });
        }
    }

    public function down(Builder $schema)
    {
        $schema->dropIfExists('users');
    }
};

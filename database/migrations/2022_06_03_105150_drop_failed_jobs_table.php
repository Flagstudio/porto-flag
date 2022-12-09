<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DropFailedJobsTable extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('failed_jobs');
    }

    public function down(): void
    {
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\Admin;

class AddAdminData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $admin = new Admin;
      $admin->username = 'admin';
      $admin->password = 'adminaxiamarket';
      $admin->save();
      $admin = new Admin;
      $admin->username = 'nissa';
      $admin->password = 'adminaxiamarket';
      $admin->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}

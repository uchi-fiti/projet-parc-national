<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
    public function test()
    {
        $db = db_connect();

        try {
            $db->query('SELECT * FROM pointsparcs');

            echo 'Connected';
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
    public function map() {
        return view("maps/index");
    }
}

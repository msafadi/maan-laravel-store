<?php

namespace App\Repositories;

interface CartRepository
{
    function all();

    function add($item, $quantity = 1);

    function total();

    function empty();
}
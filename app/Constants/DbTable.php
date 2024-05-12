<?php

namespace App\Constants;

enum DbTable: string
{
  case ORDERS = 'orders';
  case LINE_ITEMS = 'line_items';
}
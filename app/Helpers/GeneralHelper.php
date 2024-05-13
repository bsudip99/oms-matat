<?php

use Carbon\Carbon;

function getEnumCasesArray($cases)
{
  foreach ($cases as $case) {
    $caseArray[] = $case->value;
  }
  return $caseArray;
}

function deleteDataDate()
{
  return Carbon::now()->subMonths(config('api.parameters.delete_unused_in_months'));
}

<?php

function getEnumCasesArray($cases)
{
  foreach ($cases as $case) {
    $caseArray[] = $case->value;
  }
  return $caseArray;
}

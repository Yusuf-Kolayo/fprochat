<?php

/**
 * this sanitizes user inputs mwith
 * 
 * -- mysqli_real_escape_string
 * -- strip_tags
 * -- trim
 */
  function sanitize_var ($conn, $var) {
      $var = mysqli_real_escape_string($conn, strip_tags(trim($var)));
      return $var;
  }
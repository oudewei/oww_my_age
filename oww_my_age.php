<?php

/**
 * Plugin Name: My Age 
 * Plugin URI: https://github.com/oudewei/oww_my_age
 * Description: Calculate the current age using a birthdate and the systemdate
 * Author: Oude Wei Webdesign
 * Version: 0.0.1
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 */

if (!defined('ABSPATH')) {
  die;
}

class OwwMyAge {

  public function __construct() {

    if ( !shortcode_exists( 'my_age' ) ) {
      add_shortcode('my_age', array($this, 'oww_my_age'));
    }

    }

  function oww_my_age ($atts = []) {

    if (!isset($atts['birthdate'])) {
      return '&lt;no birthdate attribute set&gt;';
    }

    $oww_specified_date  = $atts['birthdate'];

    if (empty($oww_specified_date)) {
      return '&lt;birthdate is empty&gt;';
    }

    $oww_birthdate = date_create(sanitize_text_field($oww_specified_date));

    if (!$oww_birthdate) {
      return '&lt;Invalid date format in birthday&gt;';
    }

    $oww_current_date = date_create();

    if ($oww_birthdate > $oww_current_date) {
      return '&lt;Birthdate is in the future&gt;';
    }

    $oww_my_age   = date_diff($oww_birthdate, $oww_current_date);

    return $oww_my_age->format('%y');
  }
}

new OwwMyAge;

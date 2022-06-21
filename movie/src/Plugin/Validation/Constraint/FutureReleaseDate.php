<?php

/**
 * @file FutureReleaseDate.php
 * Message for the Release Date constraint.
 */

namespace Drupal\movie\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Checks that the submitted value is a valid release date.
 *
 * @Constraint(
 *   id = "FutureReleaseDate",
 *   label = @Translation("Valid release Date", context = "Validation"),
 *   type = "string"
 * )
 */
class FutureReleaseDate extends Constraint {

  // The message that will be shown if the release date value is valid.
  public $isFuture = 'Release Date value "%value" should not be in future.';

}

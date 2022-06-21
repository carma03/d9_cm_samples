<?php

/**
 * @file FutureReleaseDateValidator.php
 * Constraint validator for the Release Date field.
 */

namespace Drupal\movie\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the Release Date constraint.
 */
class FutureReleaseDateValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($value, Constraint $constraint) {
    if (!empty($value->getString())) {
      if ($this->isFuture($value->getString())) {
        $this->context->addViolation($constraint->isFuture, ['%value' => $value->getString()]);
      }
    }
  }

  /**
   * Checks if Release Date is in future.
   *
   * @param string $value
   */
  private function isFuture($value) {
    $release_date = strtotime($value);
    if ($release_date > time()) {
      return TRUE;
    }

    return FALSE;
  }

}

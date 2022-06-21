<?php

/**
 * @file MovieContentEntityNormalizer.php
 * Normalize the Movie custom Entity.
 */

namespace Drupal\movie\Normalizer;

use Drupal\serialization\Normalizer\EntityNormalizer;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Normalizes Movie custom enntity into an array structure.
 */
class MovieContentEntityNormalizer extends EntityNormalizer {

  /**
   * The interface or class that this Normalizer supports.
   *
   * @var string
   */
  protected $supportedInterfaceOrClass = ContentEntityInterface::class;

  /**
   * {@inheritdoc}
   */
  public function normalize($entity, $format = NULL, array $context = array()) {
    $attributes = parent::normalize($entity, $format, $context);

    $included_fields = [
      'id',
      'title',
      'release_date',
      'genre',
    ];
    $attributes = array_intersect_key($attributes, array_flip($included_fields));

    $values = [];
    foreach($attributes as $key => $value) {
      if (isset($value[0]) && isset($value[0]['value'])) {
        if ($key === 'release_date') {
          $values[$key] = date('d-m-Y', strtotime($value[0]['value']));
        } else {
          $values[$key] = $value[0]['value'];
        }
      }
    }

    return $values;
  }

}

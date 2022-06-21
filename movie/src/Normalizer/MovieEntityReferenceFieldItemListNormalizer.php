<?php

/**
 * @file MovieEntityReferenceFieldItemListNormalizer.php
 * Normalize the Genre taxonomy field of the Movie custom Entity.
 */


namespace Drupal\movie\Normalizer;

use Drupal\Core\Field\EntityReferenceFieldItemList;
use Drupal\serialization\Normalizer\ComplexDataNormalizer;
use Drupal\serialization\Normalizer\FieldItemNormalizer;

use Drupal\taxonomy\Entity\Term;


/**
 * Normalize the Genre taxonomy field.
 *
 */
class MovieEntityReferenceFieldItemListNormalizer extends ComplexDataNormalizer {

  /**
   * {@inheritdoc}
   */
  protected $supportedInterfaceOrClass = EntityReferenceFieldItemList::class;

  /**
   * {@inheritdoc}
   */
  public function normalize($object, $format = NULL, array $context = []) {
    $attributes = [];
    $entities = $object->referencedEntities();

    foreach($entities as $entity) {
      if ($entity instanceof Term) {
        $attributes[] = [
          'value' => $entity->label() ?? '',
        ];
      }
    }

    return empty($attributes) ? NULL : $attributes;
  }

}

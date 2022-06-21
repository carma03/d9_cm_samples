<?php

/**
 * @file Movie.php
 * Provides Movie custom entity definition and fields.
 */

namespace Drupal\movie\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\movie\MovieInterface;

/**
 * Defines the movie entity class.
 *
 * @ContentEntityType(
 *   id = "movie",
 *   label = @Translation("Movie"),
 *   label_collection = @Translation("Movies"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\movie\MovieListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\movie\MovieAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\movie\Form\MovieForm",
 *       "edit" = "Drupal\movie\Form\MovieForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "movie",
 *   admin_permission = "administer movie",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "title",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/entity/movie/add",
 *     "canonical" = "/movie/{movie}",
 *     "edit-form" = "/admin/entity/movie/{movie}/edit",
 *     "delete-form" = "/admin/entity/movie/{movie}/delete",
 *     "collection" = "/admin/content/movies"
 *   },
 *   field_ui_base_route = "entity.movie.settings"
 * )
 */
class Movie extends ContentEntityBase implements MovieInterface {

  /**
   * {@inheritdoc}
   */
  public function getTitle() {
    return $this->get('title')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setTitle($title) {
    $this->set('title', $title);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setDescription(t('The title of the movie entity.'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('view', TRUE);

      $fields['release_date'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Release Date'))
      ->setDescription(t('Release date of the movie, it cannot be in the future.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'datetime_type' => 'date',
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('form', [
        'type' => 'datetime_default',
        'weight' => 1,
      ])
      ->setRequired(TRUE)
      ->addConstraint('FutureReleaseDate')
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'datetime_default',
        'settings' => [
          'format_type' => 'html_date',
        ],
        'weight' => 1,
      ])
      ->setDisplayConfigurable('view', TRUE);

      $fields['genre'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Genre'))
      ->setDescription(t('The genre of the movie.'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler', 'default:taxonomy_term')
      ->setSetting('handler_settings', [
        'target_bundles' => ['genre' => 'genre'],
        'auto_create' => TRUE,
      ])
      ->setRequired(FALSE)
      ->setTranslatable(FALSE)
      ->setDisplayOptions('view', [
        'label' => 'visible',
        'type' => 'entity_reference_label',
        'weight' => 2,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 2,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'autocomplete_type' => 'tags',
          'size' => '60',
          'placeholder' => 'Enter here a genre name...',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE);

    return $fields;
  }

}

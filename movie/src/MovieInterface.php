<?php

namespace Drupal\movie;

use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Provides an interface defining a movie entity type.
 */
interface MovieInterface extends ContentEntityInterface {

  /**
   * Gets the movie title.
   *
   * @return string
   *   Title of the movie.
   */
  public function getTitle();

  /**
   * Sets the movie title.
   *
   * @param string $title
   *   The movie title.
   *
   * @return \Drupal\movie\MovieInterface
   *   The called movie entity.
   */
  public function setTitle($title);

}

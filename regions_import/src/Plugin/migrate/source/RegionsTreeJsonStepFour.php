<?php

/**
 * @filename: RegionsTreeJsonStepFour.php
 * @author Carlos Puello <carlospuello03@gmail.com>
 */

namespace Drupal\regions_import\Plugin\migrate\source;
use Drupal\migrate\Plugin\migrate\source\SourcePluginBase;

/**
* Source plugin to import data from JSON files.
* @MigrateSource(
*   id = "regions_tree_json_step_four"
* )
*/
class RegionsTreeJsonStepFour extends SourcePluginBase {
  private $regions = [];

  /**
   * Initializes the iterator with the source data.
   *
   * @return \Iterator
   *   Returns an iteratable object of data for this source.
   */
  public function initializeIterator() {
    $rows = json_decode(file_get_contents($this->configuration['path']), true);
    foreach ($rows as $key => $row) {
      $this->getChildren($row);
    }

    // Migrate needs an Iterator class, not just an array.
    return new \ArrayIterator($this->regions);
  }

  public function fields() {
    return [
      'name' => $this->t('name'),
      'path' => $this->t('path')
    ];
  }

  public function getIDs() {
    return ['path' => ['type' => 'string']];
  }

  public function __toString() {
    return "json data";
  }

  private function getChildren(array $rows) {
    if (isset($rows['name']) && isset($rows['path'])) {
      $this->regions[] = [
          'name' => $rows['name'],
          'path' => $rows['path'],
          'parent' => $this->formatParentPath($rows['path'])
      ];
    }

    if (isset($rows['children'])) {
      foreach($rows['children'] as $key => $row) {
        $this->getChildren($row, $this->regions);
      }
    }

    return;
  }

  /**
   * Format the parent id using the path value.
   *
   * @param String $regionPath
   * @return String
   *   The parent path
   */
  private function formatParentPath($regionPath) {
    $regionPath = explode('/', $regionPath);
    unset($regionPath[count($regionPath)-1]);

    return implode('/', $regionPath);
  }

}

<?php

/**
 * @file
 * Contains Drupal\reservations\Entity\Season.
 *
 */

namespace Drupal\reservations\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Season bundle entity.
 *
 * @ConfigEntityType(
 *   id = "season",
 *   label = @Translation("Season"),
 *   admin_permission = "administer seasons",
 *   bundle_of = "reservation",
 *   config_prefix = "season",
 *   handlers = {
 *     "list_builder" = "Drupal\reservations\SeasonListBuilder",
 *     "form" = {
 *       "add" = "Drupal\reservations\Form\SeasonForm",
 *       "edit" = "Drupal\reservations\Form\SeasonForm",
 *       "delete" = "Drupal\reservations\Form\SeasonDeleteForm"
 *     }
 *   },
 *   entity_keys = {
 *     "id" = "year",
 *   },
 *   links = {
 *     "edit-form" = "/admin/reservation/seasons/manage/{season}",
 *     "delete-form" = "/admin/reservation/seasons/manage/{season}/delete",
 *     "collection" = "/admin/reservation/seasons",
 *   },
 *   config_export = {
 *     "year",
 *     "start_date",
 *     "end_date",
 *     "opening_date",
 *   }
 * )
 */
class Season extends ConfigEntityBundleBase {


  /**
   * The Season year.
   *
   * @var string
   */
  public $year;

  public $start_date;
  
  public $end_date;
  
  public $opening_date;
  
  public $price = array();
  
    /**
   * {@inheritdoc}
   */
  public function id() {
    return $this->year;
  }

}

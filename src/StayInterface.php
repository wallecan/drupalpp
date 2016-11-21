<?php

namespace Drupal\reservations;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Stay entities.
 *
 * @ingroup reservations
 */
interface StayInterface extends  ContentEntityInterface, EntityChangedInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Stay creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Stay.
   */
  public function getCreatedTime();

  /**
   * Sets the Stay creation timestamp.
   *
   * @param int $timestamp
   *   The Stay creation timestamp.
   *
   * @return \Drupal\reservations\Entity\StayInterface
   *   The called Stay entity.
   */
  public function setCreatedTime($timestamp);

}

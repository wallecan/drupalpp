<?php
/**
 * @file
 * Contains \Drupal\reservations\ReservationInterface.
 */

namespace Drupal\reservations;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

interface ReservationInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}

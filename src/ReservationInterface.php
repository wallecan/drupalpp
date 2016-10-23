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

  /**
   * The reservation has been submitted by the reservation holder
   */
  const SUBMITTED = 0;

  /**
   * The reservation has been handled and a room has been assigned to
   */
  const ACCEPTED = 1;

  /**
   * The down payment has been payed but there is something missing
   */
  const CONFIRMED = 2;

  /**
   * The balance is paid, reservation is complete
   */
  const COMPLETED = 3;

  /**
   * The reservation has been canceled by the reservation team
   */
  const CANCELED = 4;

  /**
   * The reservation is not possible within the given period.
   * It is placed on hold
   */
  const QUEUED = 5;

}

<?php
/**
 * @file
 * Contains \Drupal\reservations\Controller\ReservationsController.
 */

namespace Drupal\reservations\Controller;

use Drupal\Core\Controller\ControllerBase;

class ReservationsController extends ControllerBase {
  public function content() {
    return array(
        '#type' => 'markup',
        '#markup' => $this->t('Hello, World!'),
    );
  }
}

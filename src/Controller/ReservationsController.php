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
  
  /**
   * Returns a form to add a new reservation.
   *
   * @return array
   *   The reservation add form.
   */
  public function addForm() {

  $form = $this->formBuilder()->getForm('\Drupal\reservations\Form\ReservationAddForm');

  /**
   * Create a fresh Reservation entity
   * TODO: implement getCurentSeason() and error page when not applicable
   * $season = $this->entityManager()->getStorage('season')->getCurentSeason();
   */
    //$reservation = $this->entityManager()->getStorage('reservation')->create(array('season' => '2015'));
    // Get form from the EntityForm
    //$form = $this->entityFormBuilder()->getForm($reservation, 'add');
    
    return $form;
  }
}

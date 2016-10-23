<?php
/**
 * @file
 * Contains Drupal\reservations\Form\ReservationForm.
 */

namespace Drupal\reservations\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Language\Language;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form handler  for the reservation entity edit forms.
 *
 * @ingroup reservations
 */
class ReservationForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {

    $reservation = $this->entity;
    $season_id = $reservation->season->target_id;

    $form['season'] = array(
      '#type' => 'value',
      '#value' => $season_id,
    );
    
    return parent::form($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $form_state->setRedirect('entity.reservation.collection');
    $entity = $this->getEntity();
    $entity->save();
  }
}

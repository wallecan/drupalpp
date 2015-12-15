<?php
/**
 * @file
 * Contains Drupal\reservations\Form\SeasonForm.
 */

namespace Drupal\reservations\Form;

use Drupal\Core\Entity\ConfigEntityForm;
use Drupal\Core\Language\Language;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the season entity edit forms.
 *
 * @ingroup reservations
 */
class SeasonForm extends BundleEntityFormBase {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    //$entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $form_state->setRedirect('entity.season.list');
    $entity = $this->getEntity();
    $entity->save();
  }
}

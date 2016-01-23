<?php
/**
 * @file
 * Contains Drupal\reservations\Form\SeasonForm.
 */

namespace Drupal\reservations\Form;

use Drupal\Core\Entity\BundleEntityFormBase;
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
    //$form = parent::form($form, $form_state);

    $entity = $this->entity;

    //TODO: implement season form
    $form['not_implemented'] = array(
      '#type' => 'markup',
      '#markup' => $this->t('Season form not implemented yet'),
    );

    $form['year'] = array(
      '#type' => 'value',
      '#value' => $entity->id(),
    );

    // Protect form against change
    $this->protectBundleIdElement($form);
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

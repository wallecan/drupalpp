<?php
/**
 * @file
 * Contains Drupal\reservations\Form\ReservationAddForm.
 */

namespace Drupal\reservations\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ReservationAddForm.
 * @package Drupal\reservations\Form
 * @ingroup reservations
 */
class ReservationAddForm extends FormBase {

  private $currentStep;

  private $steps = [
    1 => 'Etape 1: Période',
    2 => 'Etape 2: Séjournants',
    3 => 'Etape 3: Résumé',
    4 => 'Etape 3: Paiement',
  ];

  private function getCurrentStep(FormStateInterface $form_state) {
    if (!$this->currentStep) {
      $this->currentStep = $form_state->has('reservation_step') ? $form_state->get('reservation_step') : 1;
    }
    return $this->currentStep;
  }

  private function setCurrentStep(FormStateInterface $form_state, $step) {
    $form_state->set('reservation_step', $step);
    $this->currentStep = $step;
  }

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'reservations_add_form';
  }

  /**
   * Define the form used for.
   * @return array
   *   Form definition array.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param FormStateInterface $form_state
   *   An associative array containing the current state of the form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $currentStep = $this->getCurrentStep($form_state);

    $form['#title'] = $this->steps[$currentStep];
    
    switch($currentStep) {
      case 1:
        $form = $this->step1($form, $form_state);
        break;
      case 2:
        $form = $this->step2($form, $form_state);
        break;
      default:
        $form['#markup'] = '<p>Not implemented yet</p>';
        break;
    }
    
    if ($currentStep < count($this->steps))
      $value = 'Suivant';
    else
      $value = 'SUBMIT';
    
    
    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => $value,
    );
    
    return $form;
  }

  private function step1($form, FormStateInterface $form_state) {


    $form['accept_conditions'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('I read and accept the terms of service'),
    );

    return $form;
  }

  protected function step2($form, FormStateInterface $form_state) {

    $user = $this->currentUser();


    $form['contact_settings'] = array(
      '#markup' => '<p>' . $this->t('This page will add a serie of reservations') . '</p>'
    );

    $form['personal_info'] = array(
      '#type' => 'fieldset',
      '#title' => 'Personal informations',
    );

    $form['personal_info']['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Name'),
    );

    $form['personal_info']['first_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Fist Name'),
    );

    $form['personal_info']['mail'] = array(
      '#type' => 'email',
      '#title' => t('Email'),
    );

    return $form;
    
  }

  /**
   * Form submission handler.
   *
   * @param FormStateInterface $form
   *   An associative array containing the structure of the form.
   * @param array $form_state
   *   An associative array containing the current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
    $currentStep = $this->getCurrentStep($form_state);

    if ($currentStep < count($this->steps)) {
      $form_state->setRebuild(TRUE);
      $this->setCurrentStep($form_state, ++$currentStep);
      drupal_set_message("Nous sommes à l'étape: " . $currentStep);
      
    }
    else {
      drupal_set_message('La réservation a bien été enregistrée');
      $form_state->setRedirect('view.my_reservations.page_1');
    }
  }

}

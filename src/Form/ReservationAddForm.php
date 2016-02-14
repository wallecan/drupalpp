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

  private $steps = [
    1 => 'Etape 1',
    2 => 'Etape 2',
    3 => 'Etape 3',
  ];
  
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
    $currentStep = $form_state->has('reservation_step') ? $form_state->get('reservation_step') : 1;
    //$currentStep = $form_state->get('reservation_step');
    $form['#title'] = $this->steps[$currentStep];
    
    switch($currentStep) {
      case 1:
        $form = $this->step1($form, $form_state);
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

  protected function step1($form, FormStateInterface $form_state) {
    $form_state->set('reservation_step', 1);
    
    $user = $this->currentUser();


    $form['contact_settings'] = array(
      '#markup' => '<p>' . $this->t('This page will add a serie of reservations') . '</p>'
    );
    
    $form['accept_conditions'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('I read and accept the terms of service'),
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
    
    $currentStep = $form_state->get('reservation_step');

    if ($currentStep < count($this->steps)) {
      $form_state->setRebuild();
      $form_state->set('reservation_step', ++$currentStep);
      
    }
    else {
      drupal_set_message('La réservation a bien été enregistrée');
      $form_state->setRedirect('view.my_reservations.page_1');
    }
  }

}

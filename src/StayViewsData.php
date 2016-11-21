<?php

namespace Drupal\reservations;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Stay entities.
 */
class StayViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['stay']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Stay'),
      'help' => $this->t('The Stay ID.'),
    );

    return $data;
  }

}

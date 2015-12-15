<?php

/**
 * @file
 * Contains \Drupal\reservations\SeasonListBuilder.
 */

namespace Drupal\reservations;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Config\Entity\ConfigEntityListBuilder;

/**
 * Provides a list controller for reservation entity.
 *
 * @ingroup reservations
 */
class SeasonListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   *
   * Building the header and content lines for the contact list.
   *
   * Calling the parent::buildHeader() adds a column for the possible actions
   * and inserts the 'edit' and 'delete' links as defined for the entity type.
   */
  public function buildHeader() {
    $header['year'] = $this->t('Season');
    $header['start_date'] = $this->t('The begining of the season');
    $header['end'] = $this->t('The end of the season');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['year'] = $entity->id();
    $row['start_date'] = $entity->start_date;
    $row['end_date'] = $entity->end_date;
    return $row + parent::buildRow($entity);
  }

}

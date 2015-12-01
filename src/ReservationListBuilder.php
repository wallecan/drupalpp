<?php

/**
 * @file
 * Contains \Drupal\reservations\ReservationListBuilder.
 */

namespace Drupal\reservations;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Url;

/**
 * Provides a list controller for reservation entity.
 *
 * @ingroup content_entity_example
 */
class ReservationListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   *
   * We override ::render() so that we can add our own content above the table.
   * parent::render() is where EntityListBuilder creates the table using our
   * buildHeader() and buildRow() implementations.
   */
  public function render() {
    $build['description'] = array(
      '#markup' => $this->t('Content Entity Example implements a Reservation model. These reservations are not fieldable entities. You can manage the fields on the <a href="@adminlink">Reservation admin page</a>.', array(
        '@adminlink' => \Drupal::urlGenerator()->generateFromRoute('reservations.content'),
      )),
    );
    $build['table'] = parent::render();
    return $build;
  }

  /**
   * {@inheritdoc}
   *
   * Building the header and content lines for the contact list.
   *
   * Calling the parent::buildHeader() adds a column for the possible actions
   * and inserts the 'edit' and 'delete' links as defined for the entity type.
   */
  public function buildHeader() {
    $header['rid'] = $this->t('ReservationID');
    $header['first_name'] = $this->t('First Name');

    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\content_entity_example\Entity\Contact */
    $row['rid'] = $entity->id();
    $row['first_name'] = $entity->first_name->value;
    return $row + parent::buildRow($entity);
  }

}

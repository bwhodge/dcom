<?php

namespace Drupal\commerce_order\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'commerce_order_item_table' formatter.
 *
 * @FieldFormatter(
 *   id = "commerce_order_item_table",
 *   label = @Translation("Order item table"),
 *   field_types = {
 *     "entity_reference",
 *   },
 * )
 */
class OrderItemTable extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    /** @var \Drupal\commerce_order\Entity\OrderInterface $order */
    $order = $items->getEntity();
    $elements = [];
    $order_item_ids = array_column($order->get('order_items')->getValue(), 'target_id');
    $elements[0] = [
      '#type' => 'view',
      // @todo Allow the view to be configurable.
      '#name' => 'commerce_order_item_table',
      '#arguments' => $order_item_ids ? [implode('+', $order_item_ids)] : NULL,
      '#embed' => TRUE,
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    $entity_type = $field_definition->getTargetEntityTypeId();
    $field_name = $field_definition->getName();
    return $entity_type == 'commerce_order' && $field_name == 'order_items';
  }

}

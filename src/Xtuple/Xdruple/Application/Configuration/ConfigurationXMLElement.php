<?php declare(strict_types=1);

namespace Xtuple\Xdruple\Application\Configuration;

use Xtuple\Util\XML\Element\Type\Dictionary\ArrayXMLElement;
use Xtuple\Util\XML\Element\XMLElement;
use Xtuple\Xdruple\Application\Service\Configuration\Value\XML\OptionalXMLValueXMLElement;

final class ConfigurationXMLElement
  extends AbstractConfiguration {
  public function __construct(XMLElement $element) {
    $configuration = [];
    /** @var XMLElement $variable */
    foreach ($element->children("/{$element->name()}/variable") as $variable) {
      if ($attribute = $variable->attributes()->get('name')) {
        $name = $attribute->value();
        if (($type = $variable->attributes()->get('type'))
          && $type->value() === 'xml') {
          $value = new OptionalXMLValueXMLElement($variable);
          if ($value->isPresent()) {
            $configuration[$name] = $value->value();
          }
        }
        else {
          $value = (new ArrayXMLElement($variable))->value();
          if (is_string($value) && defined($value)) {
            $value = constant($value);
          }
          $configuration[$name] = $value;
        }
      }
    }
    parent::__construct(new ConfigurationStruct($configuration));
  }
}

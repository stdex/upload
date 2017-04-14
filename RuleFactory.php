<?php
/**
 * slince upload handler library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Upload;

use Slince\Upload\Exception\UploadException;
use Slince\Upload\Rule\RuleInterface;

/**
 * @deprecated
 */
class RuleFactory
{
    /**
     * System validation rules
     * @var string
     */
    const RULE_SYSTEM = 'system';

    /**
     * File size limit validation
     * @var string
     */
    const RULE_SIZE = 'size';

    /**
     * File type validation
     * @var string
     */
    const RULE_MIME_TYPE = 'mime_type';

    /**
     * Extension validation
     * @var string
     */
    const RULE_EXTENSION = 'extension';

    /**
     * Instantiate validation rule
     * @param string $type
     * @param array $arguments
     * @throws UploadException
     * @return RuleInterface
     */
    public static function create($type, $arguments = null)
    {
        $ruleClass = '';
        switch ($type) {
            case static::RULE_SIZE:
                $ruleClass = 'SizeRule';
                break;
            case static::RULE_MIME_TYPE:
                $ruleClass = 'MimeTypeRule';
                break;
            case static::RULE_EXTENSION:
                $ruleClass = 'ExtensionRule';
                break;
            case static::RULE_SYSTEM:
                $ruleClass = 'SystemRule';
                break;
        }
        $ruleClass = "Slince\\Upload\\Rule\\{$ruleClass}";
        try {
            $ruleReflection = new \ReflectionClass($ruleClass);
            if ($ruleReflection->getConstructor() != null) {
                $instance = $ruleReflection->newInstanceArgs($arguments);
            } else {
                $instance = $ruleReflection->newInstanceWithoutConstructor();
            }
            return $instance;
        } catch (\ReflectionException $e) {
            throw new UploadException(sprintf('Rule "%s" does not support', $type));
        }
    }
}

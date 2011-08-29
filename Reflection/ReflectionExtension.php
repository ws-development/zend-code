<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Reflection
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

/**
 * @namespace
 */
namespace Zend\Code\Reflection;

use ReflectionExtension as PhpReflectionExtension,
    Zend\Code\Reflection;

/**
 * @uses       ReflectionExtension
 * @uses       \Zend\Code\Reflection\ReflectionClass
 * @uses       \Zend\Code\Reflection\Exception
 * @uses       \Zend\Code\Reflection\ReflectionFunction
 * @category   Zend
 * @package    Zend_Reflection
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class ReflectionExtension extends PhpReflectionExtension implements Reflection
{
    /**
     * Get extension function reflection objects
     *
     * @param  string $reflectionClass Name of reflection class to use
     * @return array Array of \Zend\Code\Reflection\ReflectionFunction objects
     */
    public function getFunctions($reflectionClass = 'Zend\Code\Reflection\ReflectionFunction')
    {
        $phpReflections  = parent::getFunctions();
        $zendReflections = array();
        while ($phpReflections && ($phpReflection = array_shift($phpReflections))) {
            $instance = new $reflectionClass($phpReflection->getName());
            if (!$instance instanceof ReflectionFunction) {
                throw new Exception\InvalidArgumentException('Invalid reflection class provided; must extend Zend_Reflection_Function');
            }
            $zendReflections[] = $instance;
            unset($phpReflection);
        }
        unset($phpReflections);
        return $zendReflections;
    }

    /**
     * Get extension class reflection objects
     *
     * @param  string $reflectionClass Name of reflection class to use
     * @return array Array of \Zend\Code\Reflection\ReflectionClass objects
     */
    public function getClasses($reflectionClass = 'Zend\Code\Reflection\ReflectionClass')
    {
        $phpReflections  = parent::getClasses();
        $zendReflections = array();
        while ($phpReflections && ($phpReflection = array_shift($phpReflections))) {
            $instance = new $reflectionClass($phpReflection->getName());
            if (!$instance instanceof ReflectionClass) {
                throw new Exception\InvalidArgumentException('Invalid reflection class provided; must extend Zend_Reflection_Class');
            }
            $zendReflections[] = $instance;
            unset($phpReflection);
        }
        unset($phpReflections);
        return $zendReflections;
    }
}

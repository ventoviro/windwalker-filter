<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\Filter\Cleaner;

/**
 * Interface FilterRuleInterface
 *
 * @since  {DEPLOY_VERSION}
 */
interface CleanerInterface
{
	/**
	 * Method to clean text by rule.
	 *
	 * @param   string  $source  The source to be clean.
	 *
	 * @return  mixed  The cleaned value.
	 */
	public function clean($source);
}

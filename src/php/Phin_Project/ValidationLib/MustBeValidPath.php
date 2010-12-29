<?php

/**
 * Copyright (c) 2010 Gradwell dot com Ltd.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Gradwell dot com Ltd nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package     Phin_Project
 * @subpackage  ValidationLib
 * @author      Stuart Herbert <stuart.herbert@gradwell.com>
 * @copyright   2010 Gradwell dot com Ltd. www.gradwell.com
 * @license     http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link        http://www.phin-tool.org
 * @version     @@PACKAGE_VERSION@@
 */

namespace Phin_Project\ValidationLib;

class MustBeValidPath extends ValidatorAbstract
{
        const MSG_PATHNOTFOUND  = 'msgPathNotFound';
        const MSG_PATHISAFILE   = 'msgPathIsAFile';
        const MSG_PATHISNOTADIR = 'msgPathIsNotADir';

        protected $_messageTemplates = array
        (
                self::MSG_PATHNOTFOUND => "'%value%' does not exist on disk at all",
                self::MSG_PATHISAFILE   => "'%value%' is a file; expected a directory",
                self::MSG_PATHISNOTADIR => "'%value%' exists, but is not a directory",
        );

        public function isValid($value)
        {
                $this->_setValue($value);

                $isValid = false;

                if (!\file_exists($value))
                {
                        $this->_error(self::MSG_PATHNOTFOUND);
                        $isValid = false;
                }

                if (!\is_dir($value))
                {
                        // it exists, but what is it?

                        if (is_file($value))
                        {
                                $this->_error(self::MSG_PATHISAFILE);
                        }
                        else
                        {
                                // we do not know what it is
                                $this->_error(self::MSG_PATHISNOTADIR);
                        }
                        $isValid = false;
                }

                return $isValid;
        }
}
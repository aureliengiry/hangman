<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Mailer;

use Symfony\Component\Translation\TranslatorInterface;

class AbstractMailer
{
    protected $mailer;
    protected $translator;
    protected $recipient;

    public function __construct(\Swift_Mailer $mailer, TranslatorInterface $translator, $recipient)
    {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->recipient = $recipient;
    }
}

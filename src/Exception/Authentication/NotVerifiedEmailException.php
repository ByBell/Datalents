<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Exception\Authentication;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * phpNotVerifiedEmailException is thrown when the user credentials are invalid.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Alexander <iam.asm89@gmail.com>
 */
class NotVerifiedEmailException extends AuthenticationException
{
    /**
     * {@inheritdoc}
     */
    public function getMessageKey()
    {
        return 'Votre compte n\'a pas été validé. Veuillez vérifier votre boite mail et cliquer sur le lien de validation du compte.';
    }
}

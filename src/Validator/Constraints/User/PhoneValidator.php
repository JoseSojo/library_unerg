<?php

namespace App\Validator\Constraints\User;

use Symfony\Component\Validator\Constraint;
use App\Validator\Constraints\ConstraintValidator;
use App\Entity\M\User;
use Maxtoan\Common\Util\StringUtil;
use Maxtoan\Common\Util\UserUtil;
use App\Repository\M\User\UserRepository;

/**
 * Validador de teléfono
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class PhoneValidator extends ConstraintValidator
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Validador
     *  
     * @author Máximo Sojo <maxsojo13@gmail.com>
     * @param  [type]     $object
     * @param  Constraint $constraint
     * @return [type]
     */
    public function validate($object, Constraint $constraint)
    {
        if($this->hasErrors()){
            return;
        }
        
        // Valida tipo teléfono número
        $phoneNro = $object->getPhone();
        if (!StringUtil::isOnlyNumber($phoneNro)) {
            $this->addError("validators.phone.invalid");
        }

        if (($country = $object->getCountry()) != null) {
            $country = $country->getId();
            // Valida formato de teléfono V1
            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
            $nroPhone = UserUtil::formatPhoneNumber($phoneNro,$country);
            $phoneExample = $phoneUtil->getExampleNumber($country);
            if ($nroPhone === null) {
                $exampleNro = "4241234565";
                if($phoneExample) {
                    $exampleNro = $phoneExample->getNationalNumber();
                }

                $this->addError("validators.phone.invalid.nro", ["%phoneNro%" => $phoneNro,"%phoneExample%" => $exampleNro]);
            } else {
                // Valida el telefono
                $swissNumberProto = $phoneUtil->parse($nroPhone,$country);
                $nationalNumber = $swissNumberProto->getNationalNumber();
                $object->setPhone($nationalNumber);

                $user = $this->userRepository->findOneByPhone($nationalNumber);
                if ($user instanceof User && $user != $object) {
                    $this->addError("validators.phone.invalid.nro.unique", ["%phoneNro%" => $phoneNro]);
                }
            }
        } else {
            $this->addError("validators.country.not_blank", []);
        }
    }
}

<?php

namespace Filmoteca\StaticPages\Validators;

interface ValidatorInterface
{
    /**
     * @param array $rawData
     * @return \Illuminate\Validation\Validator
     */
    public function validate($rawData);
}

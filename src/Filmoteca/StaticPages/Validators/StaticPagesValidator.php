<?php

namespace Filmoteca\StaticPages\Validators;

use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Translation\Translator;

/**
 * Class StaticPagesValidator
 * @package Filmoteca\StaticPages\Validators
 */
class StaticPagesValidator implements ValidatorInterface
{
    const PACKAGE_NAME = 'filmoteca/static-pages';

    /**
     * @var array
     */
    protected $rules = [
        'title'     => 'required|max:255',
        'slug'      => 'required',
        'status'    => 'required|max:20'
    ];

    protected $messages = [
        'title' => [
            'required' => 'static-pages.validation.title.required'
        ],
        'slug' => [
            'required' => 'static-pages.validation.slug.required'
        ]
    ];

    protected $compactedMessages = null;

    /**
     * @param ValidatorFactory $validatorFactory
     * @param Translator $trans
     */
    public function __construct(ValidatorFactory $validatorFactory, Translator $trans)
    {
        $this->validatorFactory = $validatorFactory;
        $this->trans            = $trans;
    }

    /**
     * @param array $rawData
     * @return \Illuminate\Validation\Validator
     */
    public function validate($rawData)
    {
        if ($this->compactedMessages === null) {
            $this->compactedMessages = $this->compactMessage();
        }

        $validator = $this->validatorFactory->make($rawData, $this->rules, $this->compactedMessages);

        return $validator;
    }

    /**
     * @return array
     */
    protected function compactMessage()
    {
        $compactedMessages = array_dot($this->messages);

        foreach ($compactedMessages as $key => $message) {
            $compactedMessages[$key] = $this->trans->get(self::PACKAGE_NAME . '::' . $message);
        }

        return $compactedMessages;
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param array $rules
     */
    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    /**
     * @param array $messages
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }


    /**
     * @return null
     */
    public function getCompactedMessages()
    {
        return $this->compactedMessages;
    }

    /**
     * @param null $compactedMessages
     */
    public function setCompactedMessages($compactedMessages)
    {
        $this->compactedMessages = $compactedMessages;
    }
}

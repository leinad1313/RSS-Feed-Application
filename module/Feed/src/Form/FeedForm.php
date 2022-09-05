<?php

declare(strict_types=1);

namespace Feed\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\Filter;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Validator;

class FeedForm extends Form implements InputFilterProviderInterface
{
    public function __construct($name = 'feedForm', array $options = [])
    {
        parent::__construct($name, $options);
    }

    // Create form with specific inputs
    public function init()
    {
        $this->setAttribute('method', 'POST');

        // Feed URL input
        $this->add([
            'type' => Element\Text::class,
            'name' => 'feedUrl',
            'options' => [
                // Name of form input to be displayed
                'label' => 'Feed URL'
            ],
            'attributes' => [
                // Make it required
                'required'    => true,
                'pattern'     => '[Hh][Tt][Tt][Pp][Ss]?:\/\/(?:(?:[a-zA-Z\u00a1-\uffff0-9]+-?)*[a-zA-Z\u00a1-\uffff0-9]+)(?:\.(?:[a-zA-Z\u00a1-\uffff0-9]+-?)*[a-zA-Z\u00a1-\uffff0-9]+)*(?:\.(?:[a-zA-Z\u00a1-\uffff]{2,}))(?::\d{2,5})?(?:\/[^\s]*)?', // Only allow URL
                'data-toggle' => 'tooltip',
                'class'       => 'form-control',
                'title'       => 'https://website.domain/feed',
                'placeholder' => 'Enter Your URL'
            ]
        ]);

        // Cross-site-request forgery (csrf) field
        $this->add([
            'type'    => Element\Csrf::class,
            'name'    => 'csrf',
            'options' => [
                'csrf_options' => [
                    'timeout' => 600 // 5 minutes
                ]
            ]
        ]);

        // Submit button
        $this->add([
            'type'       => Element\Submit::class,
            'name'       => 'loadFeed',
            'attributes' => [
                'value' => 'Load Feed',
                'class' => 'btn btn-primary'
            ]
        ]);
    }

    // Set validation rules
    public function getInputFilterSpecification()
    {
        return [
            [
                'name'       => 'feedUrl',
                'required'   => true,
                'filters'    => [
                    // Filter for security
                    ['name' => Filter\StripTags::class],
                    ['name' => Filter\StringTrim::class],
                    ['name' => Filter\HtmlEntities::class]
                ],
                'validators' => [
                    ['name' => Validator\NotEmpty::class],
                ]
            ], [
                'name'       => 'csrf',
                'required'   => true,
                'filters'    => [],
                'validators' => [
                    ['name' => Validator\Csrf::class]
                ]
            ]
        ];
    }
}
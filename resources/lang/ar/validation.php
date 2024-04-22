<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'accepted_if' => 'The :Attribute field must be accepted when :other is :value.',
    'alpha_spaces' => 'The :Attribute may only contain alphanumeric characters.',
    'ascii' => 'The :Attribute field must only contain single-byte alphanumeric characters and symbols.',
    'can' => 'The :Attribute field contains an unauthorized value.',
    'current_password' => 'The password is incorrect.',
    'date_equals' => 'The :Attribute field must be a date equal to :date.',
'decimal' => 'The :Attribute field must have :decimal decimal places.',
    'declined' => 'The :Attribute field must be declined.',
    'declined_if' => 'The :Attribute field must be declined when :other is :value.',
   'doesnt_end_with' => 'The :Attribute field must not end with one of the following: :values.',
    'doesnt_start_with' => 'The :Attribute field must not start with one of the following: :values.',
    'ends_with' => 'The :Attribute field must end with one of the following: :values.',
    'enum' => 'The selected :Attribute is invalid.',
    'gt' => [
        'array' => 'The :Attribute field must have more than :value items.',
        'file' => 'The :Attribute field must be greater than :value kilobytes.',
        'numeric' => 'The :Attribute field must be greater than :value.',
        'string' => 'The :Attribute field must be greater than :value characters.',
    ],
    'gte' => [
        'array' => 'The :Attribute field must have :value items or more.',
        'file' => 'The :Attribute field must be greater than or equal to :value kilobytes.',
        'numeric' => 'The :Attribute field must be greater than or equal to :value.',
        'string' => 'The :Attribute field must be greater than or equal to :value characters.',
    ],
    'lowercase' => 'The :Attribute field must be lowercase.',
    'lt' => [
        'array' => 'The :Attribute field must have less than :value items.',
        'file' => 'The :Attribute field must be less than :value kilobytes.',
        'numeric' => 'The :Attribute field must be less than :value.',
        'string' => 'The :Attribute field must be less than :value characters.',
    ],
    'lte' => [
        'array' => 'The :Attribute field must not have more than :value items.',
        'file' => 'The :Attribute field must be less than or equal to :value kilobytes.',
        'numeric' => 'The :Attribute field must be less than or equal to :value.',
        'string' => 'The :Attribute field must be less than or equal to :value characters.',
    ],
    'mac_address' => 'The :Attribute field must be a valid MAC address.',
        'max_digits' => 'The :Attribute field must not have more than :max digits.',
    'min_digits' => 'The :Attribute field must have at least :min digits.',
    'missing' => 'The :Attribute field must be missing.',
    'missing_if' => 'The :Attribute field must be missing when :other is :value.',
    'missing_unless' => 'The :Attribute field must be missing unless :other is :value.',
    'missing_with' => 'The :Attribute field must be missing when :values is present.',
    'missing_with_all' => 'The :Attribute field must be missing when :values are present.',
    'multiple_of' => 'The :Attribute field must be a multiple of :value.',
    'not_regex' => 'The :Attribute field format is invalid.',
    'password' => [
            'letters' => 'The :Attribute field must contain at least one letter.',
            'mixed' => 'The :Attribute field must contain at least one uppercase and one lowercase letter.',
            'numbers' => 'The :Attribute field must contain at least one number.',
            'symbols' => 'The :Attribute field must contain at least one symbol.',
            'uncompromised' => 'The given :Attribute has appeared in a data leak. Please choose a different :Attribute.',
        ],
    'prohibited' => 'The :Attribute field is prohibited.',
    'prohibited_if' => 'The :Attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :Attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :Attribute field prohibits :other from being present.',
    'required_array_keys' => 'The :Attribute field must contain entries for: :values.',
    
        'accepted'             => 'يجب قبول الحقل :attribute',
        'active_url'           => 'الحقل :attribute لا يُمثّل رابطًا صحيحًا',
        'after'                => 'يجب على الحقل :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.',
        'after_or_equal'       => 'الحقل :attribute يجب أن يكون تاريخاً لاحقاً أو مطابقاً للتاريخ :date.',
        'alpha'                => 'يجب أن لا يحتوي الحقل :attribute سوى على حروف',
        'alpha_dash'           => 'يجب أن لا يحتوي الحقل :attribute على حروف، أرقام ومطّات.',
        'alpha_num'            => 'يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط',
        'array'                => 'يجب أن يكون الحقل :attribute ًمصفوفة',
        'before'               => 'يجب على الحقل :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
        'before_or_equal'      => 'الحقل :attribute يجب أن يكون تاريخا سابقا أو مطابقا للتاريخ :date',
        'between'              => [
            'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
            'file'    => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
            'string'  => 'يجب أن يكون عدد حروف النّص :attribute بين :min و :max',
            'array'   => 'يجب أن يحتوي :attribute على عدد من العناصر بين :min و :max',
        ],
        'boolean'              => 'يجب أن تكون قيمة الحقل :attribute إما true أو false ',
        'confirmed'            => 'حقل التأكيد غير مُطابق للحقل :attribute',
        'date'                 => 'الحقل :attribute ليس تاريخًا صحيحًا',
        'date_format'          => 'لا يتوافق الحقل :attribute مع الشكل :format.',
        'different'            => 'يجب أن يكون الحقلان :attribute و :other مُختلفان',
        'digits'               => 'يجب أن يحتوي الحقل :attribute على :digits رقمًا/أرقام',
        'digits_between'       => 'يجب أن يحتوي الحقل :attribute بين :min و :max رقمًا/أرقام ',
        'dimensions'           => 'الـ :attribute يحتوي على أبعاد صورة غير صالحة.',
        'distinct'             => 'للحقل :attribute قيمة مُكرّرة.',
        'email'                => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح البُنية',
        'exists'               => 'الحقل :attribute غير صحيح',
        'file'                 => 'الـ :attribute يجب أن يكون من ملفا.',
        'filled'               => 'الحقل :attribute إجباري',
        'image'                => 'يجب أن يكون الحقل :attribute صورةً',
        'in'                   => 'الحقل :attribute غير صحيح',
        'in_array'             => 'الحقل :attribute غير موجود في :other.',
        'integer'              => 'يجب أن يكون الحقل :attribute عددًا صحيحًا',
        'ip'                   => 'يجب أن يكون الحقل :attribute عنوان IP ذا بُنية صحيحة',
        'ipv4'                 => 'يجب أن يكون الحقل :attribute عنوان IPv4 ذا بنية صحيحة.',
        'ipv6'                 => 'يجب أن يكون الحقل :attribute عنوان IPv6 ذا بنية صحيحة.',
        'json'                 => 'يجب أن يكون الحقل :attribute نصا من نوع JSON.',
        'max'                  => [
            'numeric' => 'يجب أن تكون قيمة الحقل :attribute مساوية أو أصغر لـ :max.',
            'file'    => 'يجب أن لا يتجاوز حجم الملف :attribute :max كيلوبايت',
            'string'  => 'يجب أن لا يتجاوز طول نص :attribute :max حروفٍ/حرفًا',
            'array'   => 'يجب أن لا يحتوي الحقل :attribute على أكثر من :max عناصر/عنصر.',
        ],
        'mimes'                => 'يجب أن يكون الحقل ملفًا من نوع : :values.',
        'mimetypes'            => 'يجب أن يكون الحقل ملفًا من نوع : :values.',
        'min'                  => [
            'numeric' => 'يجب أن تكون قيمة الحقل :attribute مساوية أو أكبر لـ :min.',
            'file'    => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت',
            'string'  => 'يجب أن يكون طول نص :attribute على الأقل :min حروفٍ/حرفًا',
            'array'   => 'يجب أن يحتوي الحقل :attribute على الأقل على :min عُنصرًا/عناصر',
        ],
        'not_in'               => 'الحقل :attribute غير صحيح',
        'numeric'              => 'يجب على الحقل :attribute أن يكون رقمًا',
        'present'              => 'يجب تقديم الحقل :attribute',
        'regex'                => 'صيغة الحقل :attribute .غير صحيحة',
        'required'             => 'الحقل :attribute مطلوب.',
        'required_if'          => 'الحقل :attribute مطلوب في حال ما إذا كان :other يساوي :value.',
        'required_unless'      => 'الحقل :attribute مطلوب في حال ما لم يكن :other يساوي :values.',
        'required_with'        => 'الحقل :attribute إذا توفّر :values.',
        'required_with_all'    => 'الحقل :attribute إذا توفّر :values.',
        'required_without'     => 'الحقل :attribute إذا لم يتوفّر :values.',
        'required_without_all' => 'الحقل :attribute إذا لم يتوفّر :values.',
        'same'                 => 'يجب أن يتطابق الحقل :attribute مع :other',
        'size'                 => [
            'numeric' => 'يجب أن تكون قيمة الحقل :attribute مساوية لـ :size',
            'file'    => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت',
            'string'  => 'يجب أن يحتوي النص :attribute على :size حروفٍ/حرفًا بالظبط',
            'array'   => 'يجب أن يحتوي الحقل :attribute على :size عنصرٍ/عناصر بالظبط',
        ],
        'string'               => 'يجب أن يكون الحقل :attribute نصآ.',
        'timezone'             => 'يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا',
        'unique'               => 'قيمة الحقل :attribute مُستخدمة من قبل',
        'uploaded'             => 'فشل في تحميل الـ :attribute',
        'url'                  => 'صيغة الرابط :attribute غير صحيحة',
    
        /*
        |--------------------------------------------------------------------------
        | Custom Validation Language Lines
        |--------------------------------------------------------------------------
        |
        | Here you may specify custom validation messages for attributes using the
        | convention "attribute.rule" to name the lines. This makes it quick to
        | specify a specific custom language line for a given attribute rule.
        |
        */
    
        'custom' => [
            'attribute-name' => [
                'rule-name' => 'custom-message',
            ],
            'image_id' => [
                'required_without' => 'يتوجب عليك اختيار صورة الدورة في حال عدم رفع صورة',
            ],
        ],
    
        /*
        |--------------------------------------------------------------------------
        | Custom Validation Attributes
        |--------------------------------------------------------------------------
        |
        | The following language lines are used to swap attribute place-holders
        | with something more reader friendly such as E-Mail Address instead
        | of "email". This simply helps us make messages a little cleaner.
        |
        */
    
        'attributes' => [
            'name'                  => 'الاسم',
            'username'              => 'اسم المُستخدم',
            'email'                 => 'البريد الالكتروني',
            'first_name'            => 'الاسم',
            'last_name'             => 'اسم العائلة',
            'password'              => 'كلمة المرور',
            'password_confirmation' => 'تأكيد كلمة المرور',
            'city'                  => 'المدينة',
            'country'               => 'الدولة',
            'address'               => 'العنوان',
            'phone'                 => 'الهاتف',
            'mobile'                => 'الجوال',
            'age'                   => 'العمر',
            'sex'                   => 'الجنس',
            'gender'                => 'الجنس',
            'day'                   => 'اليوم',
            'month'                 => 'الشهر',
            'year'                  => 'السنة',
            'hour'                  => 'ساعة',
            'minute'                => 'دقيقة',
            'second'                => 'ثانية',
            'content'               => 'المُحتوى',
            'description'           => 'الوصف',
            'excerpt'               => 'المُلخص',
            'date'                  => 'التاريخ',
            'time'                  => 'الوقت',
            'available'             => 'مُتاح',
            'size'                  => 'الحجم',
            'price'                 => 'السعر',
            'desc'                  => 'نبذه',
            'title'                 => 'العنوان',
            'q'                     => 'البحث',
            'link'                  => ' ',
            'slug'                  => ' ',
            'details' => 'التفاصيل',
            'attendees_only_notes' => 'ملاحظات للمسجلين',
            'location' => 'الموقع',
            'start_at' => 'تاريخ البداية',
            'end_at' => 'تاريخ النهاية',
            'available_seats_number' => 'عدد المقاعد المتاحة',
            'via_url_only' => 'التسجيل عن طريق رابط',
            'is_online' => 'عن بعد (أونلاين)',
            'image_url' => 'صورة الدورة',
            'second_name' => 'الاسم الثاني',
            'third_name' => 'الاسم الثالث',
            'family_name' => 'اسم العائلة',
            'text' => 'نص السؤال',
            'type' => 'النوع',
            'all_choices' => 'الإجابات',
            'correct_choices' => 'الإجابات الصحيحة',
            'certificate_template_id' => 'قالب الشهادة',
            'learners_ids' => 'المتعلمون',
        ],
        
    // 'accepted' => 'The :Attribute field must be accepted.',
    // 'active_url' => 'The :Attribute field must be a valid URL.',
    // 'after' => 'The :Attribute field must be a date after :date.',
    // 'after_or_equal' => 'The :Attribute field must be a date after or equal to :date.',
    // 'alpha' => 'The :Attribute field must only contain letters.',
    // 'alpha_dash' => 'The :Attribute field must only contain letters, numbers, dashes, and underscores.',
    // 'alpha_num' => 'The :Attribute field must only contain letters and numbers.',
    // 'array' => 'The :Attribute field must be an array.',
    // 'before' => 'The :Attribute field must be a date before :date.',
    // 'before_or_equal' => 'The :Attribute field must be a date before or equal to :date.',
    // 'between' => [
    //     'array' => 'The :Attribute field must have between :min and :max items.',
    //     'file' => 'The :Attribute field must be between :min and :max kilobytes.',
    //     'numeric' => 'The :Attribute field must be between :min and :max.',
    //     'string' => 'The :Attribute field must be between :min and :max characters.',
    // ],
    // 'boolean' => 'The :Attribute field must be true or false.',
    // 'confirmed' => 'The :Attribute field confirmation does not match.',
    // 'date' => 'The :Attribute field must be a valid date.',
    // 'date_format' => 'The :Attribute field must match the format :format.',
    // 'different' => 'The :Attribute field and :other must be different.',
    // 'digits' => 'The :Attribute field must be :digits digits.',
    // 'digits_between' => 'The :Attribute field must be between :min and :max digits.',
    // 'dimensions' => 'The :Attribute field has invalid image dimensions.',
    // 'distinct' => 'The :Attribute field has a duplicate value.',
    // 'email' => 'The :Attribute field must be a valid email address.',
    // 'exists' => 'The selected :Attribute is invalid.',
    // 'file' => 'The :Attribute field must be a file.',
    // 'filled' => 'The :Attribute field must have a value.',
    // 'image' => 'The :Attribute field must be an image.',
    // 'in' => 'The selected :Attribute is invalid.',
    // 'in_array' => 'The :Attribute field must exist in :other.',
    // 'integer' => 'The :Attribute field must be an integer.',
    // 'ip' => 'The :Attribute field must be a valid IP address.',
    // 'ipv4' => 'The :Attribute field must be a valid IPv4 address.',
    // 'ipv6' => 'The :Attribute field must be a valid IPv6 address.',
    // 'json' => 'The :Attribute field must be a valid JSON string.',
    // 'max' => [
    //     'array' => 'The :Attribute field must not have more than :max items.',
    //     'file' => 'The :Attribute field must not be greater than :max kilobytes.',
    //     'numeric' => 'The :Attribute field must not be greater than :max.',
    //     'string' => 'The :Attribute field must not be greater than :max characters.',
    // ],
    // 'mimes' => 'The :Attribute field must be a file of type: :values.',
    // 'mimetypes' => 'The :Attribute field must be a file of type: :values.',
    // 'min' => [
    //     'array' => 'The :Attribute field must have at least :min items.',
    //     'file' => 'The :Attribute field must be at least :min kilobytes.',
    //     'numeric' => 'The :Attribute field must be at least :min.',
    //     'string' => 'The :Attribute field must be at least :min characters.',
    // ],
    // 'not_in' => 'The selected :Attribute is invalid.',
    // 'numeric' => 'The :Attribute field must be a number.',
    // 'present' => 'The :Attribute field must be present.',
    // 'regex' => 'The :Attribute field format is invalid.',
    // 'required' => 'The :Attribute field is required.',
    // 'required_if' => 'The :Attribute field is required when :other is :value.',
    // 'required_if_accepted' => 'The :Attribute field is required when :other is accepted.',
    // 'required_unless' => 'The :Attribute field is required unless :other is in :values.',
    // 'required_with' => 'The :Attribute field is required when :values is present.',
    // 'required_with_all' => 'The :Attribute field is required when :values are present.',
    // 'required_without' => 'The :Attribute field is required when :values is not present.',
    // 'required_without_all' => 'The :Attribute field is required when none of :values are present.',
    // 'same' => 'The :Attribute field must match :other.',
    // 'size' => [
    //     'array' => 'The :Attribute field must contain :size items.',
    //     'file' => 'The :Attribute field must be :size kilobytes.',
    //     'numeric' => 'The :Attribute field must be :size.',
    //     'string' => 'The :Attribute field must be :size characters.',
    // ],
    // 'starts_with' => 'The :Attribute field must start with one of the following: :values.',
    // 'string' => 'The :Attribute field must be a string.',
    // 'timezone' => 'The :Attribute field must be a valid timezone.',
    // 'unique' => 'The :Attribute has already been taken.',
    // 'uploaded' => 'The :Attribute failed to upload.',
    // 'uppercase' => 'The :Attribute field must be uppercase.',
    // 'url' => 'The :Attribute field must be a valid URL.',
    // 'ulid' => 'The :Attribute field must be a valid ULID.',
    // 'uuid' => 'The :Attribute field must be a valid UUID.',

    // 'custom' => [
    //     'path' => [
    //         'filemanager.drive_from_path' => 'Invalid value specified for: :Attribute',
    //     ],
    //     'filename' => [
    //         'filemanager' => [
    //             'filename_is_valid' => 'Invalid value specified for: :Attribute',
    //             'store_only_html_to_templates' => 'The file has an incorrect extension. Please check the file and upload again.',
    //             'do_not_store_exe_in_public' => 'The file has an incorrect extension. Please check the file and upload again.',
    //             'do_not_store_php_in_public' => 'The upload of php files was disabled.',
    //         ],
    //     ],
    //     'processFile' => [
    //         'filemanager' => [
    //             'file_is_not_used_at_email_events' => 'You can not delete the template :path because it has a relationship with Email Event',
    //             'file_is_not_used_as_routing_screen' => 'You can not delete the template :path because it is used as a routing screen.',
    //         ],
    //     ],
    //     'processCategory' => [
    //         'process_category_manager' => [
    //             'category_does_not_have_processes' => 'The category cannot be deleted while it is still assigned to processes.',
    //         ],
    //     ],
    // ],

    // 'attributes' => [
    //     'title' => 'name',
    //     'firstname' => 'First Name',
    //     'lastname' => 'Last Name',
    //     'config' => 'Config',
    // ],
];

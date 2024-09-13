<?php
return [
    'roles' => [
        'haist_admin' => 'Haist Admin',
        'admin' => 'Admin',
        'manager' => 'Manager',
        'nurse' => 'Nurse',
        'assistant_nurse' => 'Assistant Nurse',
        'worker' => 'Worker',
        'patient' => 'Patient',
        'doctor' => 'Doctor'
    ],
    'criteria' => [
        'heart_rate' => [
            'name' => 'Heart Rate',
            'key' => 'heart_rate'
        ],
        'temperature' => [
            'name' => 'Temperature',
            'key' => 'temperature'
        ],
        'o2_saturation' => [
            'name' => 'O2 Saturation',
            'key' => 'o2_saturation'
        ],
        'base_o2_saturation' => [
            'name' => 'Base O2 Saturation',
            'key' => 'base_o2_saturation'
        ],
        'respiratory_rate' => [
            'name' => 'Respiratory Rate',
            'key' => 'respiratory_rate'
        ],
        'blood_pressure' => [
            'name' => 'Blood Pressure',
            'key' => 'blood_pressure'
        ],
    ],
    'comparison_operators' => [
        'gt' => [
            'name' => 'Greater Than',
            'key' => 'gt'
        ],
        'lt' => [
            'name' => 'Less Than',
            'key' => 'lt'
        ],
        'eq' => [
            'name' => 'Equals to',
            'key' => 'eq'
        ],
        'gte' => [
            'name' => 'Greater Than Equal to',
            'key' => 'gte'
        ],
        'lte' => [
            'name' => 'Less Than Equal to',
            'key' => 'lte'
        ],
    ],
    'ranking_by' => [
        'symptoms' => 'Symptoms',
        'assessments' => 'Assessments',
        'diagnoses' => 'Diagnosis',
        'response_time' => 'Response Time'
    ],
    'date_range' => [
        'today' => 'Today',
        'yesterday' => 'Yesterday',
        'week' => '7 Days',
        'month' => 'Month'
    ]
];

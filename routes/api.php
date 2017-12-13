<?php

Route::apiResource('courses', 'CourseController');

Route::post('enquiries', 'EnquiryController@store');

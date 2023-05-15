<?php

defined('UNAUTHENTICATED') or define("UNAUTHENTICATED", 'You are unauthenticated user.');
defined('ACCOUNT_BLOCKED') or define("ACCOUNT_BLOCKED", 'Oooh! Your account is blocked. Due to suspicious.');
defined('ACCOUNT_BLOCKED_BY_ADMIN') or define("ACCOUNT_BLOCKED_BY_ADMIN", 'Oooh! Your account is blocked. Please contact your administrator.');
defined('ENTER_VALID_CREDENTIAL') or define("ENTER_VALID_CREDENTIAL", 'Please enter valid credentials.');
defined('EMAIL_ALREADY_EXIST') or define("EMAIL_ALREADY_EXIST", 'This email has already been taken.');
defined('ENTER_VALID_USERNAME') or define("ENTER_VALID_USERNAME", 'The username does not exists.');
defined('ENTER_VALID_EMAIL') or define("ENTER_VALID_EMAIL", 'The email does not exists.');
defined('ENTER_VALID_MOBILE') or define("ENTER_VALID_MOBILE", 'The mobile number does not exists.');
defined('EMAIL_MOBILE_REQUIRED') or define("EMAIL_MOBILE_REQUIRED", 'Email or mobile is required.');
defined('USERNAME_ALREADY_EXIST') or define("USERNAME_ALREADY_EXIST", 'Username already taken.');
defined('USER_PASSWORD') or define("USER_PASSWORD", 'Account has been created successfully.');
defined('INCORRECT_PASSWORD') or define("INCORRECT_PASSWORD", 'Incorrect password');
defined('LOGIN_SUCCESSFULLY') or define("LOGIN_SUCCESSFULLY", 'Login successfully');
defined('LOGOUT_SUCCESSFULLY') or define("LOGOUT_SUCCESSFULLY", 'User logout successfully');
defined('REGISTERED_SUCCESSFULLY') or define("REGISTERED_SUCCESSFULLY", 'Your account has been successfully created. Admin will review it soon.');
defined('RESET_PASSWORD_EMAIL') or define("RESET_PASSWORD_EMAIL", 'Please check your email to reset password');
defined('PASSWORD_CHANGED_SUCCESSFULLY') or define("PASSWORD_CHANGED_SUCCESSFULLY", 'You have change password successfully.');
defined('WRONG_PASSWORD') or define("WRONG_PASSWORD", 'Oops! you have entered wrong current password. Please try again.');
defined('PROFILE_UPDATED_SUCCESSFULLY') or define("PROFILE_UPDATED_SUCCESSFULLY", 'Profile updated successfully');
defined('ACCOUNT_DEACTIVATED_SUCCESSFULLY') or define("ACCOUNT_DEACTIVATED_SUCCESSFULLY", 'Account deactivated successfully');
defined('ACCOUNT_RESTORE_SUCCESSFULLY') or define("ACCOUNT_RESTORE_SUCCESSFULLY", 'Your Account restore successfully');
defined('ACCOUNT_DELETED_SUCCESSFULLY') or define("ACCOUNT_DELETED_SUCCESSFULLY", 'Your Account deleted successfully');

defined('PASSWORD_CHANGED') or define("PASSWORD_CHANGED", "You have change your account password successfully. You made a request to reset your password. Please discard if this wasn't you.");

defined('EMAIL_USERNAME_REQUIRED') or define("EMAIL_USERNAME_REQUIRED", 'Email or password is required.');
defined('EMAIL_PASSWORD_REQUIRED') or define("EMAIL_PASSWORD_REQUIRED", 'Username or password is required.');

defined('INCORRECT_MOBILE') or define("INCORRECT_MOBILE", 'Please enter valid mobile number.');


defined('LATITUDE_UPDATED_SUCCESSFULLY') or define("LATITUDE_UPDATED_SUCCESSFULLY", 'Latitude longitude updated successfully');
defined('DEVICE_TOKEN_UPDATED') or define("DEVICE_TOKEN_UPDATED", 'Device token updated successfully');

defined('NOTIFICATION_FETCHED') or define("NOTIFICATION_FETCHED", 'Notification fetched successfully');
defined('NOTIFICATION_READ') or define("NOTIFICATION_READ", 'Notification marked as read successfully');

defined('ACCEPTED_NOTIFICATION_MESSAGE') or define("ACCEPTED_NOTIFICATION_MESSAGE", "Your offer has been accepted");
defined('REJECTED_NOTIFICATION_MESSAGE') or define("REJECTED_NOTIFICATION_MESSAGE", "Your offer has been rejected");

defined('ON_THE_WAY_NOTIFICATION_MESSAGE') or define("ON_THE_WAY_NOTIFICATION_MESSAGE", "on the way to start ");
defined('WORKING_ON_NOTIFICATION_MESSAGE') or define("WORKING_ON_NOTIFICATION_MESSAGE", "started working on ");
defined('COMPLETED_NOTIFICATION_MESSAGE') or define("COMPLETED_NOTIFICATION_MESSAGE", "Your job has been completed");

defined('OTP_SENT') or define("OTP_SENT", 'OTP sent successfully on your mobile');
defined('OTP_VERIFIED') or define("OTP_VERIFIED", 'OTP verified successfully');

defined('INTEREST_FETCHED') or define("INTEREST_FETCHED", 'Interest fetched successfully');
defined('SLOT_FETCHED') or define("SLOT_FETCHED", 'Slots fetched successfully');
defined('SLOT_UNAVAILABLE') or define("SLOT_UNAVAILABLE", 'Slot not available.');

defined('SERVICE_CREATE_SUCCESSFULLY') or define("SERVICE_CREATE_SUCCESSFULLY", 'Service created successfully');
defined('SERVICE_UPDATE_SUCCESSFULLY') or define("SERVICE_UPDATE_SUCCESSFULLY", 'Service details updated successfully');
defined('SERVICE_FETCHED') or define("SERVICE_FETCHED", 'Service fetched successfully');

defined('BOOKING_CREATE_SUCCESSFULLY') or define("BOOKING_CREATE_SUCCESSFULLY", 'Booking created successfully');
defined('BOOKING_RESCHEDULE_SUCCESSFULLY') or define("BOOKING_RESCHEDULE_SUCCESSFULLY", 'Booking rescheduled successfully');
defined('BOOKING_FETCHED') or define("BOOKING_FETCHED", 'Booking fetched successfully');

defined('SLOT_CREATE_SUCCESSFULLY') or define("SLOT_CREATE_SUCCESSFULLY", 'Slot create successfully');
defined('SLOT_UPDATED_SUCCESSFULLY') or define("SLOT_UPDATED_SUCCESSFULLY", "Slot update successfully");
defined('SLOT_DELETED_SUCCESSFULLY') or define("SLOT_DELETED_SUCCESSFULLY", 'Slot remove successfully');

defined('RESCHEDULE_SLOT_CREATE_SUCCESSFULLY') or define("RESCHEDULE_SLOT_CREATE_SUCCESSFULLY", 'Reschedule slot add successfully');
defined('RESCHEDULE_SLOT_UPDATED_SUCCESSFULLY') or define("RESCHEDULE_SLOT_UPDATED_SUCCESSFULLY", 'Reschedule slot update successfully');
defined('RESCHEDULE_SLOT_DELETED_SUCCESSFULLY') or define("RESCHEDULE_SLOT_DELETED_SUCCESSFULLY", 'Reschedule slot remove successfully');

defined('OWN_POST_COMMENTED_ERROR') or define("OWN_POST_COMMENTED_ERROR", "You can't comment on your post");
defined('POST_LIKED_SUCCESSFULLY') or define("POST_LIKED_SUCCESSFULLY", 'Add comment successfully');
defined('OWN_POST_LIKED_ERROR') or define("OWN_POST_LIKED_ERROR", "You can't like/dislike your post");

defined('EVENT_ONGOING_SUCCESSFULLY') or define("EVENT_ONGOING_SUCCESSFULLY", 'Event ongoing status updated successfully');
defined('EVENT_ONGOING_ERROR') or define("EVENT_ONGOING_ERROR", "You can't update ongoing status on your event");
defined('EVENT_FETCHED') or define("EVENT_FETCHED", 'Event fetched successfully');
defined('ADDED_TO_FAVORITE') or define("ADDED_TO_FAVORITE", 'Category added to favorite successfully');

defined('LOGIN_AS_USER') or define("LOGIN_AS_USER", 'Please login as a user.');
defined('LOGIN_AS_TRAINER') or define("LOGIN_AS_TRAINER", 'Please login as a trainer.');

defined('LOGIN_AS_SERVICE_PROVIDER') or define("LOGIN_AS_SERVICE_PROVIDER", 'Please login as trainer or gym.');
defined('SERVICE_PROVIDER_AND_HAVE_SERVICE') or define("SERVICE_PROVIDER_AND_HAVE_SERVICE", 'Login as service provider and create a services first.');

defined('APP_BASIC_DETAILS') or define("APP_BASIC_DETAILS", 'Application basic details fetched successfully');
defined('DEFAULT_ERROR_MESSAGE') or define("DEFAULT_ERROR_MESSAGE", "Oops! some error occur, please try again");

// Status Error
defined('STATUS_OK') or define("STATUS_OK", 200);
defined('STATUS_CREATED') or define("STATUS_CREATED", 201);
defined('STATUS_BAD_REQUEST') or define("STATUS_BAD_REQUEST", 400);
defined('STATUS_UNAUTHORIZED') or define("STATUS_UNAUTHORIZED", 401);
defined('STATUS_FORBIDDEN') or define("STATUS_FORBIDDEN", 403);
defined('STATUS_NOT_FOUND') or define("STATUS_NOT_FOUND", 404);
defined('STATUS_METHOD_NOT_ALLOWED') or define("STATUS_METHOD_NOT_ALLOWED", 405);
defined('STATUS_ALREADY_EXIST') or define("STATUS_ALREADY_EXIST", 409);
defined('UNPROCESSABLE_ENTITY') or define("UNPROCESSABLE_ENTITY", 422);
defined('STATUS_GENERAL_ERROR') or define("STATUS_GENERAL_ERROR", 500);

// Stripe Message
define("STRIPE_PAYMENT_PENDING", 'Payment is pending');
define("STRIPE_PAYMENT_SUCCESS", 'Your payment has been successful!');
define("STRIPE_PAYMENT_FAILED", 'Your payment has failed!');

// Trainer Message
defined('TRAINER_INFO') or define("TRAINER_INFO", 'Please add profile information with business details.');
defined('TRAINER_FETCH') or define("TRAINER_FETCH", 'Details fetched successfully.');
defined('TRAINER_DETAILS') or define("TRAINER_DETAILS", 'Details updated successfully.');
defined('TRAINER_EDUCATIONS') or define("TRAINER_EDUCATIONS", 'Education added successfully.');
defined('TRAINER_EDUCATIONS_FETCH') or define("TRAINER_EDUCATIONS_FETCH", 'Education fetched successfully.');
defined('TRAINER_EDUCATIONS_DELETE') or define("TRAINER_EDUCATIONS_DELETE", 'Education delete successfully.');
defined('TRAINER_EDUCATIONS_UPDATE') or define("TRAINER_EDUCATIONS_UPDATE", 'Education update successfully.');

defined('TRAINER_CERTIFICATE') or define("TRAINER_CERTIFICATE", 'Certificate updated successfully.');
defined('TRAINER_CERTIFICATE_FETCH') or define("TRAINER_CERTIFICATE_FETCH", 'Certificate fetched successfully.');
defined('TRAINER_CERTIFICATE_DELETE') or define("TRAINER_CERTIFICATE_DELETE", 'Education delete successfully.');
defined('TRAINER_CERTIFICATE_UPDATE') or define("TRAINER_CERTIFICATE_UPDATE", 'update successfully.');

defined('TRAINER_STYLE') or define("TRAINER_STYLE", 'Style fetch successfully.');
defined('TRAINER_Add') or define("TRAINER_Add", 'Style added successfully.');
defined('TRAINER_UPDATE') or define("TRAINER_UPDATE", 'Style updated successfully.');

defined('TRAINER_INSURANCE_UPDATE') or define("TRAINER_INSURANCE_UPDATE", 'Insurance updated successfully.');
defined('TRAINER_INSURANCE') or define("TRAINER_INSURANCE", 'Insurance created successfully.');
defined('GET_TRAINER_INSURANCE') or define("GET_TRAINER_INSURANCE", 'Insurance fetched successfully.');

defined('GET_DAYS') or define("GET_DAYS", 'Days fetched successfully.');

defined('TRAINER_SERVICE_ADD') or define("TRAINER_SERVICE_ADD", 'Service create successfully');
defined('TRAINER_SERVICE_UPDATE') or define("TRAINER_SERVICE_UPDATE", 'Service update successfully');
defined('TRAINER_SERVICE_DUPLICATE') or define("TRAINER_SERVICE_DUPLICATE", 'Service duplicate successfully');
defined('TRAINER_SERVICE_DELETE') or define("TRAINER_SERVICE_DELETE", 'Service delete successfully');
defined('TRAINER_SERVICE_EDIT') or define("TRAINER_SERVICE_EDIT", 'Service edit successfully');
defined('TRAINER_SERVICE_GET') or define("TRAINER_SERVICE_GET", 'Service fetched successfully');
defined('TRAINER_TIME_SLOT') or define("TRAINER_TIME_SLOT", 'Time slot add successfully');
defined('TRAINER_TIME_SLOT_GET') or define("TRAINER_TIME_SLOT_GET", 'Time slot fetched successfully');
defined('TRAINER_TIME_SLOT_DELETE') or define("TRAINER_TIME_SLOT_DELETE", 'Time slot delete successfully');

defined('SERVICE_LOCATION_ADD') or define("SERVICE_LOCATION_ADD", 'Location create successfully');
defined('SERVICE_LOCATION_UPDATE') or define("SERVICE_LOCATION_UPDATE", 'Location update successfully');
defined('SERVICE_LOCATION_DELETE') or define("SERVICE_LOCATION_DELETE", 'Location delete successfully');
defined('SERVICE_LOCATION_EDIT') or define("SERVICE_LOCATION_EDIT", 'Location edit successfully');
defined('SERVICE_LOCATION_GET') or define("SERVICE_LOCATION_GET", 'Location fetched successfully');

defined('FACILITY_FETCH') or define("FACILITY_FETCH", 'Facilities details fetched successfully.');

defined('GET_WELLNESS_GOAL') or define("GET_WELLNESS_GOAL", 'Wellness goal fetched successfully.');
defined('GET_WELLNESS_GOAL_TIME') or define("GET_WELLNESS_GOAL_TIME", 'Wellness goal time fetched successfully.');
defined('GET_APPOINTMENT_USER') or define("GET_APPOINTMENT_USER", 'User appointment fetched successfully.');
defined('GET_APPOINTMENT_TRAINER') or define("GET_APPOINTMENT_TRAINER", 'Appointment fetched successfully.');
defined('GET_CLIENT') or define("GET_CLIENT", 'Appointment fetched successfully.');
defined('GET_PROVIEWS') or define("GET_PROVIEWS", 'Pro trainer view fetched successfully.');
defined('ADD_PROVIEWS') or define("ADD_PROVIEWS", 'Pro trainer view add successfully.');
defined('USER_FOLLOW') or define("USER_FOLLOW", 'You follow successfully.');
defined('USER_UNFOLLOW') or define("USER_UNFOLLOW", 'You unfollow successfully.');

defined('PAYMENT_REQUEST') or define("PAYMENT_REQUEST", "PAYMENT_REQUEST");
defined('PAYMENT_SUCCESS') or define("PAYMENT_SUCCESS", "PAYMENT_SUCCESS");
defined('PAYMENT_PENDING') or define("PAYMENT_PENDING", "PAYMENT_PENDING");
defined('PAYMENT_FAILED') or define("PAYMENT_FAILED", "PAYMENT_FAILED");
defined('PAYMENT_SEND_MSG') or define("PAYMENT_SEND_MSG", "payment sent by");
defined('ALREADY_CHECKIN') or define("ALREADY_CHECKIN", 'You have already checkin today, Please come back tommorow');
defined('ADD_CHECKIN') or define("ADD_CHECKIN", 'Added successfully');
defined('GET_CHECKIN') or define("GET_CHECKIN", 'Fatched successfully');
defined('GET_APPRAISAL') or define("GET_APPRAISAL", 'Fatched successfully');

defined('VEDIOCRITIQUE') or define("VEDIOCRITIQUE", 'Critiques fatched successfully');
defined('VEDIOCRITIQUE_ADD') or define("VEDIOCRITIQUE_ADD", 'Critiques added successfully');
defined('COMMENT') or define("COMMENT", 'Comment added successfully');

defined('RATING') or define("RATING", 'Rating added successfully');

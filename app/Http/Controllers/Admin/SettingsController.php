<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting; // Ensure you have a Settings model
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    // Retrieve Stripe settings
// Retrieve all settings related to Stripe
public function getStripeSettings()
{
    // Retrieve all settings related to Stripe
    $settings = Setting::where('type', 'stripe')->pluck('value', 'key')->toArray();

    // Retrieve the is_enabled value directly from the database
    $isEnabled = Setting::where('type', 'stripe')->value('is_enabled');

    // Add is_enabled to the settings array
    $settings['is_enabled'] = $isEnabled; // Directly use the boolean value

    // Ensure webhook_secret is set, default to null if it doesn't exist
    $settings['webhook_secret'] = $settings['webhook_secret'] ?? null; // Default to null if not found

    return response()->json($settings);
}


public function updateStripeSettings(Request $request)
{


    // Validate incoming request
    $validator = Validator::make($request->all(), [
       'api_key' => 'nullable|string',
        'api_secret' => 'nullable|string',
        'webhook_secret' => 'nullable|string',// Allow empty or specific values
        'is_enabled' => 'required|boolean', // Ensure it is a boolean
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Prepare settings to update
    $settingsToUpdate = [
       'api_key' => $request->api_key, // Convert empty strings to null
        'api_secret' => $request->api_secret, // Convert empty strings to null
        'webhook_secret' => $request->webhook_secret, // 
    ];

    // Update or create settings
    foreach ($settingsToUpdate as $key => $value) {
        Setting::updateOrCreate(
            ['type' => 'stripe', 'key' => $key], // Unique combination of type and key
            ['value' => $value] // Store the value directly
        );
    }

    // Update the is_enabled value directly in the settings table
    Setting::where('type', 'stripe')->update(['is_enabled' => $request->is_enabled]);

    return response()->json(['message' => 'Stripe settings updated successfully!'], 200);

    
}






    // Retrieve PayPal settings
public function getPayPalSettings()
{
    // Retrieve all settings related to PayPal
    $settings = Setting::where('type', 'paypal')->pluck('value', 'key')->toArray();

    // Retrieve the is_enabled value directly from the database
    $isEnabled = Setting::where('type', 'paypal')->value('is_enabled');

    // Add is_enabled to the settings array
    $settings['is_enabled'] = $isEnabled; // Directly use the boolean value

    return response()->json($settings);
}


    // Update PayPal settings
public function updatePayPalSettings(Request $request)
{
    // Validate incoming request
    $validator = Validator::make($request->all(), [
        'client_id' => 'nullable|string', // Allow empty string
        'client_secret' => 'nullable|string', // Allow empty string
        'mode' => 'nullable|in:sandbox,live', // Allow empty or specific values
        'is_enabled' => 'required|boolean', // Ensure it is a boolean
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Prepare settings to update
    $settingsToUpdate = [
        'client_id' => $request->client_id,
        'client_secret' => $request->client_secret,
        'mode' => $request->mode,
    ];

    // Update or create settings
    foreach ($settingsToUpdate as $key => $value) {
        Setting::updateOrCreate(
            ['type' => 'paypal', 'key' => $key], // Unique combination of type and key
            ['value' => $value] // Store the value directly
        );
    }

    // Update the is_enabled value directly in the settings table
    Setting::where('type', 'paypal')->update(['is_enabled' => $request->is_enabled]);

    return response()->json(['message' => 'PayPal settings updated successfully!'], 200);
}



    // Retrieve Pusher settings
    public function getPusherSettings()
    {
            // Retrieve all settings related to PayPal
    $settings = Setting::where('type', 'pusher')->pluck('value', 'key')->toArray();

    // Retrieve the is_enabled value directly from the database
    $isEnabled = Setting::where('type', 'pusher')->value('is_enabled');

    // Add is_enabled to the settings array
    $settings['is_enabled'] = $isEnabled; // Directly use the boolean value

    return response()->json($settings);
    }

    // Update Pusher settings
    public function updatePusherSettings(Request $request)
    {

         // Validate incoming request
    $validator = Validator::make($request->all(), [
        'broadcast_driver'=>'nullable|string',
       'app_id' => 'nullable|string',
        'app_key' => 'nullable|string',
        'app_secret' => 'nullable|string',
        'app_cluster' => 'nullable|string',
        'is_enabled' => 'required|boolean', // Ensure it is a boolean
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Prepare settings to update
    $settingsToUpdate = [
        'broadcast_driver'=> $request->broadcast_driver,
       'app_id' =>  $request->app_id,
        'app_key' =>  $request->app_key,
        'app_secret' =>  $request->app_secret,
        'app_cluster' =>  $request->app_cluster,
     
    ];

    // Update or create settings
    foreach ($settingsToUpdate as $key => $value) {
        Setting::updateOrCreate(
            ['type' => 'pusher', 'key' => $key], // Unique combination of type and key
            ['value' => $value] // Store the value directly
        );
    }

    // Update the is_enabled value directly in the settings table
    Setting::where('type', 'pusher')->update(['is_enabled' => $request->is_enabled]);

    return response()->json(['message' => 'Pusher settings updated successfully!'], 200);

        
    }

    // Retrieve Mailchimp settings
    public function getMailchimpSettings()
    {
           // Retrieve all settings related to PayPal
    $settings = Setting::where('type', 'mailchimp')->pluck('value', 'key')->toArray();

    // Retrieve the is_enabled value directly from the database
    $isEnabled = Setting::where('type', 'mailchimp')->value('is_enabled');

    // Add is_enabled to the settings array
    $settings['is_enabled'] = $isEnabled; // Directly use the boolean value

    return response()->json($settings);
    }

    // Update Mailchimp settings
    public function updateMailchimpSettings(Request $request)
    {

        // Validate incoming request
    $validator = Validator::make($request->all(), [
          'api_key' => 'nullable|string',
          'list_id' => 'nullable|string',
        'is_enabled' => 'required|boolean', // Ensure it is a boolean
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Prepare settings to update
    $settingsToUpdate = [
        'api_key' => $request->api_key,
        'list_id' => $request->list_id,
    ];

    // Update or create settings
    foreach ($settingsToUpdate as $key => $value) {
        Setting::updateOrCreate(
            ['type' => 'mailchimp', 'key' => $key], // Unique combination of type and key
            ['value' => $value] // Store the value directly
        );
    }

    // Update the is_enabled value directly in the settings table
    Setting::where('type', 'mailchimp')->update(['is_enabled' => $request->is_enabled]);

    return response()->json(['message' => 'Mailchimp settings updated successfully!'], 200);
      
    }

    public function getContactInfoSettings()
{
    // Retrieve all settings related to Contact Information
    $settings = Setting::where('type', 'contact_info')->pluck('value', 'key')->toArray();

    // Retrieve the is_enabled value for Contact Info directly from the database
    $isEnabled = Setting::where('type', 'contact_info')->value('is_enabled');

    // Add is_enabled to the settings array
    $settings['is_enabled'] = $isEnabled;

    return response()->json($settings);
}

public function updateContactInfoSettings(Request $request)
{
    // Validate the incoming request
    $validator = Validator::make($request->all(), [
        'phone' => 'nullable|string', // Allow empty or string values
        'email' => 'nullable|email', // Validate email format
        'address' => 'nullable|string', // Allow empty or string values
        'is_enabled' => 'required|boolean', // Boolean for enabling/disabling the contact info
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Prepare the settings to be updated
    $settingsToUpdate = [
        'phone' => $request->phone,
        'email' => $request->email,
        'address' => $request->address,
    ];

    // Update or create contact info settings
    foreach ($settingsToUpdate as $key => $value) {
        Setting::updateOrCreate(
            ['type' => 'contact_info', 'key' => $key], // Unique combination of type and key
            ['value' => $value] // Store the value directly
        );
    }

    // Update the is_enabled value directly in the settings table
    Setting::where('type', 'contact_info')->update(['is_enabled' => $request->is_enabled]);

    return response()->json(['message' => 'Contact Information settings updated successfully!'], 200);
}

public function getSocialMediaSettings()
{
    // Retrieve all settings related to Social Media, including TikTok
    $settings = Setting::where('type', 'social_media')->pluck('value', 'key')->toArray();

    // Retrieve the is_enabled value for Social Media directly from the database
    $isEnabled = Setting::where('type', 'social_media')->value('is_enabled');

    // Add is_enabled to the settings array
    $settings['is_enabled'] = $isEnabled;

    return response()->json($settings);
}

public function updateSocialMediaSettings(Request $request)
{
    // Validate the incoming request, including TikTok
    $validator = Validator::make($request->all(), [
        'facebook' => 'nullable|url', // Validate URL format for social media links
        'twitter' => 'nullable|url', 
        'instagram' => 'nullable|url', 
        'tiktok' => 'nullable|url', // Add validation for TikTok URL
        'is_enabled' => 'required|boolean', // Boolean for enabling/disabling social media links
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Prepare the settings to update
    $settingsToUpdate = [
        'facebook' => $request->facebook,
        'twitter' => $request->twitter,
        'instagram' => $request->instagram,
        'tiktok' => $request->tiktok, // Add TikTok to the update
    ];

    // Update or create social media settings
    foreach ($settingsToUpdate as $key => $value) {
        Setting::updateOrCreate(
            ['type' => 'social_media', 'key' => $key], // Unique combination of type and key
            ['value' => $value] // Store the value directly
        );
    }

    // Update the is_enabled value directly in the settings table
    Setting::where('type', 'social_media')->update(['is_enabled' => $request->is_enabled]);

    return response()->json(['message' => 'Social Media settings updated successfully!'], 200);
}
// Retrieve General settings
public function getGeneralSettings()
{
    // Retrieve all settings related to General
    $settings = Setting::where('type', 'general')->pluck('value', 'key')->toArray();

    // Retrieve the is_enabled value directly from the database
    $isEnabled = Setting::where('type', 'general')->value('is_enabled');

    // Add is_enabled to the settings array
    $settings['is_enabled'] = $isEnabled; // Directly use the boolean value

    // Retrieve the maintenance_mode value directly from the database
    $maintenanceMode = Setting::where('type', 'general')->where('key', 'maintenance_mode')->value('value');

    // Add maintenance_mode to the settings array, default to false if not set
    $settings['maintenance_mode'] = $maintenanceMode === null ? false : (bool)$maintenanceMode;

    return response()->json($settings);
}

// Update General settings
public function updateGeneralSettings(Request $request)
{
    // Validate incoming request
    $validator = Validator::make($request->all(), [
        'brand_name' => 'nullable|string', // Allow empty string
        'description' => 'nullable|string', // Allow empty string
        'maintenance_mode' => 'required|boolean', // Boolean for maintenance mode
        'is_enabled' => 'required|boolean', // Ensure it is a boolean
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Prepare settings to update
    $settingsToUpdate = [
        'brand_name' => $request->brand_name,
        'description' => $request->description,
        'maintenance_mode' => $request->maintenance_mode, // Include maintenance_mode in the update
    ];

    // Update or create settings for brand_name and description
    foreach ($settingsToUpdate as $key => $value) {
        Setting::updateOrCreate(
            ['type' => 'general', 'key' => $key], // Unique combination of type and key
            ['value' => $value] // Store the value directly
        );
    }

    // Update the is_enabled value directly in the settings table
    Setting::updateOrCreate(
        ['type' => 'general', 'key' => 'is_enabled'], // Unique combination of type and key
        ['value' => $request->is_enabled] // Store the value directly
    );

    return response()->json(['message' => 'General settings updated successfully!'], 200);
}



}

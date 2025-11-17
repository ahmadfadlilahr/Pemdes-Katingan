<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Contact;
use App\Models\VisionMission;
use App\Models\WelcomeMessage;
use Illuminate\Http\JsonResponse;

class InfoController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/contact",
     *      operationId="getContactInfo",
     *      tags={"Contact"},
     *      summary="Get contact information",
     *      description="Returns contact information including address, phone, email, and social media",
     *      @OA\Response(response=200, description="Successful operation")
     * )
     */
    public function contact(): JsonResponse
    {
        $contact = Contact::first();

        if (!$contact) {
            return $this->error('Contact information not found', 404);
        }

        $data = [
            'address' => $contact->address,
            'phone' => $contact->phone,
            'email' => $contact->email,
            'whatsapp' => $contact->whatsapp,
            'office_hours' => $contact->office_hours,
            'social_media' => [
                'facebook' => $contact->facebook,
                'instagram' => $contact->instagram,
                'twitter' => $contact->twitter,
                'youtube' => $contact->youtube,
            ],
            'map' => [
                'embed_url' => $contact->map_embed,
                'latitude' => $contact->latitude,
                'longitude' => $contact->longitude,
            ],
        ];

        return $this->success($data, 'Contact information retrieved successfully');
    }

    /**
     * @OA\Get(
     *      path="/api/v1/vision-mission",
     *      operationId="getVisionMission",
     *      tags={"Vision & Mission"},
     *      summary="Get vision and mission",
     *      description="Returns organization's vision and mission statement",
     *      @OA\Response(response=200, description="Successful operation")
     * )
     */
    public function visionMission(): JsonResponse
    {
        $vm = VisionMission::first();

        if (!$vm) {
            return $this->error('Vision & Mission not found', 404);
        }

        $data = [
            'vision' => $vm->vision,
            'mission' => $vm->mission,
            'updated_at' => $vm->updated_at->toIso8601String(),
        ];

        return $this->success($data, 'Vision & Mission retrieved successfully');
    }

    /**
     * @OA\Get(
     *      path="/api/v1/welcome-message",
     *      operationId="getWelcomeMessage",
     *      tags={"Vision & Mission"},
     *      summary="Get welcome message",
     *      description="Returns active welcome message from head of office",
     *      @OA\Response(response=200, description="Successful operation")
     * )
     */
    public function welcomeMessage(): JsonResponse
    {
        $message = WelcomeMessage::where('is_active', true)->first();

        if (!$message) {
            return $this->error('Welcome message not found', 404);
        }

        $data = [
            'name' => $message->name,
            'position' => $message->position,
            'message' => $message->message,
            'photo' => $message->photo ? asset('storage/' . $message->photo) : null,
            'updated_at' => $message->updated_at->toIso8601String(),
        ];

        return $this->success($data, 'Welcome message retrieved successfully');
    }
}

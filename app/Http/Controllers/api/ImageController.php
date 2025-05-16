<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Aws\S3\S3Client;
use Aws\Credentials\Credentials;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function generateUploadUrl(Request $request)
    {
        $request->validate([
            'contentType' => 'required|string',
            'fileSize' => 'required|integer|max:10485760', // 10MB max size
        ]);

        try {
            // Extract file extension from content type
            $extension = explode('/', $request->contentType)[1] ?? 'png';

            // Generate unique filename
            $filename = 'images/' . Str::uuid() . '.' . $extension;

            // Set up AWS S3 client with Cloudflare R2 credentials
            $credentials = new Credentials(
                config('filesystems.disks.r2.key'),
                config('filesystems.disks.r2.secret')
            );

            $s3 = new S3Client([
                'region' => 'auto',
                'version' => 'latest',
                'endpoint' => config('filesystems.disks.r2.endpoint'),
                'use_path_style_endpoint' => true,
                'credentials' => $credentials,
            ]);

            // Get bucket name from config
            $bucketName = config('filesystems.disks.r2.bucket');

            if (empty($bucketName)) {
                throw new \Exception("Bucket name is empty or not set");
            }

            // Create a pre-signed URL for uploading
            $cmd = $s3->getCommand('PutObject', [
                'Bucket' => $bucketName,
                'Key' => $filename,
                'ContentType' => $request->contentType,
                'ACL' => 'public-read',
            ]);

            // Generate pre-signed request (valid for 30 minutes)
            $presignedRequest = $s3->createPresignedRequest($cmd, '+30 minutes');

            return response()->json([
                'uploadUrl' => (string) $presignedRequest->getUri(),
                'publicUrl' => 'https://media.sellup.pk' . '/' . $filename, // Use MEDIA_URL from .env
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to generate upload URL', 'message' => $e->getMessage()], 500);
        }
    }
}

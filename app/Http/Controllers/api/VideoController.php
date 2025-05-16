<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Aws\S3\S3Client;
use Aws\Credentials\Credentials;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function generateVideoUploadUrl(Request $request)
    {
        $request->validate([
            'contentType' => 'required|string',
            'fileSize' => 'required|integer|max:104857600', // 100MB limit
        ]);

        try {
            // Extract file extension from content type
            $extension = explode('/', $request->contentType)[1] ?? 'mp4';

            // Generate unique filename
            $filename = 'videos/' . Str::uuid() . '.' . $extension;

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

            // Create a pre-signed URL for uploading
            $cmd = $s3->getCommand('PutObject', [
                'Bucket' => $bucketName,
                'Key' => $filename,
                'ContentType' => $request->contentType,
                'ACL' => 'public-read', // Make the video publicly accessible
            ]);

            // Generate pre-signed request (valid for 30 minutes)
            $presignedRequest = $s3->createPresignedRequest($cmd, '+30 minutes');

            return response()->json([
                'uploadUrl' => (string) $presignedRequest->getUri(),
                'publicUrl' => 'https://media.sellup.pk/' . $filename,
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to generate video upload URL', 'message' => $e->getMessage()], 500);
        }
    }
}

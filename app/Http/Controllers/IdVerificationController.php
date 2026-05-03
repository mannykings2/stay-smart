<?php

namespace App\Http\Controllers;

use App\Models\IdVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IdVerificationController extends Controller
{
    /**
     * Upload an ID document for verification.
     * Available to any authenticated user.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'id_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        $user = Auth::user();

        // Check if user already has a pending verification
        $existing = $user->idVerifications()->where('status', 'pending')->first();
        if ($existing) {
            return redirect()->back()->with('error', 'You already have a pending ID verification request. Please wait for it to be reviewed.');
        }

        $file = $request->file('id_document');
        $extension = strtolower($file->getClientOriginalExtension());
        $originalName = $file->getClientOriginalName();

        // Store in private storage (not publicly accessible)
        $path = $file->store('id-documents/' . $user->id, 'local');

        IdVerification::create([
            'user_id' => $user->id,
            'document_path' => $path,
            'document_type' => $extension,
            'original_filename' => $originalName,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Your ID document has been submitted for verification. You will be notified once it is reviewed.');
    }

    /**
     * List all verification requests (Super Admin only).
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized');
        }

        // Paginate per-status lists separately to avoid loading all records at once.
        $allVerifications = IdVerification::with(['user.roles', 'reviewer'])->latest()->paginate(15, ['*'], 'iv_all');
        $pendingVerifications = IdVerification::with(['user.roles', 'reviewer'])->where('status', 'pending')->latest()->paginate(10, ['*'], 'iv_pending');
        $verifiedVerifications = IdVerification::with(['user.roles', 'reviewer'])->where('status', 'verified')->latest()->paginate(10, ['*'], 'iv_verified');
        $rejectedVerifications = IdVerification::with(['user.roles', 'reviewer'])->where('status', 'rejected')->latest()->paginate(10, ['*'], 'iv_rejected');

        return view('admin.id-verification.index', compact(
            'allVerifications',
            'pendingVerifications',
            'verifiedVerifications',
            'rejectedVerifications'
        ));
    }

    /**
     * Show a specific verification request (Super Admin only).
     */
    public function show(IdVerification $verification)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized');
        }

        $verification->load(['user.roles', 'reviewer']);

        return view('admin.id-verification.show', compact('verification'));
    }

    /**
     * Download/view the uploaded document (Super Admin only).
     */
    public function download(IdVerification $verification)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized');
        }

        if (!Storage::disk('local')->exists($verification->document_path)) {
            abort(404, 'Document not found.');
        }

        return Storage::disk('local')->download(
            $verification->document_path,
            $verification->original_filename
        );
    }

    /**
     * View the document inline in the browser (Super Admin only).
     */
    public function preview(IdVerification $verification)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized');
        }

        if (!Storage::disk('local')->exists($verification->document_path)) {
            abort(404, 'Document not found.');
        }

        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
        ];

        $mime = $mimeTypes[$verification->document_type] ?? 'application/octet-stream';

        return response(Storage::disk('local')->get($verification->document_path))
            ->header('Content-Type', $mime)
            ->header('Content-Disposition', 'inline; filename="' . $verification->original_filename . '"');
    }

    /**
     * Approve/verify an ID document (Super Admin only).
     */
    public function verify(IdVerification $verification)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized');
        }

        if (!$verification->isPending()) {
            return redirect()->back()->with('error', 'This verification request has already been reviewed.');
        }

        $verification->update([
            'status' => 'verified',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        // Update the user's id_verified_at timestamp
        $verification->user->update([
            'id_verified_at' => now(),
        ]);

        return redirect()->route('admin.id-verification.index')
            ->with('success', $verification->user->first_name . ' ' . $verification->user->last_name . '\'s ID has been verified successfully.');
    }

    /**
     * Reject an ID document (Super Admin only).
     */
    public function reject(Request $request, IdVerification $verification)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        if (!$verification->isPending()) {
            return redirect()->back()->with('error', 'This verification request has already been reviewed.');
        }

        $verification->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        // Clear the user's id_verified_at if previously verified
        $verification->user->update([
            'id_verified_at' => null,
        ]);

        return redirect()->route('admin.id-verification.index')
            ->with('success', $verification->user->first_name . ' ' . $verification->user->last_name . '\'s ID verification has been rejected.');
    }
}

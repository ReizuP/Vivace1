@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Contact Us</h1>
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('contact.send') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea name="message" class="form-control" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
        <div class="col-md-6">
            <h4>Visit Our Store</h4>
            <p><i class="fas fa-map-marker-alt"></i> 123 Music Street, Manila, Philippines</p>
            <p><i class="fas fa-phone"></i> (02) 1234-5678</p>
            <p><i class="fas fa-envelope"></i> info@vivace.com</p>
            <h4 class="mt-4">Business Hours</h4>
            <p>Monday - Saturday: 9:00 AM - 7:00 PM<br>Sunday: 10:00 AM - 5:00 PM</p>
        </div>
    </div>
</div>
@endsection
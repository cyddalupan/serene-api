@extends('layouts.app')

@section('title', 'Support')

@section('content')
    <h1>Support</h1>
    <p class="updated">We're here to help.</p>

    <p>
        Serene is an employee development platform used by companies and their
        employees. If something isn't working — or you have a question about how
        the app works — you're in the right place.
    </p>

    <h2>Quick Help</h2>
    <div class="card-row">
        <div class="card">
            <h3>🔑 Sign-in issues</h3>
            <p>Make sure you're using the account provided by your employer, and that your device has a working internet connection for the initial login.</p>
        </div>
        <div class="card">
            <h3>🔄 Sync problems</h3>
            <p>Serene is designed to work offline. If data isn't syncing, reconnect to the internet and open the app — synchronization runs automatically.</p>
        </div>
        <div class="card">
            <h3>📚 Training &amp; quests</h3>
            <p>Training, quests, and habits are assigned by your company's administrators. Contact them if something is missing or looks incorrect.</p>
        </div>
        <div class="card">
            <h3>📊 Report an issue</h3>
            <p>Found a bug or something that doesn't look right? Tell us what happened and what you expected — details help us fix it faster.</p>
        </div>
    </div>

    <h2>Contact Us</h2>
    <p>Reach out any time — we typically respond within one business day.</p>
    <div class="contact-box">
        <strong>Support email:</strong> <code>support@toybits.cloud</code><br>
        <strong>For employees:</strong> your company's administrator is the fastest first point of contact for account and assignment questions.<br>
        <strong>For administrators:</strong> include your company name and the affected account details when writing in.
    </div>

    <h2>Service Status</h2>
    <p>
        We monitor the platform continuously. Scheduled maintenance and any
        service incidents will be communicated through your company's
        administrator.
    </p>
@endsection
